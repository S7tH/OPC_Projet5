<?php
class Routes
{
   //here is write down the differents sections wich are used in the conditions of root index.php (?sections=)
   public function getSections()
   {
        return array(
           'home' => 'home',
           'blog' => 'blog',
           'blogpost' => 'blogpost',
           'blogadd' => 'blogadd',
           'blogedit' => 'blogedit');
   }
    
   //here is write down the differents urls for use them in twig views.
   public function getUrls()
   {
           $section = 'index.php?section=';
           $post = '&post=';

           return array(
           'home' => 'index.php',
           'blog' => $section.'blog',
           'blogpost' => $section.'blogpost'.$post,
           'blogadd' => $section.'blogadd',
           'blogedit' => $section.'blogedit'.$post);
   }
}
