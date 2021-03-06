<?php
/*
 * Copyright (c) 2014 Alberto González
 * Distributed under MIT License
 * (see README for details)
 */

namespace Quaver\Core;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;
use Quaver\Core\Lang;
use Quaver\App\Model\User;

/**
 * Router class
 * @package Core
 */
class Router
{
    public $version = '0.9';
    public $routes;
    public $modules;

    // Language system
    public $language;

    // URL management
    public $url;
    public $queryString;

    /**
     * Router constructor
     * @return type
     */
    public function __construct()
    {

        $this->routes = array();

        if (isset($GLOBALS['_lang'])) {
            $this->language = $GLOBALS['_lang']->id;
        }

        // Restoring user_default session sample
        if (!empty($this->queryString['PHPSESSID'])) {
            $sessionHash = $this->queryString['PHPSESSID'];
            $_userFromSession = new User;
            $_userFromSession->setCookie($sessionHash);
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            header("Location: $url");
            exit;
        }


    }

    /**
     * Routing flow
     * @return type
     */
    public function route()
    {
        $route = $this->getCurrentRoute();
        $this->fixTrailingSlash($route);
        $controller = $this->getController($route);

        if ($controller != false) {
            $this->dispatch($controller);
        }
    }

    /**
     * Add new paths (yml)
     * @param type $container 
     * @param type $path 
     * @return type
     */
    public function addPath($container, $path)
    {
        try {

            $yaml = new Parser();
            $elements = $yaml->parse(file_get_contents($path));

            // Asign each routes
            isset($this->routes[$container]) ? $this->routes[$container] += $elements: $this->routes[$container] = $elements;

        } catch (ParseException $e) {
            throw new \Quaver\Core\Exception("Unable to parse the YAML string: %s", $e->getMessage());
        }           
    }

    /**
     * Add modules to Quaver
     * @param type $moduleName 
     * @param type $packageName 
     * @param type $modulePath 
     * @param type $moduleRoute 
     * @return type
     */
    public function addModule($moduleName, $packageName, $modulePath = '', $moduleRoute = '/')
    {   
        try {

            $namespace = '\\Quaver\\' . $moduleName . '\\App';
            $namespacePath = '/Quaver/' . $moduleName . '/App';

            // Load config class of module
            $class = $namespace . '\\Config'; 
            $newModule = new $class();
            $newModule->getParams();

            // Load module configuration
            isset($this->modules[$moduleName]) ? $this->modules[$moduleName]['params'] += $newModule: $this->modules[$moduleName]['params'] = $newModule;
            
            // Set namespace and paths vars
            $this->modules[$moduleName]['namespace'] = $namespace;
            $this->modules[$moduleName]['namespacePath'] = $namespacePath;
            $this->modules[$moduleName]['packageName'] = $packageName;
            $this->modules[$moduleName]['realPath'] = $modulePath ? $modulePath . '/' . $packageName : VENDOR_PATH . '/' . $packageName;

            // Load routes of module
            !empty($modulePath) ? $this->addPath($moduleRoute, $modulePath . '/' . $packageName . '/' . $namespacePath . '/' . 'Routes.yml') : $this->addPath($moduleRoute, VENDOR_PATH . '/' . $packageName . '/' . $namespacePath . '/' . 'Routes.yml');

        } catch (ParseException $e) {
            throw new \Quaver\Core\Exception("Unable to load module: $moduleName", $e->getMessage());
        }

    }
    
    /**
     * Get actual URI
     * @param type $position 
     * @return type
     */
    public function getUrlPart($position)
    {
        if (isset($this->url['uri'][$position])) {
            return $this->url['uri'][$position];
        }
        return null;
    }

    /**
     * Get current URL/URI
     * @param type $position 
     * @return type
     */
    public function getCurrentURL($position = 0)
    {
        $return = false;
        $length = count($this->url['uri']);

        if ($position == 0 && $length > 0) {

            $position = $length - 1;

            if (is_numeric($this->getUrlPart($position))) {
                $position -= 1;                
            }
        }

        if ($length == 0) {
            $return = $this->url['path'];
        } else {
            $return = $this->getUrlPart($position);
        }

        return $return;
    }

    /**
     * Get current action to route
     * @return type
     */
    public function getCurrentRoute()
    {
        $url = $_SERVER['REQUEST_URI'];

        if (strstr($url, "?") !== false) {
            $url = substr($url, 0, strpos($url, "?")); // Remove GET vars
        }

        return $url;
    }

    /**
     * Fix trailing slash
     * @param type $_url 
     * @return type
     */
    public function fixTrailingSlash($_url)
    {
        if ($_url{strlen($_url) - 1} != '/' && strstr($_url, "image/") === false) {
            header("Location: " . $_url . "/");
            exit;
        }
    }

    /**
     * Remove slash
     * @param type $_url 
     * @return type
     */
    public function removeSlash($_url)
    {
        $url = str_replace('/', '', $_url);
        return $url;
    }

    /**
     * Get asociate controller
     * @param type $url 
     * @return type
     */
    public function getController($_url)
    {

        $return = false;
        $controller = false;

        foreach ($this->routes as $indexPath => $container) {
            
            $regexp = "/^" . str_replace(array("/", "\\\\"), array("\/", "\\"), $indexPath) . "/";
            preg_match($regexp, $_url, $match);

            if ($match) {

                foreach ($container as $item) {

                    $regexp = "/^" . str_replace(array("/", "\\\\"), array("\/", "\\"), $item['url']) . "$/";
                    preg_match($regexp, $_url, $match);

                    if ($match) {
                        $this->url = array(
                            "uri" => array_splice($match, 1),
                            "path" => $match[0],
                            "host" => $_SERVER['HTTP_HOST'],
                            "protocol" => empty($_SERVER['HTTPS'])? 'http://' : 'https://'
                        );
                        $controller = $item;
                        break;
                    }
                }
            }

            
        }

        if (isset($controller['controller'])) {
            $return = $controller;
        } else {
            $this->dispatch('e404');
        }

        return $return;
    }

    /**
     * Dispatch action
     * @param type $controller 
     * @return type
     */
    public function dispatch($controller)
    {

        global $_lang, $_user;

        try {

            if ($controller == 'e404') {
                $controller = $this->routes['/']['404'];
            }

            if ($controller == 'maintenance') {
                $controller = $this->routes['/']['maintenance'];
            }
            
            if ($controller) {

                if (isset($controller['path'])) {
                    $controllerPath = $controller['path'];
                    $pathNamespace = $controllerPath . '\\';
                } else {
                    $controllerPath = '';
                    $pathNamespace = '';
                }

                if (isset($controller['view'])) {
                    $controllerView = $controller['view'];
                }

                $defaultNamespace = '\\Quaver\\App\\Controller\\';
                
                $controllerURL = $controller['url'];
                $controllerName = $controller['controller'];
                $controllerNamespace = $defaultNamespace . $pathNamespace . $controllerName;
                $actionName = isset($controller['action']) ? $controller['action'] . 'Action' : 'indexAction';

                $realPath = !empty($controllerPath) ? CONTROLLER_PATH . '/' . $controllerPath . '/' . $controllerName . '.php' : CONTROLLER_PATH . '/' . $controllerName . '.php';

                // Try to load controller
                if (file_exists($realPath)) {
                    
                    $controller = new $controllerNamespace($this);

                    if (isset($controllerView) && $controllerView != 'none') {
                        
                        $controller->setView($controllerView);
                    }

                    $controller->$actionName();
                    
                } else {
                    foreach ($this->modules as $module) {

                        $moduleNamespace = $module['namespace'];
                        $realModulePath = !empty($controllerPath) ? $module['realPath'] . $module['namespacePath'] . '/Controller/' . $controllerPath . '/' . $controllerName . '.php' : $module['realPath'] . $module['namespacePath'] . '/Controller/' . $controllerName . '.php';

                        // Try to load module controller
                        if (file_exists($realModulePath)) {
                            
                            $controllerNamespace = $moduleNamespace . $pathNamespace . '\\Controller\\' .$controllerName;
                            $controller = new $controllerNamespace($this);

                            if (isset($controllerView) && $controllerView != 'none') {
                                
                                $controller->setView($controllerView);
                            }

                            $controller->$actionName();
                            
                        }

                    }
                }
            }
        } catch (ParseException $e) {
            throw new \Quaver\Core\Exception("Unable to load controller: " . $controller['controller'], $e->getMessage());
        }
    }

    /**
     * Get query string from URI
     * @return type
     */
    public function getQueryString()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $qs = parse_url($uri, PHP_URL_QUERY);
        if (!empty($qs)) {
            parse_str($qs, $this->queryString);
        }
    }
}
