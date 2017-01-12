<?php

class Player
{
  private $id;
  private $fb_id;
  private $mail;
  private $name;
  
  private $fb_info;  
  private $logged_in;
  
  public function __construct($fb_id = null, $fb_info = null)
  {
    $this->fb_id = $fb_id;
    
    $this->fb_info = $fb_info;
    $this->logged_in = false;
    
    if ($fb_info) // We have Facebook Connect info...
    {
      global $db;
      // Populate object data with Facebook data
      $this->mail = $fb_info['email'];
      $this->name = $fb_info['name'];
      
      // Check the database for the Facebook ID
      $sth = $db->prepare("SELECT id
                          FROM " . TABLE_PLAYERS . "
                          WHERE fb_id = :fb_id
                          LIMIT 1");
      $sth->bindParam(':fb_id', $this->fb_id);
      $sth->execute();
      
      if (!$sth->rowCount()) // The player is not in the database yet
      {
        if ($this->registerFacebookPlayer()) // Register Player and set its ID
        {
          $this->registerSession();
        }
      }
      else // The player is already in the database, let's just grab the ID
      {
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $this->id = $result['id'];
        $this->registerSession();
      }
      
    }
    
  }
  
  /* Getters */
  public function getId() { return $this->id; }
  public function getFacebookId() { return $this->fb_id; }
  public function getMail() { return $this->mail; }
  public function getName() { return $this->name; }
  
  public function isLoggedIn() { return $this->logged_in ? true : false; }
  
  /* Public methods */
  public function updateScore($score_pena, $score_mota, $score_amlo)
  {
    global $db;
    
    $sth = $db->prepare("UPDATE " . TABLE_PLAYERS . "
                          SET pena = pena + :pena, mota = mota + :mota, amlo = amlo + :amlo
                          WHERE id = :id
                          LIMIT 1");
    $sth->bindParam(':pena', $score_pena);
    $sth->bindParam(':mota', $score_mota);
    $sth->bindParam(':amlo', $score_amlo);
    $sth->bindParam(':id', $this->id);
    
    if ($sth->execute())
      return true;
    else
      return false;
  }
  
  public function publishOnFacebook($facebook, $score_pena, $score_mota, $score_amlo)
  {
    // Publish stream on Facebook
    $fb_message = 'Acabo de cachetear:' . chr(10);
    if ($score_pena)
      $fb_message .= $score_pena . ' ' . ($score_pena == 1 ? 'vez' : 'veces') . ' a Enrique Peña Nieto' . chr(10);
    if ($score_mota)
      $fb_message .= $score_mota . ' ' . ($score_mota == 1 ? 'vez' : 'veces') . ' a Josefina Vázquez Mota' . chr(10);
    if ($score_amlo)
      $fb_message .= $score_amlo . ' ' . ($score_amlo == 1 ? 'vez' : 'veces') . ' a Andrés Manuel López Obrador' . chr(10);

    $attachment = array(
      'message' => $fb_message,
      'name' => 'Cachetometro',
      // 'caption' => 'Caption of Cachetometro.com',
      'link' => 'http://www.cachetometro.com/',
      'description' => '¿Qué candidato merece una cachetada? Castiga los candidatos en el Cachetómetro, la encuesta alternativa. http://www.cachetometro.com/',
      'picture' => 'http://www.cachetometro.com/views/images/cachetometro_sharefacebook.jpg'
    );
    $facebook->api('/me/feed/', 'post', $attachment);
    
    return true;
  }
  
  /* Private methods */
  private function registerSession()
  {
    $_SESSION['player'] = array(
      'id' => $this->id,
      'fb_id' => $this->fb_id
    );
    
    $this->logged_in = true;
  }
  
  private function registerFacebookPlayer()
  {
    global $db;
    
    $sth = $db->prepare("INSERT INTO " . TABLE_PLAYERS . "
                          (fb_id, mail, name) VALUES
                          (:fb_id, :mail, :name)");
    $sth->bindParam(':fb_id', $this->fb_id);
    $sth->bindParam(':mail', $this->mail);
    $sth->bindParam(':name', $this->name);
    
    if ($sth->execute())
    {
      $this->id = $db->lastInsertId();
      return $this->id;
    }
    else
      return false;
    
  }
  
  
}

?>