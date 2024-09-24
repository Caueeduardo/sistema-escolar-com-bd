<?php

require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE MATERIA</h3>';

$htmlTabelaMaterias = "<a href='materia.php'><button class='button' type='button'>Incluir<button></a>";
$htmlTabelaMaterias .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaMaterias .= "<head>";

// TITULOS DA TABLE
$htmlTabelaMaterias .= "<tr>";
$htmlTabelaMaterias .= "  <th>Código</th>";
$htmlTabelaMaterias .= "  <th>Curso</th>";// Nome da Escola - buscar pelo codigo
$htmlTabelaMaterias .= "  <th>Nome</th>";

$htmlTabelaMaterias .= "</head>";
$htmlTabelaMaterias .= "<tbody>";

$arDadosMaterias = array();
$dadosMaterias = @file_get_contents("materia.json");
if($dadosMaterias){
    $arDadosMaterias = json_decode($dadosMaterias, true);
}

foreach($arDadosMaterias as $aDados){
    // ABRIR UMA NOVA LINHA
    $htmlTabelaMaterias .= "<tr>";
    $htmlTabelaMaterias .= "<td align='center'>" . $aDados["codigo"] . "</td>";

    $codigoTurma = $aDados["turma"];
    $nomeTurma = getDescricaoPorCodigo($codigoTurma, "turma", $nomeColuna = "nome");

    $htmlTabelaMaterias .= "<td align='left'>" . $nomeTurma . "</td>";

    $htmlTabelaMaterias .= "<td align='left'>" . $aDados["nome"] . "</td>";

    // Adiciona a ação de excluir aluno
    $codigo = $aDados["codigo"];

    $htmlTabelaMaterias .= '<td>';
    $htmlTabelaMaterias .= getAcaoExcluir('materia', $codigo);
    $htmlTabelaMaterias .= '</td>';

    $htmlTabelaMaterias .= '<td>';
    $htmlTabelaMaterias .= getAcaoAlterar('materia', $codigo);
    $htmlTabelaMaterias .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaMaterias .= "</tr>";
}

$htmlTabelaMaterias .= "</tbody>";
$htmlTabelaMaterias .= "</table>";

echo $htmlTabelaMaterias;

require_once("../core/footer.php");
