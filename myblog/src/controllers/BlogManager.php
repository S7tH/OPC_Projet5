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
        $quest = $this->_database->prepare('INSERT INTO my_posts(post_title, post_catchphrase, post_content, post_author, post_date, post_modified, post_url) VALUES(:title, :catchphrase :content, :author, NOW(), NOW(), :url)');
    
        $quest->bindValue(':title', $post->title());
        $quest->bindValue(':catchphrase', $post->catchphrase());
        $quest->bindValue(':content', $post->content());
        $quest->bindValue(':author', $post->author());
        $quest->bindValue(':url', $post->url());
    
        $quest->execute();
    }

    //method wich return the total number of posts
    public function count()
    {
        return $this->database->query('SELECT COUNT(*) FROM my_posts')->fetchColumn();
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

    //method to save a post
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

        $quest = $this->_database->prepare('SELECT post_id, post_title, post_catchphrase, post_content, post_author, post_modified, post_url FROM my_posts WHERE post_id = :id');
        $quest = $this->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $quest = $this->execute();

        $quest->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Blog');


        $post = $quest->fetch();

        $post->setPost_modified(new DateTime($post->post_modified()));

        return $post;
    }

    //method wich return the list of posts
    public function getList($start = -1 , $limit = -1)
    {
        $sql = 'SELECT post_id, post_title, post_catchphrase, post_modified, post_url FROM my_posts ORDER BY post_id DESC';
    
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