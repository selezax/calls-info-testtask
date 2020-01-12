<?php
namespace TgsCallsInfo;
use TgsCallsInfo\Contracts\KernelInterface;
use TgsCallsInfo\Services\Requests;

class Kernel implements KernelInterface
{
    private $action = null;
    private $method = null;
    protected $sessionName = 'calls-info-app';
    protected $cookieLifeTime = 86400;

    public function __construct(){

        $this->sessionStart();
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

    /**
     * @param string|null $sessionName
     * @param int|null $cookieLifeTime
     * @return $this
     */
    protected function sessionStart(string $sessionName = null, int $cookieLifeTime = null){


        if(!$sessionName && !empty($sessionName))
            $this->sessionName = $sessionName;

        if(!$cookieLifeTime && !empty($cookieLifeTime))
            $this->cookieLifeTime = $cookieLifeTime;

        session_id($this->sessionName);
        session_start([
            'cookie_lifetime' => (int)$this->cookieLifeTime
        ]);
        return $this;
    }

}