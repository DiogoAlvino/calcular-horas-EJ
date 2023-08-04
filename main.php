<?php
require_once './functions.php';

$db = "./database.json";
if (file_exists($db)) {

    $fileSize = filesize($db);
    echo "\n>> Bem vindo ao dashboard de horas da ExceptionJr! <<\n";
    if ($fileSize === 0) { //caso a base de dados esteja vazia iremos inicializala
        $alunos = [];
        
        echo "\n>> Vimos que esse é o seu primeiro contato com a ferramenta, sendo assim, será necessário realizar a carga do nome dos alunos!\n";

        while(true){
            $addAluno = readline(">> Digite 1 para parar: ");
            if($addAluno == "1"){
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
                $newAluno = readline("\n>> Digite o nome do novo aluno (caso queira parar basta digitar 1): ");
                if($newAluno == 1){
                    break;
                }else{
                    array_push($allAlunos['alunos'], array("nome" => $newAluno, "horasTotais" => null, "tasks" => null));
                }
            }
            atualizaDatabase($db, json_encode($allAlunos));
        }else{
            break;
        }
                
    }
} else {
    echo "Necessário criar o arquivo database.json";
}