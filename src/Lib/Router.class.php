<?php

/**
 * Description of Router
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
class Router {

    /**
     * @var array Keep controllers in cache
     */
    private static $controllers = array();

    /**
     * Parse the request URI and return an array that contains every not empty element between slashes.
     * @return array
     */
    private static function parseRequestUri() {
        $website_folder = root . '/';
        $request_uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);
        $request = substr($request_uri, strpos($request_uri, $website_folder) + strlen($website_folder));
        $paths = explode('/', $request);
        // Remove last element if empty
        $nb_paths = count($paths);
        if (empty($paths[$nb_paths - 1])) {
            unset($paths[$nb_paths - 1]);
        }
        return $paths;
    }

    /**
     * Get the controller name in the parsed request URI or index if it is empty.
     * @param array $parsedRequest Parsed request URI
     * @return string Controller name without "Controller" at the end
     */
    private static function getControllerName(array $parsedRequest) {
        if (empty($parsedRequest)) {
            return 'index';
        } else {
            return $parsedRequest[0];
        }
    }

    /**
     * Get the controller class name in the parsed request URI or IndexController if it is empty.
     * @param array $parsedRequest Parsed request URI
     * @return string Controller class name
     */
    private static function getControllerClassName(array $parsedRequest) {
        return ucfirst(self::getControllerName($parsedRequest)) . 'Controller';
    }

    /**
     * Get the controller class name in the parsed request URI or IndexController if it is empty.
     * @param array $parsedRequest Parsed request URI
     * @return type
     */
    private static function getControllerFilename(array $parsedRequest) {
        $controllerClassName = self::getControllerClassName($parsedRequest);
        return 'Controllers/' . $controllerClassName . '.class.php';
    }

    /**
     * Get the controller in the parsed request URI or IndexController if it is empty.
     * @param array $parsedRequest Parsed request URI
     * @return Controller
     */
    private static function getController(array $parsedRequest) {
        $controllerName = self::getControllerName($parsedRequest);
        $controllerClassName = self::getControllerClassName($parsedRequest);
        if (!stream_resolve_include_path(self::getControllerFilename($parsedRequest))) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        if (!isset(self::$controllers[$controllerName])) {
            self::$controllers[$controllerName] = new $controllerClassName();
        }
        return self::$controllers[$controllerName];
    }

    /**
     * Get the method name in the parsed request URI or defaultAction.
     * @param array $parsedRequest Parsed request URI
     * @return string
     */
    private static function getMethodName(array $parsedRequest) {
        if (!isset($parsedRequest[1])) {
            return 'defaultAction';
        }
        return $parsedRequest[1];
    }

    /**
     * Get the arguments in the parsed request URI or NULL.
     * @param array $parsedRequest Parsed request URI
     * @return array
     */
    private static function getArgs(array $parsedRequest) {
        if (!isset($parsedRequest[0]) && !isset($parsedRequest[1])) {
            return NULL;
        }
        array_slice($parsedRequest, 2);
        return $parsedRequest;
    }

    /**
     * Execute a method of a controller
     * @param Controller $controller
     * @param string $method_name
     * @param array $args
     */
    private static function executeMethod($controller, $method_name, array $args = NULL) {
        if (empty($method_name)) {
            $controller->defaultAction();
        } else {
            if (method_exists($controller, $method_name)) {
                $controller->$method_name($args);
            } else {
                // Error : method does not exist
                header("HTTP/1.1 404 Not Found");
                exit();
            }
        }
    }

    /**
     * Set a root constant that defines the root of the application.
     */
    public static function setRootWebApp() {
        $matches = array();
        preg_match('@/[^/]+@', filter_input(INPUT_SERVER, "PHP_SELF"), $matches);
        defined('root') || define('root', $matches[0]);
    }

    /**
     * Route the current request URI.
     */
    public static function route() {
        self::setRootWebApp();
        $parsedRequest = self::parseRequestUri();
        $controller = self::getController($parsedRequest);
        $method = self::getMethodName($parsedRequest);
        $args = self::getArgs($parsedRequest);
        self::executeMethod($controller, $method, $args);
    }

}
