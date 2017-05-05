<?php
class HomeController extends Controller
{
    public function twigCall()
    {
        //return a loading of one instance of twig with as parameter the folder path of the corresponding view (the path is written inside of the constante)
        return TwigInstance::twigLoad(TwigInstance::HOME);
    }

    public function indexAction()
    {
        $mailSucces = false;
        
        if(!empty($_POST['name']))
        {   
            //instanciation of Contact
            $dataform = new Contact($_POST);
            //instanciation of ContactManager
            $manager = new ContactManager();
            
            //we try to send the mail
            $mailSucces = $manager->sendMail($dataform);
            
        }
        
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',
        array('urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class*/
              'mailSucces' => $mailSucces));
    }
}