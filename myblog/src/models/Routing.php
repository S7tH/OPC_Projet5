<?php
trait Routing
{
    //a trait which instanciates the urls of the Routes class in the differents controllers 
    public static function urls()
    {
        $routing = new Routes();
        return $routing->getUrls();
    }
}

