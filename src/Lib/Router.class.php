<?php

/**
 * Description of Router
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
class Router {

    // Keep controllers in cache
    private static $controllers = array();

    private static function parseUriPath() {
        $website_folder = '/cinetoile/'; // Set it to / if the folder is at the document root
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

    private static function parseControllerName(array $paths) {
        if (empty($paths)) {
            return 'index';
        } else {
            return $paths[0];
        }
    }

    private static function parseControllerClassName(array $paths) {
        return ucfirst(self::parseControllerName($paths)) . 'Controller';
    }

    private static function parseControllerFilename(array $paths) {
        $controllerClassName = self::parseControllerClassName($paths);
        return 'Controllers/' . $controllerClassName . '.class.php';
    }

    private static function parseController(array $paths) {
        $controllerName = self::parseControllerName($paths);
        $controllerClassName = self::parseControllerClassName($paths);
        if (!stream_resolve_include_path(self::parseControllerFilename($paths))) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        if (!isset(self::$controllers[$controllerName])) {
            self::$controllers[$controllerName] = new $controllerClassName();
        }
        return self::$controllers[$controllerName];
    }

    private static function parseMethodName(array $paths) {
        if (!isset($paths[1])) {
            return 'defaultAction';
        }
        return $paths[1];
    }

    private static function parseArgs(array $paths) {
        if (!isset($paths[0]) && !isset($paths[1])) {
            return NULL;
        }
        array_slice($paths, 2);
        return $paths;
    }

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

    public static function route() {
        $paths = self::parseUriPath();
        $controller = self::parseController($paths);
        $method = self::parseMethodName($paths);
        $args = self::parseArgs($paths);
        self::executeMethod($controller, $method, $args);
    }

}
