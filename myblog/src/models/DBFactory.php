<?php

class DBFactory
{

  public static function getDBConnexion()
  {
    $db = new PDO('mysql:host=localhost;dbname=my_blog', 'root', '');

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
  }

}