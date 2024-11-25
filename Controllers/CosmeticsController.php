<?php
class CosmeticsController extends RenderView{
    private $method;

    public function __construct($method){
        $this->method=$method;
    }

    // Verifica se há um usuário ativo e se ele se enquadra no papel de administrador.
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

    // Compra um item cosmético da loja de acordo com seu preço e o saldo de pontos do usuário.
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

    // Apresenta a página da loja para o usuário.
    public function index($msg=''){
        $this->loadView('Cosmetics/loja',[
            'msg' => $msg,
            'titulo' => "RecapPro - Loja de Pontos",
            'itens' => $this->GetItens()
        ]);
    }

    // Verifica se o usuário pode acessar e então apresenta a seção de controle da loja de itens cosméticos.
    public function admin(){
        $this->verifyAdmin();
        
        $this->loadView('Cosmetics/admin', [
            'titulo' => "RecapPro - Cadastro de Cosméticos",
            'itens' => $this->GetItens()
        ]);
    }

    // Passa o item cosmético para alteração no banco.
    public function UpdateItem($item){
        $this->verifyAdmin();
        $this->method->Update($item);
        header('Location: /itensadmin');
    }
    
    // Passa o item cosmético para exclusão no banco.
    public function DeleteItem($item){
        $this->verifyAdmin();
        $this->method->Delete($item);
        header('Location: /itensadmin');
    }

    // Recebe todos os itens cadastrados no banco e os converte em instâncias da classe Cosmetic.
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

    // Cadastra um novo item.
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