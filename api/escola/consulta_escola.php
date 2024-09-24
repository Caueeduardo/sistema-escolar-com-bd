<?php
require_once("../core/header.php");

echo '<h3 style="text-align:center;">CONSULTA DE ESCOLA</h3>';

$htmlTabelaEscolas = "<a href='escola.php' target='_blank'><button class='button' type='button'>Incluir<button></a>";

$htmlTabelaEscolas .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaEscolas .= "<head>";

// TITULOS DA TABLE
$htmlTabelaEscolas .= "<tr>";
$htmlTabelaEscolas .= "  <th>Código</th>";
$htmlTabelaEscolas .= "  <th>Descrição</th>";
$htmlTabelaEscolas .= "  <th>Cidade</th>";
$htmlTabelaEscolas .= "  <th colspan='2'>Ações</th>";
$htmlTabelaEscolas .= "</tr>";

$htmlTabelaEscolas .= "</head>";

// CORPO DA TABELA
$htmlTabelaEscolas .= "<tbody>";

// LINHAS DA TABELA
// LER OS DADOS DO ARQUIVO
$arDadosEscolas = array();
// Primeiro, verifica se existe dados no arquivo json
// @ na frente do metodo, remove o warning
$dadosEscolas = @file_get_contents("escola.json");
if($dadosEscolas){
    // transforma os dados lidos em ARRAY, que estavam em JSON
    $arDadosEscolas = json_decode($dadosEscolas, true);
}

foreach($arDadosEscolas as $aDados){
    // echo '<br>lendo dados do Escola: ' . json_encode($aDados);

    // ABRIR UMA NOVA LINHA
    $htmlTabelaEscolas .= "<tr>";
    
    // COLUNAS DENTRO DA LINHA
    // ALINHAMENTO
    // TEXTO, ALINHADO A ESQUERDA
    // VALORES, ALINHADOS A DIREITA
    $htmlTabelaEscolas .= "<td align='center'>" . $aDados["codigo"] . "</td>";
    $htmlTabelaEscolas .= "<td>" . $aDados["descricao"] . "</td>";

    $codigoCidade = $aDados["cidade"];
    $nomeCidade = getDescricaoPorCodigo($codigoCidade, "cidade", $nomeColuna = "descricao");

    $htmlTabelaEscolas .= "<td>" . $nomeCidade . "</td>";

    // Adiciona a ação de excluir Escola
    $codigoEscola = $aDados["codigo"];

    $htmlTabelaEscolas .= '<td>';
    $htmlTabelaEscolas .= getAcaoExcluir('escola', $codigoEscola);
    $htmlTabelaEscolas .= '</td>';

    $htmlTabelaEscolas .= '<td>';
    $htmlTabelaEscolas .= getAcaoAlterar('escola', $codigoEscola);
    $htmlTabelaEscolas .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaEscolas .= "</tr>";
}

$htmlTabelaEscolas .= "</tbody>";

$htmlTabelaEscolas .= "</table>";

echo $htmlTabelaEscolas;

require_once("../core/footer.php");
