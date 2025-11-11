<?php
require_once 'core/Sesion.php';
require_once 'models/ProductosModel.php';

class CarritoController
{
    private $session;
    private $productoModel;

    public function __construct()
    {
        // 🧠 Mantiene compatibilidad total con tu clase Sesion y modelo existente
        $this->session = new Sesion();
        $this->productoModel = new ProductosModel();
    }

    /**
     * 🛒 Vista principal del carrito
     */
    public function ver()
    {
        Sesion::iniciar();
        Sesion::inicializarInvitado();

        $carrito = $this->session->get('carrito') ?? [];
        $vista = 'views/carrito/ver.php';
        require_once 'views/layouts/main.php';
    }

    /**
     * ➕ Agregar producto al carrito (AJAX)
     */
    public function agregar()
    {
        header('Content-Type: application/json');

        $id = $_POST['id_producto'] ?? null;
        $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;

        if (!$id || $cantidad < 1) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            return;
        }

        // 🔍 Obtener producto
        $producto = $this->productoModel->obtenerProductoPorId((int)$id);
        if (!$producto) {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
            return;
        }

        // ✅ Validar estado de venta
        if (!in_array($producto['id_estado_logico'], [8, 9, 10])) {
            echo json_encode(['success' => false, 'message' => 'Producto no disponible para la venta']);
            return;
        }

        // 🧾 Obtener stock desde la BD con seguridad
        $stockActual = $this->productoModel->obtenerStockPorId((int)$id);

        // Si el modelo devolvió null o 0, tratamos como sin stock
        if ($stockActual <= 0) {
            echo json_encode(['success' => false, 'message' => 'El producto no tiene stock disponible.']);
            return;
        }

        // 🛒 Obtener carrito actual de sesión
        $carrito = $this->session->get('carrito') ?? [];

        // Si ya existe el producto, aumentamos cantidad validando stock
        if (isset($carrito[$id])) {
            $nuevaCantidad = $carrito[$id]['cantidad'] + $cantidad;

            if ($nuevaCantidad > $stockActual) {
                echo json_encode([
                    'success' => false,
                    'message' => "Stock insuficiente. Solo hay {$stockActual} unidades disponibles."
                ]);
                return;
            }

            $carrito[$id]['cantidad'] = $nuevaCantidad;
        } else {
            // Validar que la cantidad inicial no supere el stock disponible
            if ($cantidad > $stockActual) {
                echo json_encode([
                    'success' => false,
                    'message' => "Stock insuficiente. Solo hay {$stockActual} unidades disponibles."
                ]);
                return;
            }

            // ✅ Nuevo producto al carrito
            $carrito[$id] = [
                'id_producto' => $producto['id_producto'],
                'nombre'      => $producto['nombre_producto'],
                'precio'      => (float)$producto['precio_venta'],
                'imagen'      => $producto['imagen_producto'] ?: 'assets/images/no-image.png',
                'cantidad'    => $cantidad,
                'stock'       => $stockActual
            ];
        }

        // 💾 Actualizamos carrito en sesión
        $this->session->set('carrito', $carrito);

        echo json_encode([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'carrito' => $carrito
        ]);
    }

    /**
     * ➖ Eliminar producto del carrito
     */
    public function eliminar()
    {
        header('Content-Type: application/json');

        $id = $_POST['id_producto'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
            return;
        }

        $carrito = $this->session->get('carrito') ?? [];

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            $this->session->set('carrito', $carrito);
            echo json_encode(['success' => true, 'message' => 'Producto eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
        }
    }

    /**
     * ♻️ Actualizar cantidad de un producto
     */
    public function actualizar()
    {
        header('Content-Type: application/json');

        $id = $_POST['id_producto'] ?? null;
        $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;

        if (!$id || $cantidad < 1) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            return;
        }

        $carrito = $this->session->get('carrito') ?? [];

        if (!isset($carrito[$id])) {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
            return;
        }

        // ✅ Validar stock actual antes de actualizar
        $stockActual = $this->productoModel->obtenerStockPorId((int)$id);
        if ($stockActual <= 0) {
            echo json_encode(['success' => false, 'message' => 'Producto sin stock disponible.']);
            return;
        }

        if ($cantidad > $stockActual) {
            echo json_encode(['success' => false, 'message' => "Stock insuficiente. Solo hay {$stockActual} unidades."]);
            return;
        }

        $carrito[$id]['cantidad'] = $cantidad;
        $this->session->set('carrito', $carrito);

        echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
    }

    /**
     * 🧹 Vaciar carrito completo
     */
    public function vaciar()
    {
        header('Content-Type: application/json');
        $this->session->remove('carrito');
        echo json_encode(['success' => true, 'message' => 'Carrito vaciado']);
    }

    /**
     * 📦 Obtener contenido del carrito (AJAX)
     */
    public function obtener()
    {
        header('Content-Type: application/json');
        $carrito = $this->session->get('carrito') ?? [];
        echo json_encode([
            'success' => true,
            'carrito' => $carrito,
            'total' => $this->calcularTotal($carrito)
        ]);
    }

    /**
     * 💰 Calcular el total del carrito
     */
    private function calcularTotal($carrito)
    {
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return number_format($total, 2, '.', '');
    }

    /**
     * 🔢 Contador de productos (para navbar)
     */
    public function contar()
    {
        header('Content-Type: application/json');
        $carrito = $this->session->get('carrito') ?? [];
        $cantidad = 0;
        foreach ($carrito as $item) {
            $cantidad += $item['cantidad'];
        }
        echo json_encode(['success' => true, 'cantidad' => $cantidad]);
    }
}
