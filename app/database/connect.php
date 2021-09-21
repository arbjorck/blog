<?php

class DbConnect
{
  private $PDO;

  function __construct()
  {    
    try {
      // $this->PDO = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      // echo 'Successfully connected to the database!';
      $this->PDO = new PDO('mysql:host=host;dbname=u849468527_blog;charset=utf8', 'u849468527_blogger', 'Goalsetter1', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      
    } catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage() . "<br/>";
      die();
    }
  }

  function dbConnect()
  {
    return $this->PDO;
  }

  function dbDisconnect()
  {
    $this->PDO = null;
    //echo 'Successfully disconnected from the database!';
  }
}