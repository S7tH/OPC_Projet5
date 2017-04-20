<?php
class Routes
{
   //here is write down the differents sections (?sections=)
   public function getSections()
   {
        return array(
           'home' => 'home',
           'blog' => 'blog',
           'blogadd' => 'home');
   }
    
   //here is write down the differents urls for use them in twig views.
   public function getUrls()
   {
           $section = 'index.php?section=';

           return array(
           'home' => 'index.php',
           'blog' => $section.'blog',
           'blogadd' => 'home');
   }
}
