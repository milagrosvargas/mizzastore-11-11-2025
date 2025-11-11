<?php
// ============================================================
// Archivo: core/Sesion.php
// ------------------------------------------------------------
// Clase encargada de gestionar la sesión de usuario:
//  - Inicia, obtiene y destruye sesiones PHP.
//  - Registra la sesión activa/inactiva en la base de datos.
//  - Mantiene siempre un perfil activo, incluso sin autenticación.
//  - Ahora también gestiona el carrito de compras de forma segura.
// ============================================================

class Sesion
{
    /**
     * Inicia la sesión PHP si aún no está activa.
     */
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Registra al usuario autenticado dentro de la sesión
     * y marca su sesión como activa en la base de datos.
     */
    public static function establecerUsuario(array $usuario)
    {
        self::iniciar();

        // 🔹 Aseguramos claves esperadas para consistencia
        $_SESSION['usuario'] = [
            'id_usuario'         => $usuario['id_usuario']         ?? null,
            'nombre_usuario'     => $usuario['nombre_usuario']     ?? 'Desconocido',
            'relacion_persona'   => $usuario['relacion_persona']   ?? null,
            'relacion_perfil'    => $usuario['relacion_perfil']    ?? 5, // invitado por defecto
            'descripcion_perfil' => $usuario['descripcion_perfil'] ?? 'Invitado'
        ];

        // 🔹 Activar sesión en BD (solo si tiene id_usuario)
        if (!empty($usuario['id_usuario'])) {
            require_once 'models/SesionModel.php';
            $modelo = new SesionModel();
            $modelo->marcarSesionActiva($usuario['id_usuario']);
        }
    }

    /**
     * Devuelve los datos completos del usuario en sesión.
     */
    public static function obtenerUsuario()
    {
        self::iniciar();
        return $_SESSION['usuario'] ?? null;
    }

    /**
     * Verifica si hay un usuario autenticado.
     */
    public static function usuarioAutenticado(): bool
    {
        self::iniciar();
        return isset($_SESSION['usuario']['id_usuario']) &&
               $_SESSION['usuario']['id_usuario'] !== null;
    }

    /**
     * Destruye la sesión actual del usuario.
     */
    public static function destruir()
    {
        self::iniciar();

        // 🔹 Marcar sesión como inactiva en BD (si corresponde)
        if (!empty($_SESSION['usuario']['id_usuario'])) {
            require_once 'models/SesionModel.php';
            $modelo = new SesionModel();
            $modelo->marcarSesionInactiva($_SESSION['usuario']['id_usuario']);
        }

        // 🔹 Limpiar la sesión PHP
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        // 🔹 Reiniciar como invitado
        self::inicializarInvitado();
    }

    /**
     * Redirige al login si el usuario no está autenticado.
     */
    public static function requerirLogin()
    {
        if (!self::usuarioAutenticado()) {
            header("Location: index.php?controller=Login&action=login");
            exit;
        }
    }

    /**
     * Inicializa sesión como "Invitado".
     */
    public static function inicializarInvitado()
    {
        self::iniciar();

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['usuario'] = [
                'id_usuario'         => null,
                'nombre_usuario'     => 'Invitado',
                'relacion_persona'   => null,
                'relacion_perfil'    => 5,
                'descripcion_perfil' => 'Invitado'
            ];
        }
    }

    /**
     * Devuelve el ID del perfil actual.
     */
    public static function obtenerPerfil(): int
    {
        self::iniciar();
        return $_SESSION['usuario']['relacion_perfil'] ?? 5;
    }

    /**
     * Devuelve el nombre descriptivo del perfil.
     */
    public static function obtenerNombrePerfil(): string
    {
        self::iniciar();
        return $_SESSION['usuario']['descripcion_perfil'] ?? 'Invitado';
    }

    // ============================================================
    // 🧩 BLOQUE ADICIONAL: ASEGURAR PERFIL INVITADO
    // ============================================================

    /**
     * Garantiza que siempre haya un perfil (incluso sin login)
     * Ideal para sesiones de carrito o navegación como invitado.
     */
    public static function asegurarInvitado()
    {
        self::iniciar();

        if (empty($_SESSION['usuario'])) {
            $_SESSION['usuario'] = [
                'id_usuario'         => null,
                'nombre_usuario'     => 'Invitado',
                'relacion_persona'   => null,
                'relacion_perfil'    => 5,
                'descripcion_perfil' => 'Invitado'
            ];
        }
    }

    // ============================================================
    // 🛒 BLOQUE DE CARRITO DE COMPRAS
    // ============================================================

    /**
     * Devuelve el carrito actual (array vacío si no existe).
     */
    public static function obtenerCarrito(): array
    {
        self::iniciar();
        return $_SESSION['carrito'] ?? [];
    }

    /**
     * Guarda el carrito completo en sesión.
     */
    public static function guardarCarrito(array $carrito): void
    {
        self::iniciar();
        $_SESSION['carrito'] = $carrito;
    }

    /**
     * Vacía el carrito completamente.
     */
    public static function vaciarCarrito(): void
    {
        self::iniciar();
        unset($_SESSION['carrito']);
    }

    /**
     * Agrega o actualiza un producto en el carrito.
     */
    public static function agregarProducto(array $producto, int $cantidad = 1): void
    {
        self::iniciar();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $id = $producto['id_producto'];

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id] = [
                'id_producto' => $producto['id_producto'],
                'nombre'      => $producto['nombre_producto'],
                'precio'      => (float) $producto['precio_venta'],
                'imagen'      => $producto['imagen_producto'] ?? 'assets/images/no-image.png',
                'cantidad'    => $cantidad
            ];
        }
    }

    /**
     * Elimina un producto específico del carrito.
     */
    public static function eliminarProducto(int $idProducto): void
    {
        self::iniciar();

        if (isset($_SESSION['carrito'][$idProducto])) {
            unset($_SESSION['carrito'][$idProducto]);
        }
    }

    // ============================================================
    // 🔧 MÉTODOS GENÉRICOS DE MANEJO DE SESIÓN
    // ============================================================

    public function set(string $clave, $valor): void
    {
        $_SESSION[$clave] = $valor;
    }

    public function get(string $clave)
    {
        return $_SESSION[$clave] ?? null;
    }

    public function has(string $clave): bool
    {
        return isset($_SESSION[$clave]);
    }

    public function remove(string $clave): void
    {
        if (isset($_SESSION[$clave])) {
            unset($_SESSION[$clave]);
        }
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public function all(): array
    {
        return $_SESSION;
    }
}

