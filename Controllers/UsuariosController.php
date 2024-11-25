<?php

class UsuariosController extends RenderView{
    private $method;

    public function __construct($method){
        $this->method = $method;
    }
    public function login($msg = ''){
        $this->loadView('/Usuarios/login',
        [
            'msg' => $msg,
            'titulo' => "RecapPro - Entrar"
        ]);
    }

    public function cadastro($msg = ''){
        $this->loadView('/Usuarios/cadastro',
        [
            'msg' => $msg,
            'titulo' => "RecapPro - Cadastro"
        ]);
    }

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

    private function GetGaleria($idUsuario){
        return $this->method->GetGaleria($idUsuario);
    }

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

    public function Sair(){
        session_start();
        session_destroy();
        setcookie('PHPSESSID',"", time() - 3600);

        var_dump($_COOKIE);
        header("Location: /");
    }

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
    
    public function UpdateUsuario($post){
        return $this->method->Update($post);
    }

    public function DeleteUsuario($post){
        return $this->method->Delete($post);
    }
}