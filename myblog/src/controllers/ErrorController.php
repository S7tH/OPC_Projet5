<?php
class ErrorController extends Controller
{
    public function twigCall()
    {
        //return a loading of one instance of twig with as parameter the folder path of the corresponding view (the path is written inside of the constante)
        return TwigInstance::twigLoad(TwigInstance::ERROR);
    }

    public function indexAction()
    {
        // we are calling the view and fix its parameters
        echo $this->twigCall()->render('index.twig',
        array('urls' => self::urls(),/*function Brought by Routing Trait wich is called in the mother class*/
            ));
    }
}