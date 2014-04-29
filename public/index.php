<?php

require_once 'Controllers/Controller.class.php';

function parse_uri_path() {
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

function parse_uri_folder_name($paths) {
    if (empty($paths)) {
        return 'index';
    } else {
        return $paths[0];
    }
}

function parse_uri_controller_name($paths) {
    $folder = parse_uri_folder_name($paths);
    return ucfirst($folder) . 'Controller';
}

function parse_uri_method_name($paths) {
    if (!isset($paths[1])) {
        return 'defaultAction';
    }
    return $paths[1];
}

function parse_uri_args($paths) {
    if (!isset($paths[0]) && !isset($paths[1])) {
        return NULL;
    }
    array_slice($paths, 2);
    return $paths;
}

function execute_method($controller, $method_name, $args) {
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

$paths = parse_uri_path();

$controllerName = parse_uri_controller_name($paths);
$controllerFile = 'Controllers/' . parse_uri_folder_name($paths) . '/' . $controllerName . '.class.php';

if (stream_resolve_include_path($controllerFile)) {
    require_once $controllerFile;
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$controller = new $controllerName();
$method = parse_uri_method_name($paths);
$args = parse_uri_args($paths);

execute_method($controller, $method, $args);