<?php

$include = ERROR_PAGE;

$banner_error = false;
$banner_success = false;

if ($user->isLoggedIn() && $action == 'nuevo' && !$banner_id)
{
  
  if (!empty($_FILES))
  {
    require_once 'models/Banner.class.php';
    
    $random_number = mt_rand(0, 99999);
    $image_name = time() . '_' . str_pad($random_number, 5, '0', STR_PAD_LEFT) . '.jpg';
    
    $banner = new Banner();
    
    $banner->setTitle(getFormValue('title'));
    $banner->setDate(date(MYSQL_DATETIME));
    $banner->setImage($image_name);
    $banner->setLink(getFormValue('link'));
    $banner->setPosition(getFormValue('position'));
    
    if ($banner->save())
    {
      $temp_file = $_FILES['image']['tmp_name'];
      
      if (move_uploaded_file($temp_file, 'views/banners/' . $image_name))
        $banner_success = true;
      else
        $banner_success = false;
    }
    else
    {
      $banner_error = true;
    }
    
  }
  
  $include = 'views/banner-new.php';
  
}
elseif ($user->isLoggedIn() && $action == 'eliminar' && ctype_digit($banner_id))
{
  
  require_once 'models/Banner.class.php';
  
  if (isset($_GET['true']))
  {
    if (Banner::deleteBannerWithId((int)$banner_id))
      $banner_success = true;
    else
      $banner_error = true;
  }
  
  $include = 'views/banner-delete.php';
  
}

include $include;

?>