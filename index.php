<?php
header ('Content-type: text/html; charset=utf-8');

# Includes
require_once 'inc/config.php';
require_once 'inc/constants.php';
require_once 'inc/functions.php';
require_once 'controllers/RootController.php';
require_once 'models/User.class.php';

if (DEVELOPMENT) error_reporting(E_ALL | E_STRICT);
else error_reporting(0);

# Set dabatase
try {
  $pdo_options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
  );
  $db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=UTF8', MYSQL_USER, MYSQL_PASS, $pdo_options);
} catch (PDOException $e) {
  if (DEVELOPMENT) print 'Error: ' . $e->getMessage() . '<br />' . chr(10);
  else echo 'There was an error with the database.' . chr(10);
  die();
}

# Start the user class and get the user if he is logged in
$user = User::getLoggedUser();

# Get player (user)
require 'src/facebook.php';
require 'models/Player.class.php';
// Start a new session
session_start();
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
$fb_logout_params = array(
  'next' => SITE_URI . '/controllers/DestroySessionController.php'
);
$fb_log_url = $fb_user ? $facebook->getLogoutUrl($fb_logout_params) : $facebook->getLoginUrl($fb_login_params);

// Set the new player info
$player = new Player($fb_id, $fb_user);

# Set the site's URI, name, index page and error page
$root = new RootController(SITE_URI, SITE_NAME, 'controllers/HomeController.php', ERROR_PAGE);

# User pages
$root->addPageHandler('legal', 'views/legal.php');
$root->addPageHandler('login', 'controllers/UserLoginController.php', array(1 => 'action'));
$root->addPageHandler('banner', 'controllers/BannerController.php', array(1 => 'action', 2 => 'banner_id'));
$root->addPageHandler('publicar', 'controllers/PublishScoreController.php');

$file_to_include = $root->getFileToInclude();
$current_page = $root->getCurrentPage();
require $file_to_include;

# Close database connection
$db = null;
?>
