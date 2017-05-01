<?php

class Contact
{
    //attributes
    private $_errors = [],
            $_name,
            $_firstname,
            $_mail,
            $_message;

    //constants
    const   INVALIDE_NAME = 1,
            INVALIDE_FIRSTNAME = 2,
            INVALIDE_MAIL = 3,
            INVALIDE_MESSAGE = 4;
        

    //constructor
    public function __construct($values = [])
    {
        //if this values array is not empty, then it gets to hydrate.
        if(!empty($values))
        {
            $this->hydrate($values);
        }
    }

    //Hydratation
    public function hydrate($dataset)
    {
        //A loop for auto calling the setters for hydrate our object
        foreach($dataset as $attribute => $value)
        {
            $methode = 'set'.ucfirst($attribute);

            if(is_callable([$this, $methode]))
            {
                $this->$methode($value);
            }
        }
    }
   
    //method to know if the post is valide
    public function isValid()
    {
        return !(empty($this->_name) || empty($this->_firstname) || empty($this->_mail) || empty($this->_message));
    }

    

    //GETTERS
    public function errors(){ return $this->_errors;}

    public function name(){return $this->_name;}

    public function firstname(){return $this->_firstname;}

    public function mail(){return $this->_mail;}

    public function message(){return $this->_message;}


    //SETTERS
    public function setName($name)
    {
        if (!is_string($name) || empty($name))
        {
            $this->_errors[] = self::INVALIDE_NAME;
        }
        else
        {
            $this->_name = $name;
        }
    }

    public function setFirstname($firstname)
    {
        if (!is_string($firstname) || empty($firstname))
        {
            $this->_errors[] = self::INVALIDE_FIRSTNAME;
        }
        else
        {
            $this->_firstname = $firstname;
        }
    }

    public function setMail($mail)
    {
        if (!is_string($mail) || empty($mail) || !preg_match('`^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$`', $mail))
        {
            $this->_errors[] = self::INVALIDE_MAIL;
        }
        else
        {
            $this->_mail = $mail;
        }
    }

    public function setMessage ($message)
    {
        if (!is_string($message) || empty($message))
        {
            $this->_errors[] = self::INVALIDE_MESSAGE;
        }
        else
        {
            $this->_message = $message;
        }
    }
}