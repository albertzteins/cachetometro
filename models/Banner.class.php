<?php

class Banner
{
  private $id;
  private $title;
  private $date;
  private $image;
  private $link;
  private $position;
  
  /* Setters */
  function setId($id) { $this->id = $id; }
  function setTitle($title) { $this->title = $title; }
  function setDate($date) { $this->date = date(MYSQL_DATETIME, strtotime($date)); }
  function setImage($image) { $this->image = $image; }
  function setLink($link) { $this->link = $link; }
  function setPosition($position) { $this->position = $position; }
  
  /* Getters */
  function getId() { return $this->id; }
  function getTitle() { return $this->title; }
  function getDate($format = MYSQL_DATETIME) { return date($format, strtotime($this->date)); }
  function getImage() { return $this->image; }
  function getLink() { return $this->link; }
  function getPosition() { return $this->position; }
  
  /* Methods */
  function save()
  {
    global $db;
    
    $sth = $db->prepare("INSERT INTO " . TABLE_BANNERS . "
                          (title, date, image, link, position) VALUES
                          (:title, :date, :image, :link, :position)");
    $sth->bindParam(':title', $this->title);
    $sth->bindParam(':date', $this->date);
    $sth->bindParam(':image', $this->image);
    $sth->bindParam(':link', $this->link);
    $sth->bindParam(':position', $this->position);
    $sth->execute();
    
    $this->setId($db->lastInsertId());
    
    return true;
  }
  
  /* Static methods */
  static function getBannerForPosition($position)
  {
    global $db;
    
    if (is_int($position))
    {
      $sth = $db->prepare("SELECT id, title, date, image, link, position
                            FROM " . TABLE_BANNERS . "
                            WHERE position = :position
                            ORDER BY id DESC
                            LIMIT 1");
      $sth->bindParam(':position', $position);
      $sth->execute();
    }
    else
    {
      throw new InvalidArgumentException("The id must be an integer.");
    }
    
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Banner');
    
    return $sth->fetch();
  }
  
  static function deleteBannerWithId($id)
  {
    global $db;
    
    if (is_int($id))
    {
      $sth = $db->prepare("DELETE FROM " . TABLE_BANNERS . "
                            WHERE id = :id
                            LIMIT 1");
      $sth->bindParam(':id', $id);
      $sth->execute();
      
      if ($sth->rowCount())
        return true;
      else
        return false;
        
    }
    else
    {
      throw new InvalidArgumentException("The id must be an integer.");
    }
  }
  
}

?>