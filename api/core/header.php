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

$html = '
<!DOCTYPE html>
<html lang="pt-br">
    <head>
          <meta charset="UTF-8">
          <title>Sistema Escolar</title>
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/button.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/header.css">          
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/table.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/checkbox.css">
          <link rel="stylesheet" href="http://localhost/' . $pasta . '/api/css/style.css">
          <script src="http://localhost/' . $pasta . '/api/js/api.js" defer async></script>          
    </head>
<body class="background-06">
    <div class="header">
        <ul style="display:none;">
            <li><a href="' . $home . '">Home</a></li>
            <li><a href="../' . $url_inicial . 'aluno/consulta_aluno.php">Alunos</a></li>
            <li><a href="../' . $url_inicial . 'professor/consulta_professor.php">Professor</a></li>
            <li><a href="../' . $url_inicial . 'escola/consulta_escola.php">Escola</a></li>
            <li><a href="../' . $url_inicial . 'turma/consulta_turma.php">Turma</a></li>
            <li><a href="../' . $url_inicial . 'materia/consulta_materia.php">Matéria</a></li>            
        </ul>        
        <ul>
            <li><a href="' . $home . '">Home</a></li>';

    // Ler os menus do sistema do banco de dados
    $aListaMenu = getQuery()->selectAll("select * from menu order by mencodigo");
    foreach($aListaMenu as $aDados){
        $tabela = $aDados["mentabela"] ;
        $nomeConsulta = ucfirst(strtolower($aDados["mentabela"]));

        $html .= '<li><a href="../' . $url_inicial . $tabela . '/Consulta' . $nomeConsulta . '.php">' . $nomeConsulta . '</a></li>';
    }

     $html .= '</ul>
        <hr>
    </div>    
    <div class="container">';
    // abre o container

echo $html;
