<div class="login-container">
    <div class="login-form">
        <h1>MizzaStore</h1>
        <h2>Establecer nueva contraseña</h2>

        <form id="formNuevaContrasena" autocomplete="off" novalidate>
            <input type="hidden" id="token" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

            <div class="mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Nueva contraseña" required>
            </div>
            <div class="mb-3">
                <input type="password" id="password2" name="password2" class="form-control" placeholder="Confirmar contraseña" required>
            </div>

            <button type="submit" class="btn-login">Actualizar contraseña</button>
        </form>

        <div class="extra-links">
            <a href="index.php?controller=Login&action=login">Volver al inicio de sesión</a>
        </div>
    </div>

    <div class="login-banner">
        <img src="/MizzaStore/assets/images/logo_mizzastore.png" alt="Logo MizzaStore">
        <h3>Restablecé tu acceso</h3>
        <p>Ingresá una nueva contraseña segura para tu cuenta.</p>
        <a href="index.php?controller=Home&action=index" class="btn-volver-inicio">Volver al inicio</a>
    </div>
</div>

<!-- Scripts -->
<script type="module" src="/MizzaStore/assets/js/nueva_contrasena.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>