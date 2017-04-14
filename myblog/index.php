<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/models/Autoload.php';

//loading one instance of twig with as parameter the folder path of the corresponding view (the path is written inside of the constante)  
$twig = TwigInstance::twigLoad(TwigInstance::HOME);
  

// we are calling the view and fix its parameters
    echo $twig->render('index.twig',
    array
    (
        'motor_name' => '"A value in Twig"'
    ));
?>