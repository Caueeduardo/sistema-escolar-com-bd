<?php
require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE ALUNO</h3>';

$htmlTabelaAlunos .= "<a href='aluno.php'><button class='button' type='button'>Incluir<button></a>";

$htmlTabelaAlunos .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaAlunos .= "<head>";

// TITULOS DA TABLE
$htmlTabelaAlunos .= "<tr>";
$htmlTabelaAlunos .= "  <th>Código</th>";
$htmlTabelaAlunos .= "  <th>Nome</th>";
$htmlTabelaAlunos .= "  <th>E-mail</th>";
$htmlTabelaAlunos .= "  <th>Senha</th>";
$htmlTabelaAlunos .= "  <th colspan='2'>Ações</th>";
$htmlTabelaAlunos .= "</tr>";

$htmlTabelaAlunos .= "</head>";

// CORPO DA TABELA
$htmlTabelaAlunos .= "<tbody>";

$arDadosAlunos = array();
$dadosAlunos = @file_get_contents("aluno.json");
if($dadosAlunos){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosAlunos = json_decode($dadosAlunos, true);
}

foreach($arDadosAlunos as $aDados){
    // echo '<br>lendo dados do aluno: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaAlunos .= "<tr>";
    $htmlTabelaAlunos .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["nome"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["email"] . "</td>";
    $htmlTabelaAlunos .= "<td>" . $aDados["senha"] . "</td>";

    // Adiciona a ação de excluir aluno
    $codigoAluno = $aDados["codigo"];

    $htmlTabelaAlunos .= '<td>';
    $htmlTabelaAlunos .= getAcaoExcluir('aluno', $codigoAluno);
    $htmlTabelaAlunos .= '</td>';

    $htmlTabelaAlunos .= '<td>';
    $htmlTabelaAlunos .= getAcaoAlterar('aluno', $codigoAluno);
    $htmlTabelaAlunos .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaAlunos .= "</tr>";
}

$htmlTabelaAlunos .= "</tbody>";
$htmlTabelaAlunos .= "</table>";

echo $htmlTabelaAlunos;

require_once("../core/footer.php");
