<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Cachetometro | toppli.com</title>
  <link rel="stylesheet" href="/views/style.css" type="text/css" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="Cachetometro" />
  <meta property="og:description" content="¿Qué candidato merece una cachetada? Castiga los candidatos en el Cachetómetro, la encuesta alternativa. http://www.cachetometro.com/" />
  <meta property="og:image" content="http://www.cachetometro.com/views/images/cachetometro_sharefacebook.jpg" />
  <meta property="fb:app_id" content="178978932230427" />
</head>
<body>
<?php if(!DEVELOPMENT): ?>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '178978932230427', // App ID
        channelUrl : '//www.cachetometro.com/channel.php', // Channel File
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
      });

      // Additional initialization code here
    };

    // Load the SDK Asynchronously
    (function(d){
       var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement('script'); js.id = id; js.async = true;
       js.src = "//connect.facebook.net/en_US/all.js";
       ref.parentNode.insertBefore(js, ref);
     }(document));
  </script>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=178978932230427";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>
  <div id="wrapper">
<?php if (isset($_GET['published']) && $_GET['published']): ?>
    <div id="fb-alert">¡Se han publicado tus cachetadas en Facebook!</div>
<?php elseif (isset($_GET['published']) && $_GET['published'] == false): ?>
    <div id="fb-alert">Hubo un error y no pudieron publicarse tus cachetadas en Facebook</div>
<?php endif; ?>
    <div id="header">
      <h1 id="logo"><span>toppli</span></h1>
<?php if($user->isLoggedIn()): ?>
      <div id="nav">
        <a href="/banner/nuevo/">Agregar nuevo banner</a> | <a href="/login/logout/">Cerrar sesión</a>
      </div>
<?php endif; ?>
      <div id="trending">
<?php foreach($banners as $banner): ?>
<?php if($banner): ?>
        <div class="banner">
          <a target="_blank" href="<?=$banner->getLink()?>">
            <img src="/views/banners/<?=$banner->getImage()?>" />
            <span><?=$banner->getTitle()?></span>
          </a>
        </div>
<?php endif; ?>
<?php endforeach; ?>
      </div>
    </div>
    <div id="share-bar">
    	<div class="addthis_toolbox ">
        <a class="addthis_button_facebook_share"></a>
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet" tw:count="none"></a>
        <a class="addthis_button_pinterest" pi:pinit:url="http://www.toppli.com/2012/tecnologia/sensu-pincel-interactivo-para-ipad/" pi:pinit:layout="horizontal"></a> 
        <a class="addthis_button_google_plusone" g:plusone:size="tall" g:plusone:count="false" g:plusone:annotation="none"></a>
        <a class="addthis_button_email"><img src="http://www.toppli.com/wp-content/themes/toppli/images/btn-mail.jpg" /></a>
      </div>
    </div>
    <div id="content">
<?php
if ($fb_user) {
?>
      <div id="cachetometro-title" class="logged-in" style="position:relative;">
<?php
} else {
?>
      <div id="cachetometro-title" style="position:relative;">
<?php
}
?>
<?php #if(!DEVELOPMENT): ?>
        <div id="cachetometro-social">
          <!-- <a href="http://www.toppli.com/?homeq=most_viewed&amp;datefilter=_week" id="toppli-top10" target="_blank"><img src="/views/images/toppli-top10.png" /></a> -->
          <div class="fb-like" data-href="http://www.facebook.com/topenred" data-send="false" data-layout="button_count" data-width="115" data-show-faces="false" data-font="lucida grande" style="float:left; width:90px; overflow:hidden; height:32px;"></div>
          <div class="twtr">
              <a href="https://twitter.com/toppli" class="twitter-follow-button" data-show-count="false" data-lang="es" data-show-screen-name="false">Seguir a @toppli</a>
              <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </div>
        </div>
<?php #endif; ?>
<?php if(!$fb_user): ?>
        <div id="facebook-connect">
          <a href="<?=$fb_log_url?>"><img src="/views/images/facebook-connect.png" /></a>
        </div>
<?php
/*
else:
<a href="<?=$fb_log_url?>">Salir</a>
*/
?>
<?php endif; ?>
      </div>
      <div id="flash">
        <object width="960" height="560" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">
          <param name="quality" value="high" />
          <param name="play" value="true" />
          <param name="loop" value="true" />
          <param name="wmode" value="window" />
          <param name="scale" value="showall" />
          <param name="menu" value="true" />
          <param name="devicefont" value="false" />
          <param name="salign" value="" />
          <param name="allowScriptAccess" value="sameDomain" />
          <param name="src" value="/views/cachetometro/cachetometrojunio_publicar2012ok.swf" />
          <embed width="960" height="560" type="application/x-shockwave-flash" src="/views/cachetometro/cachetometrojunio_publicar2012ok.swf" quality="high" play="true" loop="true" wmode="window" scale="showall" menu="true" devicefont="false" salign="" allowScriptAccess="sameDomain" />
        </object>
      </div>
      <!-- Inline Share Bar -->
      <div id="inline-share-bar">
        <div class="addthis_toolbox ">
          <a class="addthis_button_facebook_share"></a>
          <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
          <a class="addthis_button_tweet" tw:count="none"></a>
          <a class="addthis_button_pinterest" pi:pinit:url="http://www.toppli.com/2012/tecnologia/sensu-pincel-interactivo-para-ipad/" pi:pinit:layout="horizontal"></a>
          <a class="addthis_button_google_plusone" g:plusone:size="tall" g:plusone:count="false" g:plusone:annotation="none"></a>
          <a class="addthis_button_email"><img src="http://www.toppli.com/wp-content/themes/toppli/images/btn-mail.jpg" /></a>
        </div>
      </div>
      <!-- / Inline Share Bar -->
      <div id="meta">
        <div class="fb-comments" data-href="http://www.cachetometro.com/" data-num-posts="10" data-width="700"></div>
        <div id="sidebar">
<?php if($banner_sq): ?>
          <div class="banner-sq">
            <a target="_blank" href="<?=$banner_sq->getLink()?>">
              <img src="/views/banners/<?=$banner_sq->getImage()?>" />
            </a>
          </div>
<?php endif; ?>
        </div>
      </div>
    </div> <!-- /content -->
  </div>
<script type='text/javascript' src='/views/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='/views/js/jquery.scrollTo-1.4.2-min.js'></script>
<?php if(!DEVELOPMENT): ?>
<!-- AddThis Buttons BEGIN -->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f43ee79730efd8b"></script>
<!-- AddThis Buttons END -->
<script type="text/javascript">
  if (window.addEventListener) {
    window.addEventListener('load', function() { backgroundLink(); }, false);
    window.addEventListener('load', function() { changeShareBar(); }, false);
  } else if (window.attachEvent) {
    window.attachEvent('onload', function() { backgroundLink(); });
    window.attachEvent('onload', function() { changeShareBar(); });
  }
  var condition = "targ.tagName.toLowerCase() == 'body' || targ.tagName.toLowerCase() == 'html'";
  function backgroundLink() {
    $(document).mousemove(function(e) {
      if (!e) { var e = window.event; }
      var targ;
      if (e.target) { targ = e.target; }
      else if (e.srcElement) { targ = e.srcElement; }
      if (eval(condition)) {
        if ($("html").css("cursor") != 'pointer') { $("html").css("cursor", "pointer"); }
      } else {
        if ($("html").css("cursor") != 'auto') { $("html").css("cursor", "auto"); }
      }
    });
    $(document).click(function(e){
      if (!e) { var e = window.event; }
      var targ;
      if (e.target) { targ = e.target; }
      else if (e.srcElement) { targ = e.srcElement; }
      if (eval(condition)) {
        window.open('http://www.toppli.com/?homeq=wow');
      }
    });
  }
  function changeShareBar() {
    try {
      shareBarPosition = $("#share-bar").offset();
      shareBarOffset = shareBarPosition.top;
      checkWidthForShareBar();
      $(window).scroll(
        function(){
          windowOffset = $(window).scrollTop();
          if(shareBarPosition.top-windowOffset<=20) {
            $("#share-bar").addClass('fixed');
          }else{
            $("#share-bar").removeClass('fixed');
          }
        }
      );
      $(window).resize(function(){
        checkWidthForShareBar()
      });
    }catch(e){
      alert(e);
    }
  }
  function checkWidthForShareBar() {
    windowWidth = $(window).width();
    if(windowWidth<1298) {
      $("#share-bar").hide();
      $("#inline-share-bar").show()
    }else{
      $("#share-bar").show();
      $("#inline-share-bar").hide()
    }
  }
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32346533-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php endif; ?>
</body>
</html>