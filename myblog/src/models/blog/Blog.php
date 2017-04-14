<?php

class Blog
{
    //attributes
    private $_errors = [],
            $_id,
            $_title,
            $_catchphrase,
            $_content,
            $_author,
            $_post_date,
            $_post_modified,
            $_url;

    //constants
    const   INVALIDE_TITLE = 1,
            INVALIDE_CATCHPHRASE = 2,
            INVALIDE_CONTENT = 3,
            INVALIDE_AUTHOR = 4;

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
   
    //method to know if the post is new
    public function isNew()
    {
        return empty($this->_id);
    }

    //method to know if the post is valide
    public function isValid()
    {
        return !(empty($this->_title) || empty($this->_catchphrase) || empty($this->_content) || empty($this->_author));
    }

    

    //GETTERS
    public function errors(){ return $this->_errors;}

    public function id(){return $this->_id;}

    public function title(){return $this->_title;}

    public function catchphrase(){return $this->_catchphrase;}

    public function content(){return $this->_content;}

    public function author(){return $this->_author;}

    public function post_date(){return $this->_post_date;}

    public function post_modified(){return $this->_post_modified;}

    public function url(){return $this->_url;}

    //SETTERS
    public function setId($id)
    {
        $this->_id = (int)$id;
    }

    public function setTitle($title)
    {
        if (!is_string($title) || empty($title))
        {
            $this->_errors[] = self::INVALIDE_TITLE;
        }
        else
        {
            $this->_title = $title;
        }
    }

    public function setCatchphrase($catchphrase)
    {
        if (!is_string($catchphrase) || empty($catchphrase))
        {
            $this->_errors[] = self::INVALIDE_CATCHPHRASE;
        }
        else
        {
            $this->_catchphrase = $catchphrase;
        }
    }

    public function setContent($content)
    {
        if (!is_string($content) || empty($content))
        {
            $this->_errors[] = self::INVALIDE_CONTENT;
        }
        else
        {
            $this->_content = $content;
        }
    }

    public function setAuthor($author)
    {
        if (!is_string($author) || empty($author))
        {
            $this->_errors[] = self::INVALIDE_AUTHOR;
        }
        else
        {
            $this->_author = $author;
        }
    }

    public function setPost_date(DateTime $post_date)
    {
        $this->_post_date = $post_date;
    }

    public function setPost_modified(DateTime $post_modified)
    {
        $this->_post_modified = $post_modified;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }
}