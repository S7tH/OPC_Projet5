<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/models/Autoload.php';

//we create an instance of Routes class and recover the Sections.
$routing =  new Routes();
$paths = $routing->getSections();


//check if section don't exist
if (!isset($_GET['section']) and !isset($_SERVER['PATH_INFO']))
{
    $page = new HomeController;
    return $page->indexAction();
}
elseif (isset($_SERVER['PATH_INFO']))
{
?>    
        <h1>ERREUR</h1>
        <hr>
        <h2>Cette page n'existe pas</h2>       
<?php
}
else
{
/*($path come from routing.php)
manage to the controller*/
    switch($_GET['section'])
    {     
        case $paths['home']:
            $page = new HomeController;
            return $page->indexAction();
        break;

        case $paths['blog']:
            $page = new BlogController;
            return $page->indexAction();
        break;
        
        case $paths['blogpage']:
            $page = new BlogController;
            return $page->indexAction();
        break;
        
        case $paths['blogpost']:
            $page = new BlogController;
            return $page->getAction();
        break;

        case $paths['blogadd']:
            $page = new BlogController;
            return $page->addAction();
        break;
        
        case $paths['blogedit']:
            $page = new BlogController;
            return $page->editAction();
        break;
        
        case $paths['blogdelete']:
            $page = new BlogController;
            return $page->deleteAction();
        break;
    
        default:
            $page = new ErrorController;//error 404
            return $page->indexAction();
        break;
        
    }
}
?>

