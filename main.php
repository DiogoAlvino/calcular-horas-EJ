<?php
require_once './functions.php';

$db = "./database.json";
if (file_exists($db)) {

    $fileSize = filesize($db);
    echo "\n>> Bem vindo ao dashboard de horas da ExceptionJr! <<\n";
    if ($fileSize === 0) { //caso a base de dados esteja vazia iremos inicializala
        $alunos = [];
        
        echo ">> Vimos que esse é o seu primeiro contato com a ferramenta, sendo assim, será necessário realizar a carga do nome dos alunos!\n";

        while(true){
            $addAluno = readline(">> Digite 'parar' para sair: ");
            if($addAluno == 'parar'){
                break;
            }else{
                array_push($alunos, array("nome" => $addAluno, "horasTotais" => null, "tasks" => null));
            }
        }
        $alunos = array("alunos" => $alunos);
        $alunos = json_encode($alunos);

        atualizaDatabase($db, $alunos);

    }

    $allAlunos = file_get_contents($db);
    $allAlunos = json_decode($allAlunos, true);
    
    while(true){
        printOptions();

        $optionSelected = (int)readline("-- Digite: ");
    
        if($optionSelected == 1){
            while(true){
                $newAluno = readline(">> Digite o nome do novo aluno (caso queira sair basta digitar 'parar'): ");
                if($newAluno == 'parar'){
                    break;
                }else{
                    array_push($allAlunos['alunos'], array("nome" => $newAluno, "horasTotais" => null, "tasks" => null));
                }
            }
            atualizaDatabase($db, json_encode($allAlunos));
        
        }else if($optionSelected == 2){
            infoAlunos($allAlunos);
        
        }else if($optionSelected == 3){
            $nomeAluno = readline(">> Para buscar informações de um aluno, digite o nome: ");
            $infoAluno = buscaAluno($nomeAluno, $allAlunos);

            if($infoAluno){
                echo "\n----------------\n";
                echo ">> Nome: ".$infoAluno['nome']."\n";
                if(is_null($infoAluno['horasTotais'])){
                    echo ">> Horas Totais: 0\n";
                }else{
                    echo ">> Horas Totais: ".$infoAluno['horasTotais']."\n";
                }
                echo "----------------\n";
            }else{
                echo "\n-- ESSE ALUNO NÃO ESTÁ CADASTRADO NA BASE DE DADOS --\n";
            }
        
        }else if($optionSelected == 4){
            $nomeAluno = readline(">> Para adicionar uma task, digite o nome do aluno: ");
            $nomeTask = readline(">> Nome da task: ");
            $horas = (int)readline(">> Digite as horas para fazer a task: ");
            $minutos = (int)readline(">> Digite os minutos para fazer a task: ");
        
            adicionarTask($nomeAluno, $nomeTask, $horas, $minutos, $allAlunos);

        }else if($optionSelected == 5){
            $nomeAluno = readline(">> Para visualizar as tasks de um aluno, digite o nome: ");
            visualizarTasks($nomeAluno, $allAlunos);
            
        }else{
            break;
        }
                
    }
} else {
    echo "Necessário criar o arquivo database.json";
}