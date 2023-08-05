<?php

$dirDataBase = "./database.json";

function atualizaDatabase($database, $newJson){
    if(file_put_contents($database, $newJson)){
        echo ">> A base de dados foi atualizada!\n";
    }else{
        echo "\n >> ERRO AO GRAVAR OS DADOS << \n";
        return;
    }
}

function printOptions(){
    echo "\n>> '1' para adicionar novos alunos\n";
    echo ">> '2' para verificar as informações de todos os alunos\n";
    echo ">> '3' para ver as informações de um aluno\n";
    echo ">> '4' adicionar tasks para um aluno\n";
}

function infoAlunos($db){
    foreach($db['alunos'] as $aluno){
        echo "----------------\n";
        echo ">> Nome: ".$aluno['nome']."\n";
        echo ">> Horas Totais: ".$aluno['horasTotais']."\n";
    }
}

function buscaAluno($nomeAluno, $db){
    foreach($db['alunos'] as $aluno){
        if($aluno['nome'] == $nomeAluno){
            return $aluno;
        }
    }

    return false;
}

function adicionarTask($nomeAluno, $nomeTask, $horas, $minutos, &$db){
    global $dirDataBase;

    foreach ($db['alunos'] as &$aluno) {
        if ($aluno['nome'] === $nomeAluno) {
            if (!isset($aluno['tasks'])) {
                $aluno['tasks'] = [];
            }
            
            $taskExists = false;
            foreach ($aluno['tasks'] as &$task) {
                if ($task['nomeTask'] === $nomeTask) {
                    $task['horas'] += $horas;
                    $task['minutos'] += $minutos;
                    $taskExists = true;
                    break;
                }
            }
            
            if (!$taskExists) {
                $aluno['tasks'][] = [
                    'nomeTask' => $nomeTask,
                    'horas' => $horas,
                    'minutos' => $minutos
                ];
            }

            atualizaDatabase($dirDataBase, json_encode($db));
            break;
        }
    }
}
