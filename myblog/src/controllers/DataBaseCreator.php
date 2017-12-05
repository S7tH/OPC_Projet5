<?php

class DataBaseCreator
{
    private $_database;
    
    //method in charge to save the instance of PDO 
    public function __construct(PDO $database)
    {
        $this->_database = $database;
    }
    
    public function dbExist($dbname)
    {
    
        //we try to select a request if it's no possible we create the db
        try
        {
            /*Data base selection*/
            $this->_database->exec('USE '.$dbname);
            
            $this->_database->query('SELECT * FROM (my_authors, my_posts)');
        }
        catch (Exception $e)
        {
           // We got an exception == table not found
            $this->dbCreator($dbname);
        }
       
    }
    
    public function dbCreator($dbname)
    {
        /*Data base creation with utf-8 encoding.*/
        $this->_database->exec('CREATE DATABASE IF NOT EXISTS '.$dbname.' CHARACTER SET utf8');
        
        /*Data base selection*/
        $this->_database->exec('USE '.$dbname);
  
        /*tables creation */
        
        /*Authors table*/
        $this->_database->exec('CREATE TABLE IF NOT EXISTS `my_authors`
        (
	       `author_id` INT UNSIGNED PRIMARY KEY  NOT NULL AUTO_INCREMENT,
	       `author_name` VARCHAR(50) NOT NULL,
	       UNIQUE ind_author_name(author_name)
        )
        ENGINE=INNODB');

        /*posts table*/

        $this->_database->exec('CREATE TABLE IF NOT EXISTS `my_posts`
        (
	       `post_id` INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	       `post_title` TINYTEXT NOT NULL,
	       `post_catchphrase` LONGTEXT NOT NULL,
	       `post_content` LONGTEXT NOT NULL,
	       `id_author` INT UNSIGNED,
	       `post_date` DATETIME,
	       `post_modified` DATETIME,
	       CONSTRAINT `fk_my_authors_id_author`
		   FOREIGN KEY(id_author)
		   REFERENCES my_authors(author_id)
        )
        ENGINE=INNODB;');
    } 
}