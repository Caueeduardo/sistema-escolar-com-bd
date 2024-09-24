<?php
require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE TURMA</h3>';

$htmlTabelaTurmas = "<a href='turma.php'><button class='button' type='button'>Incluir<button></a>";
$htmlTabelaTurmas .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaTurmas .= "<head>";

// TITULOS DA TABLE
$htmlTabelaTurmas .= "<tr>";
$htmlTabelaTurmas .= "  <th>Código</th>";
$htmlTabelaTurmas .= "  <th>Escola</th>";// Nome da Escola - buscar pelo codigo
$htmlTabelaTurmas .= "  <th>Nome</th>";
$htmlTabelaTurmas .= "  <th>Data Início</th>";
$htmlTabelaTurmas .= "  <th>Data Fim</th>";
$htmlTabelaTurmas .= "  <th>Status</th>";
$htmlTabelaTurmas .= "  <th>Período</th>";
$htmlTabelaTurmas .= "  <th colspan='2'>Ações</th>";
$htmlTabelaTurmas .= "</tr>";

$htmlTabelaTurmas .= "</head>";
$htmlTabelaTurmas .= "<tbody>";

$arDadosTurmas = array();

$dadosTurmas = @file_get_contents("turma.json");
if($dadosTurmas){
    $arDadosTurmas = json_decode($dadosTurmas, true);
}

foreach($arDadosTurmas as $aDados){
    // ABRIR UMA NOVA LINHA
    $htmlTabelaTurmas .= "<tr>";
    $htmlTabelaTurmas .= "<td align='center'>" . $aDados["codigo"] . "</td>";

    $codigoEscola = $aDados["escola"];
    $nomeEscola = getDescricaoPorCodigo($codigoEscola, "escola", $nomeColuna = "descricao");

    $htmlTabelaTurmas .= "<td align='left'>" . $nomeEscola . "</td>";

    $htmlTabelaTurmas .= "<td align='left'>" . $aDados["nome"] . "</td>";
    $htmlTabelaTurmas .= "<td>" . formataData($aDados["datainicio"]) . "</td>";
    $htmlTabelaTurmas .= "<td>" . formataData($aDados["datafim"]) . "</td>";
    $htmlTabelaTurmas .= "<td>" . $aDados["statuscurso"] . "</td>";
    $htmlTabelaTurmas .= "<td>" . $aDados["periodocurso"] . "</td>";

    // Adiciona a ação de excluir aluno
    $codigo = $aDados["codigo"];

    $htmlTabelaTurmas .= '<td>';
    $htmlTabelaTurmas .= getAcaoExcluir('turma', $codigo);
    $htmlTabelaTurmas .= '</td>';

    $htmlTabelaTurmas .= '<td>';
    $htmlTabelaTurmas .= getAcaoAlterar('turma', $codigo);
    $htmlTabelaTurmas .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaTurmas .= "</tr>";
}

$htmlTabelaTurmas .= "</tbody>";
$htmlTabelaTurmas .= "</table>";

echo $htmlTabelaTurmas;

require_once("../core/footer.php");
