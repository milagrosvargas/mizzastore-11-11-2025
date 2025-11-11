<?php
require_once 'core/Sesion.php';
require_once 'models/EnvioModel.php';

class CheckoutController
{
    private $envioModel;

    public function __construct()
    {
        $this->envioModel = new EnvioModel();
    }

    // ==========================================================
    // 🧩 VALIDAR SESIÓN ANTES DEL CHECKOUT
    // ==========================================================
    public function validarSesion()
    {
        header('Content-Type: application/json; charset=utf-8');
        Sesion::iniciar();

        try {
            $usuario = Sesion::obtenerUsuario();

            // 🔒 Verifica login y perfil válido (no invitado)
            if (
                !$usuario ||
                empty($usuario['id_usuario']) ||
                (isset($usuario['relacion_perfil']) && (int)$usuario['relacion_perfil'] === 5)
            ) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Debe iniciar sesión para continuar con la compra.'
                ]);
                return;
            }

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("Error validando sesión: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error interno al validar sesión.'
            ]);
        }
    }

    // ==========================================================
    // 🚚 REGISTRAR MÉTODO DE ENVÍO SELECCIONADO
    // ==========================================================
    public function seleccionarEnvio()
    {
        header('Content-Type: application/json; charset=utf-8');
        Sesion::iniciar();

        try {
            $tipoEnvio = $_POST['tipo_envio'] ?? null;
            $idDomicilio = $_POST['id_domicilio'] ?? null;

            if (!$tipoEnvio || !in_array($tipoEnvio, ['retiro', 'domicilio'])) {
                echo json_encode(['success' => false, 'message' => 'Tipo de envío inválido.']);
                return;
            }

            if ($tipoEnvio === 'domicilio' && empty($idDomicilio)) {
                echo json_encode(['success' => false, 'message' => 'Debe seleccionarse un domicilio válido.']);
                return;
            }

            $this->envioModel->guardarSeleccionTemporal($tipoEnvio, $idDomicilio);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("Error seleccionando envío: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al guardar la selección de envío.']);
        }
    }

    // ==========================================================
    // 💳 VISTA DE PAGO
    // ==========================================================
    public function pago()
    {
        Sesion::iniciar();

        if (!Sesion::usuarioAutenticado()) {
            header('Location: index.php?controller=Login&action=index');
            exit;
        }

        $vista = 'views/checkout/pago.php';
        require_once 'views/layouts/main.php';
    }

    // ==========================================================
    // 🏠 OBTENER DOMICILIO DEL USUARIO AUTENTICADO
    // ==========================================================
    public function obtenerDomicilio()
    {
        header('Content-Type: application/json; charset=utf-8');
        Sesion::iniciar();

        try {
            $usuario = Sesion::obtenerUsuario();

            if (!$usuario || empty($usuario['id_usuario'])) {
                echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
                return;
            }

            // 🔹 Ahora el modelo obtiene desde persona → domicilio → barrio → localidad → provincia → país
            $domicilio = $this->envioModel->obtenerDomicilioPorUsuario((int)$usuario['id_usuario']);

            if ($domicilio) {
                echo json_encode(['success' => true, 'data' => $domicilio]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se encontró domicilio registrado.']);
            }
        } catch (Exception $e) {
            error_log("Error obteniendo domicilio: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al obtener el domicilio del usuario.']);
        }
    }
}
