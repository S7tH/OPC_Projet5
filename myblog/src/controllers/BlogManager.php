<?php

class BLogManager
{
    //attribute
    private $_database;

    //method in charge to save the instance of PDO 
    public function __construct(PDO $database)
    {
        $this->_database = $database;
    }

    //method to add a post
    public function add(Blog $post)
    {          
        //check if this author exists in the database
        $quest = $this->_database->prepare('SELECT * FROM my_authors WHERE author_name = :author');
        $quest->bindValue(':author', $post->author());
        $quest->execute();
        $exist = $quest->fetch();
        $quest->closeCursor();
        
        if ($exist['author_name'] == $post->author())//if exists we recover the author_id in a var $id
        {
            $id = $exist['author_id'];
        } 
        else//else we save it in the database
        {
            //save the author
            $quest = $this->_database->prepare('INSERT INTO my_authors(author_name) VALUES(:name)');
            $quest->bindValue(':name', $post->author());
            $quest->execute();
            /*recovers the author_id on a var $id with a PDO function wich recover the last id inserted*/
            $id = $this->_database->lastInsertId(); 
            $quest->closeCursor();
        }
        
        //save the content of the blog
        $quest = $this->_database->prepare('INSERT INTO my_posts(post_title, post_catchphrase, post_content, id_author, post_date, post_modified) VALUES(:title, :catchphrase, :content, :author, NOW(), NOW())');
    
        $quest->bindValue(':title', $post->title());
        $quest->bindValue(':catchphrase', $post->catchphrase());
        $quest->bindValue(':content', $post->content());
        $quest->bindValue(':author', (int)$id, PDO::PARAM_INT);
        $quest->execute();
        $quest->closeCursor();
    }

    //method wich return the total number of posts
    public function count()
    {
        return $this->_database->query('SELECT COUNT(*) FROM my_posts')->fetchColumn();
    }

    //methode to update the modifications on a post
    public function update(Blog $post)
    {
        $quest = $this->_database->prepare('UPDATE my_posts SET post_title = :title, post_catchphrase = :catchphrase, post_content = :content, post_author = :author, post_modified = NOW() WHERE post_id = :id');
    
        $quest->bindValue(':title', $post->title());
        $quest->bindValue(':catchphrase', $post->catchphrase());
        $quest->bindValue(':content', $post->content());
        $quest->bindValue(':author', $post->author());
        $quest->bindValue(':id', $post->id(), PDO::PARAM_INT);
    
        $quest->execute();
    }

    //method for save a post
    public function save(Blog $post)
    {
        if ($post->isValid())
        {
            $post->isNew() ? $this->add($post) : $this->update($post);
        }
        else
        {
            throw new RuntimeException('Le contenu du post doit être valide pour être enregistré, veuillez vérifier les champs.');
        }
    }

    //method wich return a post per its id
    public function getPost($id)
    {
        $id = (int)$id;
        //make a juncture to recover author_name
        $quest = $this->_database->prepare
        (
        'SELECT * FROM my_authors AS a
         INNER JOIN my_posts AS p
         ON a.author_id = p.id_author
         WHERE p.post_id = :id'
        );
        $quest->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $quest->execute();

        $quest->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Blog');


        $post = $quest->fetch();

        $post->setPost_modified(new DateTime($post->post_modified()));

        return $post;
    }

    //method wich return the list of posts
    public function getList($start = -1 , $limit = -1)
    {
        $sql = 'SELECT post_id, post_title, post_catchphrase, post_modified FROM my_posts ORDER BY post_id DESC';
    
        //let's check the provided parameters
        if ($start != -1 || $limit != -1)
        {
              $sql .= ' LIMIT '.(int) $limit.' OFFSET '.(int) $start;
        }
    
        $quest = $this->_database->query($sql);
        $quest->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Blog');
    
        $postsList = $quest->fetchAll();

        //We make a loop for browse our list of posts in order to place one intance of DateTime as a modified date
        foreach ($postsList as $post)
        {
            $post->setPost_modified(new DateTime($post->post_modified()));
        }
    
        $quest->closeCursor();
    
        return $postsList;
    }
}