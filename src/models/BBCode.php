<?php
class BBCode
{
    //bbcode function 
    public function getBbcode($content)
    { 
        $content = nl2br($content);
        //bold
        $content = preg_replace('`\[g\](.+)\[/g\]`isU', '<strong>$1</strong>', $content); 
        //italics
        $content = preg_replace('`\[i\](.+)\[/i\]`isU', '<em>$1</em>', $content);
        //underline
        $content = preg_replace('`\[s\](.+)\[/s\]`isU', '<u>$1</u>', $content);
        //link with http://
        $content = preg_replace('`\[url\](http://[a-z0-9._,/?!&=#-]+)\[/url\]`i', '<a href="$1" target="_blank">$1</a>', $content);
        //link without http://
        $content = preg_replace('`\[url\]([a-z0-9._/-]+)\[/url\]`isU', '<a href="http://$1" target="_blank">$1</a>', $content);

        
        return $content;
    }
}