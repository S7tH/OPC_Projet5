<?php

class DBFactory
{ 
  //change the following const values with your data server  
  const HOST = "localhost";
  const DBNAME = "my_blog";
  const USER = "root";
  const PASSWORD = "";
    
  public static function getDBConnexion()
  {
    //In first we check if the database or tables exist
    $db = new PDO('mysql:host='.self::HOST,self::USER,self::PASSWORD);
      
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $check = new DataBaseCreator($db);
    $dbname = self::DBNAME;
    $check->dbExist($dbname); 
    
    //After the check up, we call our database with its name  
    $db = new PDO('mysql:host='.self::HOST.';dbname='.self::DBNAME,self::USER,self::PASSWORD);  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
    return $db;
  }

}
            

