<?php

session_start();
session_destroy();

require '../inc/functions.php';

redirect('/');

?>