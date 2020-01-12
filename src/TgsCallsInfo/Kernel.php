<?php
namespace TgsCallsInfo;
use TgsCallsInfo\Contracts\KernelInterface;
use TgsCallsInfo\Services\Requests;

class Kernel implements KernelInterface
{
    private $action = null;
    private $method = null;

    public function __construct(){
        $this->getRoutes();
    }

    /**
     *
     */
    public function start(){
        try{
            $controller = sprintf('TgsCallsInfo\Controllers\%sController', trim($this->action));
            $app = new $controller;
            $method = $this->method;
            $app->$method();

        } catch (\Exception $e){
            die($e->getTraceAsString());
        }
    }

    /**
     *
     */
    protected function getRoutes(){
        $this->action = ucfirst(strtolower(Requests::get('action', 'Index')));
        $this->method = Requests::get('method', 'index');
    }

}