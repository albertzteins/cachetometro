<?php

session_start();

require 'inc/config.php';

$dbh = mysql_connect (MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db (MYSQL_DB);

$cheating = false;

$score_pena = 0;
if (isset($_POST['pena']) && ctype_digit($_POST['pena']))
{
  if ($_POST['pena'] < 30)
    $score_pena = $_POST['pena'];
  else
    $cheating = true;
}

$score_mota = 0;
if (isset($_POST['mota']) && ctype_digit($_POST['mota']))
{
  if ($_POST['mota'] < 30)
    $score_mota = $_POST['mota'];
  else
    $cheating = true;
}

$score_amlo = 0;
if (isset($_POST['amlo']) && ctype_digit($_POST['amlo']))
{
  if ($_POST['amlo'] < 30)
    $score_amlo = $_POST['amlo'];
  else
    $cheating = true;
}

if (!$cheating)
{
  $returnVars = array();
  
  if ($score_pena || $score_mota || $score_amlo) // If there's input data...
  {
    // Update session values
    $_SESSION['cachetadas']['pena'] = $_SESSION['cachetadas']['pena'] + $score_pena;
    $_SESSION['cachetadas']['mota'] = $_SESSION['cachetadas']['mota'] + $score_mota;
    $_SESSION['cachetadas']['amlo'] = $_SESSION['cachetadas']['amlo'] + $score_amlo;
    
    // Update database
    $query = "UPDATE candidatos
              SET pena = pena + " . $score_pena . ", mota = mota + " . $score_mota . ", amlo = amlo + " . $score_amlo . "
              WHERE id = 1
              LIMIT 1;";
    $res = mysql_query($query);
  }
  
  if (isset($_POST['publicar']) && $_POST['publicar'] === "true")
  {
    # Get player (user)
    require 'inc/functions.php';
    require 'src/facebook.php';
    require 'models/Player.class.php';
    // Create our Application instance (replace this with your appId and secret).
    $facebook = new Facebook(array(
      'appId'  => '178978932230427',
      'secret' => '704f877b0701c32e8d0ed9b23d14f963'
    ));
    // Get User ID
    $fb_id = $facebook->getUser();
    // We may or may not have this data based on whether the user is logged in.
    //
    // If we have a $fb_id here, it means we know the user is logged into
    // Facebook, but we don't know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.
    $fb_user = null;
    if ($fb_id) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $fb_user = $facebook->api('/me');
      } catch (FacebookApiException $e) {
        error_log($e);
        $fb_id = null;
      }
    }

    $fb_login_params = array(
      'scope' => 'publish_stream, email'
    );
    $fb_log_in = $facebook->getLoginUrl($fb_login_params);

    // Set the new player info
    $player = new Player($fb_id, $fb_user);
    if ($player->isLoggedIn())
    {
      // Get the score from the Session and reset it
      $score_pena = $_SESSION['cachetadas']['pena'];
      $score_mota = $_SESSION['cachetadas']['mota'];
      $score_amlo = $_SESSION['cachetadas']['amlo'];
      unset($_SESSION['cachetadas']);
      
      // Update player's score in the database
      $player->updateScore((int)$score_pena, (int)$score_mota, (int)$score_amlo);
      
      // Publich player's score on Facebook
      $placer->publishOnFacebook($facebook, (int)$score_pena, (int)$score_mota, (int)$score_amlo);
    }
    else
      $returnVars['isLoggedIn'] = false;
    // else
    // {
    //   redirect($fb_log_in);
    // }
  }
  
  	
  $query = "SELECT pena,mota,amlo FROM candidatos WHERE id = 1 LIMIT 1";
  $res = mysql_query($query);
  $fila = mysql_fetch_assoc($res);
  
  $returnVars['pena'] = $fila['pena'];
  $returnVars['mota'] = $fila['mota'];
  $returnVars['amlo'] = $fila['amlo'];
  $returnString = http_build_query($returnVars);
  echo $returnString;
}
else
{
  echo '¡FRAUDE! Se anularon tus cachetadas. ¡VOTO POR VOTO! ¡CACHETADA POR CACHETADA!';
}

mysql_close($dbh);

?>