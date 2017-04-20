<?php
abstract class Controller
{
    use Routing;
    
    abstract public function twigCall();
    abstract public function indexAction();
}