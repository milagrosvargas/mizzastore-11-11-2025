<?php
require_once 'core/Sesion.php';
require_once 'models/ModuloModel.php';
require_once 'core/ModuloHelper.php';

// Asegura que la sesión esté inicializada (crea perfil "Invitado" si no existe)
Sesion::inicializarInvitado();
// Obtiene información del usuario
$perfil_id = Sesion::obtenerPerfil();
$usuario = Sesion::obtenerUsuario();

// Definir módulos disponibles para la vista
if (!isset($modulos)) {
    if (Sesion::usuarioAutenticado()) {
        // Según su perfil y permisos del acceso interno
        $modulos = ModuloHelper::obtenerModulosAutorizados();
    } else {
        // Invitado → módulos públicos visibles de la web externa
        $modulos = ['Home', 'Cósmeticos', 'Blog externo', 'Sobre nosotros'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MizzaStore</title>

    <!-- ========================================================= -->
    <!-- Ícono global del sitio -->
    <!-- ========================================================= -->
    <link rel="icon" href="/MizzaStore/assets/images/logo2.png" type="image/png">

    <!-- ========================================================= -->
    <!-- Tipografía global -->
    <!-- ========================================================= -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Frameworks y librerías -->

    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->

    <!-- Estilo para el menú de navegación con Bootstrap -->
    <link rel="stylesheet" href="/MizzaStore/assets/css/navbar.css">

</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Navbar -->
    <?php require_once 'views/layouts/navbar.php'; ?>

    <!-- Contenido dinámico -->

    <main class="flex-grow-1 container-fluid py-4">
        <?php
        if (isset($vista) && file_exists($vista)) {
            require_once $vista;
        } else {
            echo "<div class='alert alert-danger text-center'>
            Ocurrió un error...
            </div>";
        }
        ?>
    </main>

    <!-- Footer -->
    <?php require_once 'views/layouts/footer.php'; ?>

    <!-- Scripts -->

    <!-- Bootstrap JS (con Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const carritoLink = document.querySelector('.carrito-link');
    if (!carritoLink) return;

    // 🔴 Crear el contador visual si no existe
    let contador = carritoLink.querySelector('.carrito-contador');
    if (!contador) {
        contador = document.createElement('span');
        contador.classList.add('carrito-contador');
        carritoLink.appendChild(contador);
    }

    // 🧠 Obtener carrito desde localStorage
    function obtenerCarrito() {
        try {
            return JSON.parse(localStorage.getItem('carritoMizza')) || [];
        } catch {
            return [];
        }
    }

    // 🔁 Actualizar contador visual
    function actualizarContadorNavbar() {
        const carrito = obtenerCarrito();
        const total = carrito.reduce((sum, item) => sum + item.cantidad, 0);
        contador.textContent = total;
        contador.style.display = total > 0 ? 'flex' : 'none';
    }

    // 🌎 Exponer globalmente para otras vistas (carrito, catálogo)
    window.actualizarContadorNavbar = actualizarContadorNavbar;

    // 📢 Escuchar eventos globales cuando cambie el carrito
    document.addEventListener('carrito:actualizado', actualizarContadorNavbar);

    // 🚀 Inicializar al cargar la página
    actualizarContadorNavbar();
});
</script>

</body>

</html>