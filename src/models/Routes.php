<?php
class Routes
{
   //here is write down the differents sections wich are used in the conditions of root index.php (?sections=)
   public function getSections()
   {
        return array(
           'home' => 'home',
           'blog' => 'blog',
           'blogpage' => 'blog',
           'blogpost' => 'blogpost',
           'blogadd' => 'blogadd',
           'blogedit' => 'blogedit',
           'blogdelete' => 'blogdelete');
   }
    
   //here is write down the differents urls for use them in twig views.
   public function getUrls()
   {
           $section = 'index.php?section=';
           $post = '&post=';
           $page = '&page=';

           return array(
           'home' => 'index.php',
           'blog' => $section.'blog'.$page.'1',
           'blogpage' => $section.'blog'.$page,   
           'blogpost' => $section.'blogpost'.$post,
           'blogadd' => $section.'blogadd',
           'blogedit' => $section.'blogedit'.$post,
           'blogdelete' => $section.'blogdelete'.$post);
   }
}
