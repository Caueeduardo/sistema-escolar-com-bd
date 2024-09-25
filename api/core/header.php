<?php

require_once("Utils.php");

$pasta = "sistema-escolar-com-bd";

$request_uri = $_SERVER['REQUEST_URI'];
$url_inicial = "";
$url_inicial_css = "../";

$uricomparacao = "/" . $pasta . "/api/index.php";
if($request_uri == $uricomparacao 
    || $request_uri == "/" . $pasta . "/api/"
    || $request_uri == "/" . $pasta . "/"
    || $request_uri == "/" . $pasta . "/index.php"
    ){

    $url_inicial_css = "api/";
    $url_inicial = $pasta . "/api/";
    
    if($request_uri == $uricomparacao){
        $url_inicial_css = "api/";
    }
}

$home = "http://localhost/" . $pasta . "/index.php";

echo '
<!DOCTYPE html>
<html lang="pt-br">
    <head>
          <meta charset="UTF-8">
          <title>Sistema Escolar</title>
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/style.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/button.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/header.css">          
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/table.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/checkbox.css">
          <script src="http://localhost/' . $pasta . '/api/js/api.js" defer async></script>          
    </head>
<body class="background-06">
    <div class="header">
        <ul>
            <li><a href="' . $home . '">Home</a></li>
            <li><a href="../' . $url_inicial . 'aluno/consulta_aluno.php">Alunos</a></li>
            <li><a href="../' . $url_inicial . 'professor/consulta_professor.php">Professor</a></li>
            <li><a href="../' . $url_inicial . 'escola/consulta_escola.php">Escola</a></li>
            <li><a href="../' . $url_inicial . 'turma/consulta_turma.php">Turma</a></li>
            <li><a href="../' . $url_inicial . 'materia/consulta_materia.php">Matéria</a></li>            
        </ul>
        <hr>
        <h1>Abaixo consulta com banco de dados:</h1>
        <ul>
            <li><a href="' . $home . '">Home</a></li>
            <li><a href="../' . $url_inicial . 'aluno/ConsultaAluno.php">Alunos</a></li>
            <li><a href="../' . $url_inicial . 'professor/ConsultaProfessor.php">Professor</a></li>
            <li><a href="../' . $url_inicial . 'escola/ConsultaEscola.php">Escola</a></li>
            <li><a href="../' . $url_inicial . 'turma/ConsultaTurma.php">Turma</a></li>
            <li><a href="../' . $url_inicial . 'materia/ConsultaMateria.php">Matéria</a></li>            
        </ul>

        <hr>
    </div>    
    <div class="container">';
    // abre o container