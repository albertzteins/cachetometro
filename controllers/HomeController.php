<?php

# Get banners
require 'models/Banner.class.php';
$banners[1] = Banner::getBannerForPosition(1);
$banners[2] = Banner::getBannerForPosition(2);
$banners[3] = Banner::getBannerForPosition(3);
$banners[4] = Banner::getBannerForPosition(4);
$banners[5] = Banner::getBannerForPosition(5);

$banner_sq = Banner::getBannerForPosition(6);

include 'views/home.php';

?>