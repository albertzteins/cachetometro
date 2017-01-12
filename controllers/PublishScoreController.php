<?php

// Get the values and sum them to the total
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

if (!$cheating && ($score_pena || $score_mota || $score_amlo))
{
  
  // Update session values
  $_SESSION['cachetadas']['pena'] = $_SESSION['cachetadas']['pena'] + $score_pena;
  $_SESSION['cachetadas']['mota'] = $_SESSION['cachetadas']['mota'] + $score_mota;
  $_SESSION['cachetadas']['amlo'] = $_SESSION['cachetadas']['amlo'] + $score_amlo;
  
  // Update database
  /*
  $query = "UPDATE candidatos
            SET pena = pena + " . $score_pena . ", mota = mota + " . $score_mota . ", amlo = amlo + " . $score_amlo . "
            WHERE id = 1
            LIMIT 1;";
  $res = mysql_query($query);
  */
  $sth = $db->prepare("UPDATE candidatos
                        SET pena = pena + :pena, mota = mota + :mota, amlo = amlo + :amlo
                        WHERE id = 1
                        LIMIT 1");
  $sth->bindParam(':pena', $score_pena);
  $sth->bindParam(':mota', $score_mota);
  $sth->bindParam(':amlo', $score_amlo);
  
  $sth->execute();
}

// If the user is LoggedIn, update his score and publish it to facebook
// if he is not, then redirect him to the Facebook Auth page.

if ($player->isLoggedIn())
{
  
  $score_pena = $_SESSION['cachetadas']['pena'];
  $score_mota = $_SESSION['cachetadas']['mota'];
  $score_amlo = $_SESSION['cachetadas']['amlo'];
  unset($_SESSION['cachetadas']); // Reset score
  
  // Update player's score in the database
  $player->updateScore((int)$score_pena, (int)$score_mota, (int)$score_amlo);
  
  // Publish stream on Facebook
  $fb_message = 'Acabo de cachetear:' . chr(10);
  $fb_message .= ($score_pena ?: 0) . ' ' . ($score_pena == 1 ? 'vez' : 'veces') . ' a Enrique Peña Nieto' . chr(10);
  $fb_message .= ($score_mota ?: 0) . ' ' . ($score_mota == 1 ? 'vez' : 'veces') . ' a Josefina Vázquez Mota' . chr(10);
  $fb_message .= ($score_amlo ?: 0) . ' ' . ($score_amlo == 1 ? 'vez' : 'veces') . ' a Andrés Manuel López Obrador' . chr(10);
  
  $attachment = array(
    'message' => $fb_message,
    'name' => 'Cachetometro',
    // 'caption' => 'Caption of Cachetometro.com',
    'link' => 'http://www.cachetometro.com/',
    'description' => '¿Qué candidato merece una cachetada? Castiga los candidatos en el Cachetómetro, la encuesta alternativa. http://www.cachetometro.com/',
    'picture' => 'http://www.cachetometro.com/views/images/cachetometro_sharefacebook.jpg'
  );
  $facebook->api('/me/feed/', 'post', $attachment);
  
  redirect('/?published=true');
  
}
else
  redirect($fb_log_url);

?>