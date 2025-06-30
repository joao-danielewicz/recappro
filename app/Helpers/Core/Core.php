<?php

class Core{
    public function run($routes, $post){
        // Verifica se a URL digitada está vazia e atribui uma / a ela.
        // Em seguida, remove uma possível / ao fim da URL para que não haja erro ao definir o controlador. 
        isset($_SERVER['PATH_INFO']) ? $url = $_SERVER['PATH_INFO'] : $url = '/';
        ($url != '/') ? $url = rtrim($url, '/') : $url;

            // Define um foreach onde as rotas que definimos são percorridas;        
            // O $path é o caminho que possibilitamos ao usuário acessar,
            // E $controller é uma string com o controlador e a função que desejamos criar e chamar. 
            foreach($routes as $path => $controller){
            // Se quisermos trabalhar com rotas dinâmicas, por exemplo recappro/cursos/1, devemos criar uma rota 
            // /cursos/{id}. A função abaixo irá substituir o {id} pelo valor digitado na URL.
            $pattern = '#^'.preg_replace('/{id}/', '([\w+])', $path).'$#';

            // Poderíamos armazenar este ID em uma variável própria a partir da função preg_match, passando um terceiro parâmetro para ela
            // Os dados informados e que estivessem de acordo com a rota seriam armazenados neste parâmetro.
            // A função preg_match nos dirá se a rota informada foi encontrada dentro das que disponibilizamos ao usuário.
            if(preg_match($pattern, $url, $matches)){
                // Definimos o routerFound como True para que a página não seja redirecionada 
                $routerFound = true;

                
                
                // Abaixo, separamos qual controlador desejamos executar e qual função desejamos chamar dele.
                [$currentController, $action] = explode('@', $controller);

                // Fazemos o require do controller para que possamos instanciá-lo.
                require_once __DIR__."/../Controllers/$currentController.php";

                // Removemos a parte "controller" da string ModelController para que, caso necessário, criemos sua respectiva classe OnDatabase.
                $database = str_replace('Controller', '', $currentController) . 'OnDatabase';
                
                // Verificamos se o arquivo da classe Database existe no diretório, visto que temos controladores que têm o uso
                // de OnDatabase opcional (como o HomeController, por exemplo).                
                // Caso a classe exista, instanciamos um objeto dela.
                if(file_exists(__DIR__."/../Storage/$database.php")){
                    require_once __DIR__."/../Storage/$database.php";
                    $newDatabase = new $database();
                }else{
                    $newDatabase = '';
                }

                // Por fim, criamos o novo controlador com o método de armazenamento e chamamos a função desejada.
                $newController = new $currentController($method = $newDatabase);
                $newController->$action($post);
            }
        }
        
        // Caso a rota digitada não seja encontrada, encaminhamos o usuário para uma página de erro.
        if(!$routerFound){
            require_once __DIR__."/../Controllers/NotFoundController.php";
            $controller = new NotFoundController();
            $controller->index();
        }
    } 
}