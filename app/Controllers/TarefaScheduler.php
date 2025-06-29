<?php

// É na classe TarefaScheduler que ocorre grande parte da lógica de nosso estudo de caso.
// Fica sob responsabilidade dela a ativdade de definir uma nova data de estudo com base na capacidade do usuário de se lembrar da resposta de uma tarefa.
// Ou seja: se na área de estudo o usuário informar se lembrou de uma tarefa de modo fácil, a tarefa avançará um nível de estudo.
// Caso contrário, ela irá voltar um nível.
// O nivel de estudo dirá quantos dias passarão até que o usuário veja a tarefa novamente, com base num cálculo exponencial de base 2.

class TarefaScheduler{
    // Esta função auxilia ao Cadastro e ao Estudo, efetivando o cálculo exponencial.
    // Inicialmente, é recebida a data atual, que representa o momento de estudo.
    // A ela são adicionados um período de X dias, evidenciados em DateInterval, onde P representa o Período, seguido pelo cálculo exponencial, e D para indicar os dias.
    // O retorno da função é a data formatada, pronta para ser inserida no Banco de Dados.
    private function GetProximaDataEstudo($tarefa){
        $dataProximoEstudo = new DateTime('now');
        $dataProximoEstudo->add(new DateInterval('P'.(2**$tarefa['nivelEstudo']).'D'));

        return date_format($dataProximoEstudo, "Y-m-d");
    }

    // A função CadastroTarefa é chamada quando desejamos inserir uma nova tarefa ao curso.
    // Primeiramente, definimos o nível de Estudo como 0 para que seja adicionado somente 1 dia à data de estudo, assim, a veremos amanhã. (2^0=1)
    // Após isso, definimos a data do último estudo e de adição como a data atual.
    // Por fim, chamamos a função privada GetProximaDataEstudo para efetuar o cálculo de dias e retornamos a tarefa para inclusão no armazenamento.
    public function CadastroTarefa($tarefa){
        $tarefa['nivelEstudo'] = 0;
        $tarefa['dataAdicao'] = date_format(new DateTime('now'), "Y-m-d");
        $tarefa['dataUltimoEstudo'] = date_format(new DateTime('now'), "Y-m-d");
        $tarefa['dataProximoEstudo'] = $this->GetProximaDataEstudo($tarefa);        
        
        return $tarefa;
    }

    // Abaixo, encontra-se a função Estudar. Ela será aplicada sobre todas as tarefas de uma sessão de estudo finalizada.
    // Sua finalidade é preparar a Tarefa para uma atualização no banco de dados, com as novas informações referentes ao estudo realizado.
    // Para tal, primeiramente irá diferenciar a dificuldade de resposta do usuário, entre fácil e difícil.
    // Caso o usuário identifique a resposta como difícil de ser lembrada, um nível será diminuído.
    // Por outro lado, se a tarefa for fácil, ela aumentará um nível de estudo.
    // O nível aumentará até atingir o valor 7, caso em que travará os intervalos de resposta num máximo de 128 dias.
    // Optamos por esta restrição pois, caso contrário, os intervalos entre os estudos aumentariam infinitamente.
    // E deste modo, o usuário ainda verá a tarefa com regularidade, podendo exclui-la caso sinta-se confortável.

    // Após, definirá o último estudo como a data atual e o próximo estudo conforme a regra já mencionada.
    public function Estudar($tarefa){
        if($tarefa['estudar'] == "dificil"){
            if($tarefa['nivelEstudo'] != 0){
                $tarefa['nivelEstudo'] --;
            }
        }else if($tarefa['estudar'] == "facil"){
            if($tarefa['nivelEstudo'] <= 7){
                $tarefa['nivelEstudo'] ++;
            }
        }


        $tarefa['dataUltimoEstudo'] = date_format(new DateTime('now'), "Y-m-d");
        $tarefa['dataProximoEstudo'] = $this->GetProximaDataEstudo($tarefa);

        unset($tarefa['estudar']);
        return $tarefa;
    }
}