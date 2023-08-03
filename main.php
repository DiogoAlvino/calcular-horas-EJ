<?php

$db = "database.json";


if (file_exists($db)) {

    $fileSize = filesize($db);

    if ($fileSize === 0) { //caso a base de dados esteja vazia iremos inicializala
        echo "O arquivo está vazio.";
    } else {
        echo "O arquivo não está vazio.";
    }
} else {
    echo "Necessário criar o arquivo database.json";
}