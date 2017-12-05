<?php

class ContactManager
{
    //attributes
    private $_mailOwner;
    private $_backline;
    private $_subject;
    private $_boundary;
    private $_headers;
    private $_msg;
    private $_succes;
    
    
    //function wich sends mail
    public function sendMail(Contact $form)
    {
        if ($form->isValid())
        {
        //prepare the mail
            //inform of the mail reception
            $this->_mailOwner = "aurelien.theriot@gmail.com";
            
            //init the backline()
            $this->_backline = PHP_EOL;//send back a string wich matches to the line break LF and CRLF on multy platforms.
            
            //fill the boundary wich will separate our mail elements
            $this->_boundary = md5(uniqid(time()));
        
            //create the subject
            $this->_subject = "Une personne vous a contacté depuis votre site internet";
        
            //create the header
            //Sender
            $this->_headers = "From: ".$form->name()." ".$form->firstname()."<".$form->email().">".$this->_backline;
            //response mail
            $this->_headers .= "Reply-To: ".$form->email().$this->_backline;
            //MIME version
            $this->_headers .= "MIME-Version: 1.0".$this->_backline;
            //Content-Type
            $this->_headers .= "Content-Type: multipart/alternative;
            boundary=\"".$this->_boundary."\"";
        
            //create the mail message
            $this->_msg = "--".$this->_boundary.$this->_backline;
            $this->_msg .= "Content-Type: text/html; charset=ISO-8859-1".$this->_backline;
            $this->_msg .= "Content-Transfer-Encoding: 8bit".$this->_backline;
            $this->_msg .= $this->_backline.$form->message().$this->_backline;
            $this->_msg .= "--".$this->_boundary.$this->_backline;
            $this->_msg .= "--".$this->_boundary.$this->_backline;
            
        //send the mail  
        mail($this->_mailOwner,$this->_subject,$this->_msg,$this->_headers);
          
        return $this->_succes = true; 
        }
         else
        {
            throw new RuntimeException('Le contenu du formulaire de contact doit être valide pour être envoyé, veuillez vérifier les champs.');
        }
    }   
}