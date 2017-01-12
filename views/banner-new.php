<?php get_header('Agregar nuevo banner'); ?>
<?php if($banner_error): ?>
  <p class="alert error">No se pudo agregar el banner, inténtalo más tarde.</p>
<?php elseif($banner_success): ?>
  <p class="alert">El banner se ha agregado.</p>
<?php else: ?>
<form id="campaign-delete" action="" method="post" enctype="multipart/form-data">
  <label for="image">Imagen</label>
  <input type="file" name="image" class="large" />
  <br />
  <label for="title">Título</label>
  <input type="text" name="title" class="large" />
  <br />
  <label for="link">URL</label>
  <input type="text" name="link" class="large" />
  <br style="clear: both;" />
  <label for="position">Posición</label>
  <select name="position">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">Sidebar</option>
  </select>
  <input type="submit" value="Agregar nuevo banner" />
</form>
<?php endif; ?>
<?php get_footer(); ?>