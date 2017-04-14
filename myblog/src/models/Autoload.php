<?php
//these lines auto loading the classes 
spl_autoload_register(function($class){(file_exists($path = 'src/models/' . $class . '.php')) ? require $path : false;});
spl_autoload_register(function($class){(file_exists($path = 'src/controllers/' . $class . '.php')) ? require $path : false;});

