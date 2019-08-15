<?php

abstract class AbstractApi
{
    protected $method = '';

    public $requestUri = [];
    public $requestParams = [];

    protected $action = '';
    protected $serviceId = '';
    protected $userId = '';

    public function __construct()
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER) && $this->method == 'POST'){
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT'){
                $this->method = 'PUT';
            }else{
                throw new Exception("Unexpected Header");
            }
        }
    }

    public function start()
    {
        if($this->requestUri[0]!='users' || $this->requestUri[2]!='services'){
            throw new RuntimeException('Not Found', 404);
        }
        
        $this->userId = (int) $this->requestUri[1];
        $this->serviceId = (int) $this->requestUri[3];
        $this->action = $this->checkAction($this->requestUri[4]);

        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }
    
    protected function checkAction($action)
    {        
        switch ($this->method){
            case 'GET':
                if($action == 'tarifs'){
                    return 'tarifs';
                }else{
                    return null;
                }
                break;
            case 'PUT':
                if($action == 'tarif'){
                    return 'tarif';
                }else{
                    return null;
                }
                break;
            default:
                return null;
        }
    }

    protected function response($data, $status = 500) {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    private function requestStatus($code) {
        $status = array(
            200 => 'OK',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }
}