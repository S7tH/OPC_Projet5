<?php
class BlogController extends Controller
{
    
    //connect to the database and return a BlogManager Object
    public static function connexion()
    {
        try
        {
            $database = DBFactory::getDBConnexion();
            
            return new BLogManager($database);
        }
        catch (RuntimeException $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    //return a loading of one instance of twig with as parameter the folder path of the corresponding view (the path is written inside of the constante)
    public function twigCall()
    {
        return TwigInstance::twigLoad(TwigInstance::BLOG);
    }

    public function indexAction()
    {  
        $manager = self::connexion(); //instaciation of BlogManager
        
        //check if page exist or page is an int else an error occur
        if(isset($_GET['page']) and (int)$_GET['page'])
        {
            $page = (int)$_GET['page'];
            $limit = 6;
            $start = (($page - 1) * $limit);
            $totalElts = $manager->count();
            $nb_page = ceil($totalElts / $limit);
            $nbLimit = 3;
        }
        else
        {
            $page = new ErrorController;//error
            return $page->indexAction();
        }
        
        

        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',array(
        'section' => $_GET['section'],
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class. It's used mainly for the links to the pages*/
        'postcount' => $totalElts,
        'lastpost' => $manager->getList($start,$limit),//takes 2 parameters, the start number post and the last number post wich will be displayed
        'totalpages' => $nb_page,
        'nb' => $nbLimit,
        'page' => $page
        ));
    }
    
    public function getAction()
    {
        $manager = self::connexion(); //instaciation of BlogManager
        
        //check if var delete exist else delete will be null
        if (isset($_GET['delete']))
        {
            $delete = $_GET['delete'];
        }
        else
        {
            $delete = null;
        }
        
        //check if post exist else an error occur
        if(isset($_GET['post']))
        {
            $postId = $_GET['post'];
        }
        else
        {
            $page = new ErrorController;//error 404
            return $page->indexAction();
        }
        
        $post = $manager->getPost($_GET['post']);
        
        
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',array(
        'section' => $_GET['section'],
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class. It's used mainly for the links to the pages*/
        'post_id' => $postId,
        'contentpost' => $post,
        'delete' => $delete,
        'bbcode' => new BBCode //allow to use my class BBCode for change the bbcode of my blog text in html markup during its display
        ));
    }
    
    public function addAction()
    {
        $postSucces = false;
        $setcookie = null;
        
        $manager = self::connexion(); //instanciation of BlogManager
        if(!empty($_POST['title']))
        {   
            $dataform = new Blog($_POST);
            $postSucces = $manager->save($dataform);
            $nickname = $dataform->author();
            $setcookie = setcookie('nickname', $nickname, time() + 365*24*3600, null, null, false, true);
        }
                         
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',array(
        'section' => $_GET['section'],//recover the current url
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class*/
        'postSucces' => $postSucces,
        'setCookie' => $setcookie,
        'cookie' => $_COOKIE)); 
    }
    
    public function editAction()
    {
        $postSucces = false;
        
        $manager = self::connexion(); //instaciation of BlogManager
        
        if(!empty($_POST['title']))
        {   
            $dataform = new Blog($_POST);
            $postSucces = $manager->save($dataform);
        }
        
        //check if post exist else an error occur
        if(isset($_GET['post']))
        {
            $postId = $_GET['post'];
        }
        else
        {
            $page = new ErrorController;//error
            return $page->indexAction();
        }
        
        
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',array(
        'section' => $_GET['section'],//recover the current url
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class*/
        'post_id' => $postId,
        'contentpost' => $manager->getPost($_GET['post']),
        'postSucces' => $postSucces
        ));
    }
    
    public function deleteAction()
    {   
        $deleteSucces = false;
        
        $manager = self::connexion(); //instaciation of BlogManager
        $dataform = new Blog($_POST);
        $deleteSucces = $manager->delete($_GET['post']);
       
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',array(
        'section' => $_GET['section'],//recover the current url
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class*/
        'post_id' => $_GET['post'],
        'deleteSucces' => $deleteSucces
        ));
    }
    
}