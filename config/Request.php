<?php
 
class Request {

    private $controller;
    private $method;
    private $arguments;

    public function __construct() { 
//        die("hola");
        if (isset($_GET['url'])) {
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $this->controller = ucwords(array_shift($url));
            $this->method = strtolower(array_shift($url));
            $this->arguments = $url;
        }
        if (!$this->controller) {
            $this->controller = DEFAULT_CONTROLLER;
        }
        if (!$this->method) {
            $this->method = 'index.php';
        }

        if (!$this->arguments) {
            $this->arguments = array();
        }

        //var_dump($this);
    }

    public function getController() {
        return $this->controller;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getArguments() {
        return $this->arguments;
    }

}
