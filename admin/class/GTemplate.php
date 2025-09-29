<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
//class GTemplate extends Twig_Environment {
class GTemplate extends Twig\Environment {

    public function __construct(){
        //$loader = new Twig_Loader_Filesystem(__DIR__.'/../../Templates');
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../../Templates');
        parent::__construct($loader);
    }
}
?>