<?php

class Boot {

    public function __construct(Request $r) {
        
        $controller = $r->getController() . 'Controller';
        $controllerPath = ROOT . 'controllers' . DS . $controller . '.php';
        $method = $r->getMethod();
        $arguments = $r->getArguments();
        
        if (is_readable($controllerPath)) {
			
            require_once $controllerPath;
            
			$controller = new $controller;
            
            if (!is_callable(array($controller, $method))) {
                $method = 'index';
            }
            if (isset($arguments)) {
                call_user_func_array(array($controller, $method), $arguments);
            } else {
                call_user_func(array($controller, $method));
            }
        } else {
            throw new Exception("<b>El controlador no se encuentra: " . $controllerPath . "</b>");
        }
        
    }

}
