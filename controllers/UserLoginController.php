<?php

$login_error = false;

// If the user is already logged in
if ($user->isLoggedIn())
{
  
  if ($action == 'logout')
  {
    $user->logOut();
  }
  redirect('/');
  die();
  
}
elseif (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password'])
{
  
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $user_login = false;
  try
  {
    $user_login = User::logIn($username, $password);
  }
  catch(Exception $e)
  {
    
  }
  
  if ($user_login)
    redirect('/');
  else
    $login_error = true;
  
}
elseif (isset($_POST['username']) || isset($_POST['password']))
{
  $login_error = true;
}

include('views/login.php');

?>