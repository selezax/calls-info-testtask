<?php
namespace TgsCallsInfo\Controllers;


abstract class Controllers
{
    protected $viewsPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR ;
    protected $layout = 'layouts.php';

    final function view(string $viewfile,array $params = []){
        $viewsPath = $this->viewsPath;
        require_once($viewsPath . $this->layout);
    }

    final function error(string $msg){
        $viewfile = 'error';
        $viewsPath = $this->viewsPath;
        require_once($viewsPath . $this->layout);
    }
}