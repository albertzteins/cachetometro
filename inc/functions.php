<?php

function get_header($title = '', $properties = '', $add_to_header = '')
{
  global $current_page;
  
  if (is_array($properties)) {
    $body_style = isset($properties['body-style']) ? $properties['body-style'] : '';
  } else {
    $body_style = $properties ?: '';
  }
  include 'views/header.php';
}

function get_footer($add_to_footer = '')
{
  include 'views/footer.php';
}

function getFormValue($name)
{
  if (isset($_POST[$name]))
    return $_POST[$name];
  else
    return false;
}

function redirect($url)
{
  header("Location: " . $url);
}

?>