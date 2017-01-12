<?php get_header('Iniciar sesión'); ?>
<?php if($login_error): ?>
  <p class="alert error">
    Usuario o contraseña incorrectos.
  </p>
<?php endif; ?>
  <form id="user-login" method="post">
    <label for="username">Usuario:</label>
    <input type="text" class="large" name="username" value="<?=isset($_POST['username']) ? $_POST['username'] : ''?>" />
    <br />
    <label for="password">Clave:</label>
    <input type="password" class="large" name="password" />
    <br />
    <input type="submit" class="publish" name="submit" value="Iniciar sesión" />
  </form>
<?php get_footer(); ?>
