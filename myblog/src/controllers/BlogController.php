<?php
class BlogController extends Controller
{
    //connect to the database and return a BlogManager Object
    public function connexion()
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
                
        // we are calling the view and fix its parameters
        echo self::twigCall()->render('index.twig',array(
        'section' => $_GET['section'],
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class. It's used mainly for the links to the pages*/
        'postcount' => $manager->count(),
        'lastpost' => $manager->getList()
        ));
    }
    
    public function getAction()
    {
        $manager = self::connexion(); //instaciation of BlogManager
                
        // we are calling the view and fix its parameters
        echo self::twigCall()->render('index.twig',array(
        'section' => $_GET['section'],
        'urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class. It's used mainly for the links to the pages*/
        'post' => $_GET['post'],
        'content' => $manager->getPost('post')
        ));
    }
    
    public function addAction()
    {
        $manager = self::connexion(); //instanciation of BlogManager
        if(!empty($_POST['title']))
        {   
            $dataform = new Blog($_POST);
            $manager->save($dataform);
        }
        
       
        
        // we are calling the view and fix its parameters
        echo self::twigCall()->render('index.twig',array(
        'section' => $_GET['section'],//recover the current url
        'urls' => self::urls()/*function Brought by Routing Trait wich is called in the mother class*/)); 
    }
    
    public function editAction()
    {
        $manager = self::connexion(); //instaciation of BlogManager
        
       
        // we are calling the view and fix its parameters
        echo self::twigCall()->render('index.twig',array(
        'section' => $_GET['section'],//recover the current url
        'urls' => self::urls()/*function Brought by Routing Trait wich is called in the mother class*/));
    }
    
}