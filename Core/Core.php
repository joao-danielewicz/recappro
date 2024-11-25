<?php

class Core{
    public function run($routes, $post){
        isset($_SERVER['PATH_INFO']) ? $url = $_SERVER['PATH_INFO'] : $url = '/';
        ($url != '/') ? $url = rtrim($url, '/') : $url;

        $routerFound = false;
        foreach($routes as $path => $controller){

            $pattern = '#^'.preg_replace('/{id}/', '([\w+])', $path).'$#';

            if(preg_match($pattern, $url, $matches)){
                array_shift($matches);

                $routerFound = true;

                [$currentController, $action] = explode('@', $controller);

                require_once __DIR__."/../Controllers/$currentController.php";
                $database = str_replace('Controller', '', $currentController) . 'OnDatabase';
                
                if(file_exists(__DIR__."/../Storage/$database.php")){
                    require_once __DIR__."/../Storage/$database.php";
                    $newDatabase = new $database();
                }else{
                    $newDatabase = '';
                }

                $newController = new $currentController($method = $newDatabase);
                $newController->$action($post);
            }
        }
        
        if(!$routerFound){
            require_once __DIR__."/../Controllers/NotFoundController.php";
            $controller = new NotFoundController();
            $controller->index();
        }
    } 
}