<?php

class Router {
    
    private $routes;
    
    public function __construct()
    {
        $this -> routes = include_once(ROOT. '/components/Routes.php');
    }
    
    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI']));
            return trim($_SERVER['REQUEST_URI'],'/');
    }


    public function run()
    {
        $uri = $this -> getUri();
        
        foreach ($this -> routes as $uri_save => $path) {
            if (preg_match("~$uri_save~", $uri)) {
                
                $path_new = preg_replace("~$uri_save~", $path, $uri);
                
                $path_bit = explode('/', $path_new);
                $path_controller = explode('/', $path)[0];
                while ($path_bit[0] != $path_controller) {
                    array_shift($path_bit);
                }
                
                $controller = array_shift($path_bit);
                $action = array_shift($path_bit);
                $parameters = $path_bit;
                
                $controller_connection = ROOT. '/controllers/'. 
                                         $controller. '.php';

                include_once($controller_connection);
                
                $controller_obj = new $controller;
                $result = call_user_func_array(array($controller_obj, $action), $parameters);
                if ($result != null) {
                    break;
                }
            } 
        }
    }
}
