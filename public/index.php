<?php

function parse_uri_path() {
    $paths = array();
    $website_folder = 'cinetoile'; // Set it to empty string if the folder is at the document root
    $request_uri = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH);
    $request = substr($request_uri, strpos($request_uri, $website_folder) + strlen($website_folder));
    parse_uri_path_rec($request, $paths);
    return $paths;
}

function parse_uri_path_rec($request_uri, array &$res_array) {
    $uri_pattern = '(/([^/]+)(/.*)?)';
    $matches = array();
    preg_match($uri_pattern, $request_uri, $matches);
    if (empty($matches[0]) || empty($matches[1])) {
        return;
    }
    $res_array[] = $matches[1];
    if (isset($matches[2])) {
        parse_uri_path_rec($matches[2], $res_array);
    }
}

function parse_uri_controller_name($paths) {
    if (empty($paths)) {
        return 'IndexController';
    } else {
        return ucfirst($paths[0]) . 'Controller';
    }
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
            $controller->defaultAction();
        }
    }
}

$paths = parse_uri_path();

$controllerName = parse_uri_controller_name($paths);
require_once 'Controllers/' . $controllerName . '.class.php';

$controller = new $controllerName();
$method = parse_uri_method_name($paths);
$args = parse_uri_args($paths);

execute_method($controller, $method, $args);