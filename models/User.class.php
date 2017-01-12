<?php

class User {
  private $id;
  private $username;
  private $password;
  
  private $logged_in = false;
  
  /* Getters */
  function getId() { return $this->id; }
  function getUsername() { return $this->username; }
  function getPassword() { return $this->password; }
  function isLoggedIn()
  {
    return $this->logged_in ? true : false;
  }
  
  /* Setters */
  function setId($id) { $this->id = $id; }
  function setUsername($username) { $this->username = $username; }
  function setPassword($password) { $this->password = md5($password); }
  function setLoggedIn($logged_in)
  {
    $this->logged_in = $logged_in ? true : false;
  }
  
  /* Methods */
  function logOut()
  {
    if ($this->logged_in)
    {
      setcookie('login', '', 0, '/');
      $this->setId('');
      $this->setUsername('');
      $this->setPassword('');
      $this->setLoggedIn(false);
    }
  }
  
  /* Static methods */
  static function getLoggedUser()
  {
    // Create an empty user
    $user = new User();
    
    if (isset($_COOKIE['login']))
    {
      global $db;

      $cookie_data = explode("_", $_COOKIE['login']);
      $user_id = $cookie_data[0];
      $user_password = $cookie_data[1];
      
      $sth = $db->prepare("SELECT id, username, password
                          FROM " . TABLE_USERS . "
                          WHERE id = :id
                          LIMIT 1");
      $sth->bindParam(':id', $user_id);
      $sth->execute();
      
      if ($sth->rowCount())
      {
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $user = $sth->fetch();
        
        if ($user_password == $user->getPassword())
        {
          $user->setLoggedIn(true);
        }
        else
        {
          // The user data is wrong, destroy the cookie
          setcookie('login', '', 0, '/');
          // Replace the user with an empty one
          $user = new User();
        }
      }
    }
    
    return $user;
  }
  
  static function logIn($username, $password, $remember_user = false)
  {
    global $db;
    
    $username = strtolower($username);
    
    $sth = $db->prepare("SELECT id, password
                        FROM " . TABLE_USERS . "
                        WHERE username = :username
                        LIMIT 1");
    $sth->bindParam(':username', $username);
    $sth->execute();
    
    // If there are any results with that username
    if ($sth->rowCount()) {
      $login_data = $sth->fetch(PDO::FETCH_ASSOC);
      // Check that the password is the same
      if (md5($password) == $login_data['password']) {
        // Set the cookie for the user
        $cookie_expire = $remember_user ? time()+60*60*24*30 : 0;
        $set_user_cookie = setcookie('login', $login_data['id']. '_' . $login_data['password'], $cookie_expire, '/');
        
        return true; // The user is logged in now!
      } else {
        // Incorrect password
        throw new Exception('Clave incorrecta.');
        return false;
      }
    } else {
      // That username doesn't exist
      throw new Exception('Usuario incorrecto');
      return false;
    }
    
  }
  
}

?>