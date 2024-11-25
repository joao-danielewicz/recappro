<?php
class CosmeticsController extends RenderView{
    private $method;

    public function __construct($method){
        $this->method=$method;
    }

    private function verifyAdmin(){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }else{
            session_start();
            if(!$_SESSION['usuario']->isAdmin){
                header('Location: /');
            }
        }
    }

    public function ComprarItem($post){
        if(empty($_COOKIE)){
            header("Location: /");
            die();
        }

        if(!isset($_POST['idItem'])){
            header("Location: /");
            die();
        }
        
        session_start();
        $idUsuario = $_SESSION['usuario']->idUsuario;
        session_abort();

        $this->index($this->method->ComprarItem($post['idItem'], $idUsuario));
    }

    public function index($msg=''){
        $this->loadView('Cosmetics/loja',[
            'msg' => $msg,
            'titulo' => "RecapPro - Loja de Pontos",
            'itens' => $this->GetItens()
        ]);
    }
    public function admin(){
        $this->verifyAdmin();
        
        $this->loadView('Cosmetics/admin', [
            'titulo' => "RecapPro - Cadastro de Cosméticos",
            'itens' => $this->GetItens()
        ]);
    }

    public function UpdateItem($item){
        $this->verifyAdmin();
        $this->method->Update($item);
        header('Location: /itensadmin');
    }

    public function DeleteItem($item){
        $this->verifyAdmin();
        $this->method->Delete($item);
        header('Location: /itensadmin');
    }

    public function GetItens(){
        $listaItens = $this->method->SelectAllCosmetics();
        $buildItens = [];
        if($listaItens != null){
            foreach($listaItens as $item){
                $buildItens[] = new Cosmetic(
                    $item['idItem'],
                    $item['descricao'],
                    $item['tipo'],
                    $item['preco'],
                    $item['midia']
                );
            }
        }
        return $buildItens;
        return $this->method->SelectAllItens();
    }

    public function InsertItem($item){
        $this->verifyAdmin();
        if(!empty($item)){
            $this->method->Insert($item);
            header("Location: /itensadmin");
            die();
        }
        header('Location: /');
    }
}