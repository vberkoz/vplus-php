<?php

/**
 * Class Router
 */
class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Returns request string
     *
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return substr(trim($_SERVER['REQUEST_URI'], '/'), 7);
        }

        return '';
    }

    /**
     * Calls action in controller
     */
    public function run()
    {
        // Get request string
        $uri = $this->getURI();

        // Check request string availability in routes.php
        foreach ($this->routes as $uriPattern => $path) {

            // Compare $uriPattern and $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Get internal route from an outer according to a rule
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Determine which controller and method are processing the request
//                $segments = explode('/', $internalRoute);
                $segments = explode('.', $internalRoute);

//                $controllerName = array_shift($segments) . 'Controller';
                $moduleName = array_shift($segments);
                $controllerName = $moduleName . 'Controller';
                $controllerName = ucfirst($controllerName);
//                echo '<pre>';print_r($controllerName);die;

//                $actionName = 'action' . ucfirst(array_shift($segments));
                $methodName = array_shift($segments);

                $parameters = $segments;

                // Include controller class file
//                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                $controllerFile = ROOT . "/modules/$moduleName/$controllerName.php";
//                echo '<pre>';print_r($methodName);die;

                if (file_exists($controllerFile)) {
                    include_once $controllerFile;
                }

                // Create object, call method
                $controllerObject = new $controllerName;

//                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                $result = call_user_func_array(array($controllerObject, $methodName), $parameters);

                if ($result != null) {
                    break;
                }

            }

        }
    }

}
