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
    echo ">> '2' para visualizar as horas de todos os alunos\n";
    echo ">> '3' para visualizar as horas de um aluno\n";
    echo ">> '4' adicionar tasks para um aluno\n";
    echo ">> '5' para ver todas as tasks de um aluno\n";
    echo ">> '9' para sair\n";
}

function infoAlunos($db){
    foreach($db['alunos'] as $aluno){
        echo "----------------\n";
        echo ">> Nome: ".$aluno['nome']."\n";
        if(is_null($aluno['horasTotais'])){
            echo ">> Horas Totais: 0\n";
        }else{
            echo ">> Horas Totais: ".$aluno['horasTotais']."\n";
        }
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

            $aluno['tasks'][] = [
                'nomeTask' => $nomeTask,
                'horas' => $horas,
                'minutos' => $minutos
            ];

            $horasTotaisEmSegundos = 0;
            foreach ($aluno['tasks'] as $task) {
                $horasTotaisEmSegundos += $task['horas'] * 3600 + $task['minutos'] * 60;
            }

            $horasTotais = segundosParaHorasMinutos($horasTotaisEmSegundos);
            $aluno['horasTotais'] = $horasTotais;

            break;
        }
    }

    atualizaDatabase($dirDataBase, json_encode($db));
}

function visualizarTasks($nomeAluno, $db){
    foreach($db['alunos'] as $aluno){
        if($aluno['nome'] == $nomeAluno){

            if(is_null($aluno['tasks'])){
                echo "\n-- O aluno não realizou tasks --\n";

            }else{
                for($i = 0; $i < count($aluno['tasks']); $i++){
                    $horasTask = $aluno['tasks'][$i]['horas'] * 3600 + $aluno['tasks'][$i]['minutos'] * 60;
                    echo "\n----------------\n";
                    echo "$i - ".$aluno['tasks'][$i]['nomeTask']."\n";
                    echo segundosParaHorasMinutos($horasTask)."\n";
                    echo "----------------\n";
                }
            }

            return;
        }
    }
    
    echo "\n-- ESSE ALUNO NÃO ESTÁ CADASTRADO NA BASE DE DADOS --\n";
}

function segundosParaHorasMinutos($segundos) {
    $horas = floor($segundos / 3600);
    $segundos %= 3600;
    $minutos = floor($segundos / 60);

    return "{$horas} horas e {$minutos} minutos";
}
