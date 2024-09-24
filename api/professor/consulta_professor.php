<?php
require_once("../core/header.php");

$htmlTabelaProfessor = "<h3 style='text-align:center;'>CONSULTA DE PROFESSOR</h3>";

$htmlTabelaProfessor .= "<a href='professor.php'><button class='button' type='button'>Incluir<button></a>";

$htmlTabelaProfessor .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaProfessor .= "<head>";

// TITULOS DA TABLE
$htmlTabelaProfessor .= "<tr>";
$htmlTabelaProfessor .= "  <th>Código</th>";
$htmlTabelaProfessor .= "  <th>Nome</th>";
$htmlTabelaProfessor .= "  <th>E-mail</th>";
$htmlTabelaProfessor .= "  <th>Senha</th>";
$htmlTabelaProfessor .= "  <th colspan='2'>Ações</th>";
$htmlTabelaProfessor .= "</tr>";

$htmlTabelaProfessor .= "</head>";

// CORPO DA TABELA
$htmlTabelaProfessor .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosProfessor = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosProfessor = @file_get_contents("professor.json");
if($dadosProfessor){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosProfessor = json_decode($dadosProfessor, true);
}

foreach($arDadosProfessor as $aDados){
    // echo '<br>lendo dados do aluno: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaProfessor .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaProfessor .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaProfessor .= "<td>" . $aDados["nome"] . "</td>";
    $htmlTabelaProfessor .= "<td>" . $aDados["email"] . "</td>";
    $htmlTabelaProfessor .= "<td>" . $aDados["senha"] . "</td>";

    // Adiciona a ação de excluir aluno
    $codigoProfessor = $aDados["codigo"];

    $htmlTabelaProfessor .= '<td>';
    $htmlTabelaProfessor .= getAcaoExcluir('professor', $codigoProfessor);
    $htmlTabelaProfessor .= '</td>';

    $htmlTabelaProfessor .= '<td>';
    $htmlTabelaProfessor .= getAcaoAlterar('professor', $codigoProfessor);
    $htmlTabelaProfessor .= '</td>';


    // FECHAR A LINHA ATUAL
    $htmlTabelaProfessor .= "</tr>";
}

$htmlTabelaProfessor .= "</tbody>";

$htmlTabelaProfessor .= "</table>";

echo $htmlTabelaProfessor;

require_once("../core/footer.php");
