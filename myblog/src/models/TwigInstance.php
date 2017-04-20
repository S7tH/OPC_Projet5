<?php

class TwigInstance
{
    const ROOT = "src/views/",
          HOME = "src/views/home/",
          BLOG = "src/views/blog/";
    

    public static function twigLoad($path)
    {
        //checking of the parameter is one of these following constantes 
        if (in_array($path, [self::HOME, self::BLOG]))
        {
            $loader = new Twig_Loader_Filesystem(array($path, self::ROOT));//ROOT allow Php to find the layout
        }
        else // an error is raised
        {
            throw new RuntimeException('twigload() The parameter must be a constant of the class "TwigInstance" !');
        }

        return new Twig_Environment($loader, array(
        'cache' => false
        ));
    }
}