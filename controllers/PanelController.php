<?php
require_once 'core/Sesion.php';
require_once 'core/ModuloHelper.php';
require_once 'core/DashboardHelper.php';

class PanelController
{
    public function dashboard()
    {
        // 🔒 Requiere sesión activa (redirige al login si no lo está)
        Sesion::requerirLogin();

        // 🔹 Obtener información del usuario actual desde la sesión
        $usuario = Sesion::obtenerUsuario();

        $usuarioNombre      = $usuario['nombre_usuario'] ?? 'Invitado';
        $perfilDescripcion  = $usuario['descripcion_perfil'] ?? null;
        $perfilId           = $usuario['relacion_perfil'] ?? null;

        // ============================================================
        // Validaciones de sesión y perfil
        // ============================================================
        if (empty($perfilDescripcion) || empty($perfilId)) {
            echo "<div class='alert alert-danger text-center mt-4'>
            ❌ Error: el perfil del usuario no está definido o es inválido.
            </div>";
            exit;
        }

        // ============================================================
        // Cargar los módulos autorizados para este perfil
        // ============================================================
        $modulos = ModuloHelper::obtenerModulosAutorizados($perfilId);

        // ============================================================
        // Obtener dashboard según el perfil
        // ============================================================
        $contenido = DashboardHelper::obtenerDashboardPorPerfil($perfilDescripcion);

        if (!$contenido || !file_exists($contenido)) {
            echo "<div class='alert alert-warning text-center mt-4'>
            ⚠️ El contenido del panel no está disponible para el perfil <b>{$perfilDescripcion}</b>.
            </div>";
            exit;
        }

        // ============================================================
        // Preparar datos para la vista principal
        // ============================================================
        $titulo = "Panel de inicio | MizzaStore";
        $vista  = $contenido;

        // ============================================================
        // Renderizar el layout principal (views/layouts/main.php)
        // ============================================================
        require_once 'views/layouts/main.php';
    }
}
