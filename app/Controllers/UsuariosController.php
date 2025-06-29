<?php

class UsuariosController extends RenderView{
    private $method;

    public function __construct($method){
        $this->method = $method;
    }

    // Guia o usuário a página de log-in.
    public function login($msg = ''){
        $this->loadView('/Usuarios/login',
        [
            'msg' => $msg,
            'titulo' => "RecapPro - Entrar"
        ]);
    }

    // Guia o usuário a página de cadastro.
    public function cadastro($msg = ''){
        $this->loadView('/Usuarios/cadastro',
        [
            'msg' => $msg,
            'titulo' => "RecapPro - Cadastro"
        ]);
    }

    // Redireciona ao perfil do usuário, passando as informações dele contidas
    // E a galeria de seus itens cosméticos.
    public function perfil(){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }

        session_start();
        $usuario = $_SESSION['usuario'];
        session_abort();
        $this->loadView('Usuarios/perfil', [
            'usuario' => $usuario,
            'galeria' => $this->GetGaleria($usuario->idUsuario)
        ]);
    }

    // Seleciona todos os itens cosméticos que o usuário possui.
    private function GetGaleria($idUsuario){
        return $this->method->GetGaleria($idUsuario);
    }

    // Recebe qual a mídia que o usuário deseja inserir em sua foto de perfil.
    // Verifica se ela está disponível dentre aquelas que ele possui, e caso positivo, a altera.
    public function mudarfoto(){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }
        
        session_start();
        $idUsuario = $_SESSION['usuario']->idUsuario;
        foreach($this->GetGaleria($idUsuario) as $item){
            if($item['idItem'] == $_GET['idItem']){
                $_SESSION['usuario']->fotoPerfil = $item['midia'];
            }
        }
        
        $this->method->SetFotoPerfil($_GET['idItem'], $idUsuario);
        
        header('Location: /perfil');
    }

    // Cadastra um novo usuário caso o e-mail já não esteja presente na base de dados.
    public function InsertUsuario($usuario){
        if(!empty($usuario)){
            if($this->method->Insert($usuario)){
                header('Location: /login');
                die();
            }else {
                $msg = "Este e-mail já está em uso.";
                return $this->cadastro($msg);
            }
        }
        header('Location: /');
    }

    // Destrói a variável da sessão e o cookie, removendo efetivamente o log-in do usuário do navegador.
    public function Sair(){
        session_start();
        session_destroy();
        setcookie('PHPSESSID',"", time() - 3600);

        header("Location: /");
    }

    // Valida o log-in do usuário, verificando antes se alguma informação válida foi passada a função.
    // Caso a verificação seja bem sucedida, a variável SESSION recebe um objeto do modelo Usuário, mas sem a senha.
    public function VerificarLogin($login){
        if(!empty($login)){
            $usuario = $this->method->ValidarLogin($login);
            if($usuario){
                session_start();
                $_SESSION['usuario'] = new Usuario($usuario['idUsuario'],
                                                $usuario['nome'],
                                                $usuario['email'],
                                                $usuario['cursos'],
                                                new DateTime($usuario['dataNascimento']),
                                                $usuario['telefone'],
                                                $usuario['isAdmin'],
                                                $usuario['qtdPontos'],
                                                $usuario['fotoPerfil']);
                header('Location: /');
            }
        }
        return $this->login('Erro. Verifique seu login.');
    }
}