<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/phpmailer/PHPMailer.php"; 
require_once APPPATH."/third_party/phpmailer/SMTP.php"; 
require_once APPPATH."/third_party/phpmailer/POP3.php"; 
require_once APPPATH."/third_party/phpmailer/OAuthTokenProvider.php"; 
// require_once APPPATH."/third_party/phpmailer/OAuth.php"; 
// require_once APPPATH."/third_party/phpmailer/Exception.php"; 
// echo var_dump(APPPATH."/third_party/phpmailer/PHPMailer.php");
class PhpMail extends PHPMailer
{
    function __construct($exceptions = FALSE)
    {
        parent::__construct($exceptions);
    }
}