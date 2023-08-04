<?php

function atualizaDatabase($database, $newJson){
    if(file_put_contents($database, $newJson)){
        echo ">> A base de dados foi atualizada!\n";
    }else{
        echo "\n >> ERRO AO GRAVAR OS DADOS << \n";
        return;
    }
}

function printOptions(){
    echo "\n\n>> '1' para adicionar novos alunos\n>> '2' para verificar as informações de todos os alunos\n>> '3' para ver as informações de um aluno\n";
}