<?php get_header('Eliminar banner'); ?>
<?php if($banner_error): ?>
  <p class="alert error">No se pudo eliminar el banner, inténtalo más tarde.</p>
<?php elseif($banner_success): ?>
  <p class="alert">El banner se ha eliminado.</p>
<?php else: ?>
<form id="campaign-delete" action="" method="get">
  <input type="hidden" name="true" value="1" />
  <p>
    ¿Estás seguro que deseas eliminar el banner?
    <input type="submit" value="Sí, eliminar el banner" />
  </p>
</form>
<?php endif; ?>
<?php get_footer(); ?>