<?php
// PROCESSAMENTO DA PAGINA
// echo "<pre>" . print_r($_POST, true) . "</pre>";return true;
// echo "<pre>" . print_r($_GET, true) . "</pre>";return true;
require_once("QueryPadrao.php");

function formataData($data){
    return implode('/', array_reverse(explode('-', $data)));

    echo 'DATA ATUAL: <br>' . $data;
    
    // // // CHAMA A FUNCAO JAVASCRIPT
    // // echo "<script>
    // //         alert(converteData('2024-08-28'));
    // //       </script>";
    // // return 1;

    // Para formato Brasileiro
    $dataArray = explode('-', $data);

    echo 'DATA ARRAY - 01: ' . json_encode($dataArray);
    echo 'DATA ARRAY - 02 - reverse: ' . json_encode(array_reverse($dataArray));

    
    $data_array_reverse = array_reverse($dataArray);

    $dataFinal = implode('/', $data_array_reverse);
    
    echo 'DATA FINAL: ' . $dataFinal;

    $dataNova = implode('/', array_reverse(explode('-', $data)));

    // E Passando do formato brasileiro para formato americano:
    // implode('-', array_reverse(explode('/', $data)));

    return $dataFinal;
}

function getNomePastaSistema(){
    return "sistemaescolar-orientacao-objeto";
}

function processaDados($pagina){
    if(isset($_POST["ACAO"])){
        $acao = $_POST["ACAO"];
        if($acao == "INCLUIR"){
            incluir_registro($pagina);
        } else if($acao == "ALTERAR"){        
            alterar_registro($pagina);
        }
    } else if(isset($_GET["ACAO"])){
        $acao = $_GET["ACAO"];
        if($acao == "EXCLUIR"){
            excluir_registro($pagina);        
        } else if($acao == "ALTERAR"){
            $codigoAlterar = $_GET["codigo"];            
            header('Location: ' . $pagina . '.php?ACAO=ALTERAR&codigo=' . $codigoAlterar);
        }
    } else {
        // Redireciona para a pagina de consulta
        header('Location: consulta_' . $pagina . '.php');
    }        
}

function getProximoCodigo($arDados, $acao){
    if($acao == "ALTERAR"){
        return $_POST["codigo"];
    }

    $ultimoCodigo = 0;
    foreach($arDados as $aDados){
        $codigoAtual = $aDados["codigo"];

        if($codigoAtual > $ultimoCodigo){
            $ultimoCodigo = $codigoAtual;
        }      
    }

    return $ultimoCodigo + 1;
}

// AÇÕES DE FORMULARIO
function excluir_registro($pagina){
    $codigoExcluir = $_GET["codigo"];

    $dados = @file_get_contents("../" . $pagina . "/" . $pagina . ".json");
    $arDados = json_decode($dados, true);

    $arDadosNovo = array();
    foreach($arDados as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoExcluir == $codigoAtual){
            continue;
        }

        $arDadosNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("../" . $pagina . "/" . $pagina . ".json", json_encode($arDadosNovo));

    // Redireciona para a pagina de consulta
    header('Location: consulta_' . $pagina . '.php');
}

function incluir_registro($pagina){
    $arDados = array();

    // Primeiro, verifica se existe dados no arquivo json
    // @ na frente do metodo, remove o warning
    $dados = @file_get_contents("../" . $pagina . "/" . $pagina . ".json");
    if($dados){
        // transforma os dados lidos em ARRAY, que estavam em JSON
        $arDados = json_decode($dados, true);
    }

    $aDadosAtual = getDadosFormulario($pagina, $arDados, $acao = "INCLUIR");
    
    // Pega os dados atuais do turma e armazena no array que foi lido
    $arDados[] = $aDadosAtual;

    // Gravar os dados no arquivo
    file_put_contents("../" . $pagina . "/" . $pagina . ".json", json_encode($arDados));

    // Redireciona para a pagina de consulta
    header('Location: consulta_' . $pagina . '.php');
}

function alterar_registro($pagina){

    $arDados = array();
    
    $dados = @file_get_contents("../" . $pagina . "/" . $pagina . ".json");
    if($dados){
        $arDados = json_decode($dados, true);
    }
        
    $arDadosNovo = array();
    $codigoAlterar = $_POST["codigo"];

    foreach($arDados as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoAlterar == $codigoAtual){
            $aDados = getDadosFormulario($pagina, $arDados, $acao = "ALTERAR");
        }

        $arDadosNovo[] = $aDados;
    }

    // Gravar os dados no arquivo
    file_put_contents("../" . $pagina . "/" . $pagina . ".json", json_encode($arDadosNovo));

    // Redireciona para a pagina de consulta
    header('Location: consulta_' . $pagina . '.php');
}

function getDadosFormulario($pagina, $arDados, $acao){
    $aDadosAtual = array();
    switch ($pagina){
        case "materia":
            $aDadosAtual["codigo"] = getProximoCodigo($arDados, $acao);
            $aDadosAtual["turma"] = $_POST["turma"];
            $aDadosAtual["nome"]  = $_POST["nome"];
            break;
        case "turma":
            $escola       = $_POST["escola"];
            $nome         = $_POST["nome"];
            $datainicio   = $_POST["datainicio"];
            $datafim      = $_POST["datafim"];
            $statuscurso  = $_POST["statuscurso"];
            $periodocurso = $_POST["periodocurso"];
            
            $aDadosAtual["nome"] = $nome;
            $aDadosAtual["codigo"] = getProximoCodigo($arDados, $acao);
            $aDadosAtual["escola"] = (int)$escola;
            $aDadosAtual["datainicio"] = $datainicio;
            $aDadosAtual["datafim"] = $datafim;
            $aDadosAtual["statuscurso"] = $statuscurso;
            $aDadosAtual["periodocurso"] = $periodocurso;
            
            break;
        case 'professor':
            $aDadosAtual["codigo"] = getProximoCodigo($arDados, $acao);
            $aDadosAtual["nome"] = $_POST["nome"];
            $aDadosAtual["email"] = $_POST["email"];
            $aDadosAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);        
            break;            
        case 'escola':
            $aDadosAtual["codigo"] = getProximoCodigo($arDados, $acao);
            
            $descricao = $_POST["descricao"];
            $cidade = $_POST["cidade"];
            
            list(
                $tipo_ensino_creche,
                $tipo_ensino_basico,
                $tipo_ensino_fundamental,
                $tipo_ensino_medio,
                $tipo_ensino_profissional,
                $tipo_ensino_tecnico,
                $tipo_ensino_superior) = getTipoEnsino();
                
                $aDadosAtual["descricao"] = $descricao;
                $aDadosAtual["cidade"] = $cidade;
                $aDadosAtual["tipo_ensino_creche"] = $tipo_ensino_creche;
                $aDadosAtual["tipo_ensino_basico"] = $tipo_ensino_basico;
                $aDadosAtual["tipo_ensino_fundamental"] = $tipo_ensino_fundamental;
                $aDadosAtual["tipo_ensino_medio"] = $tipo_ensino_medio;
                $aDadosAtual["tipo_ensino_profissional"] = $tipo_ensino_profissional;
                $aDadosAtual["tipo_ensino_tecnico"] = $tipo_ensino_tecnico;
                $aDadosAtual["tipo_ensino_superior"] = $tipo_ensino_superior;
            break;
        case 'aluno':
            $aDadosAtual["codigo"] = getProximoCodigo($arDados, $acao);
            $aDadosAtual["nome"] = $_POST["nome"];
            $aDadosAtual["email"] = $_POST["email"];
            $aDadosAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);
            break;
    }
                
    if(!count($aDadosAtual)){
        throw new Exception("Formulário da pagina:" . $pagina. " não programado!");
    }

    return $aDadosAtual;
}

// CADASTRO DE ESCOLA 
function getTipoEnsino(){
    $tipo_ensino_creche = 0;
    $tipo_ensino_basico = 0;
    $tipo_ensino_fundamental = 0;
    $tipo_ensino_medio = 0;
    $tipo_ensino_profissional = 0;
    $tipo_ensino_tecnico = 0;
    $tipo_ensino_superior = 0;
    
    if(isset($_POST['tipo_ensino_creche'])){
        $tipo_ensino_creche = 1;        
    }
    if(isset($_POST['tipo_ensino_basico'])){
        $tipo_ensino_basico = 1;        
    }
    if(isset($_POST['tipo_ensino_fundamental'])){
        $tipo_ensino_fundamental = 1;        
    }
    if(isset($_POST['tipo_ensino_medio'])){
        $tipo_ensino_medio = 1;        
    }
    if(isset($_POST['tipo_ensino_profissional'])){
        $tipo_ensino_profissional = 1;        
    }
    if(isset($_POST['tipo_ensino_tecnico'])){
        $tipo_ensino_tecnico = 1;        
    }
    if(isset($_POST['tipo_ensino_superior'])){
        $tipo_ensino_superior = 1;        
    }
    
    return array(
        $tipo_ensino_creche,
        $tipo_ensino_basico,
        $tipo_ensino_fundamental,
        $tipo_ensino_medio,
        $tipo_ensino_profissional,
        $tipo_ensino_tecnico,
        $tipo_ensino_superior
    );
}

// ACOES GENERICAS
function getAcaoExcluir($pagina, $codigo){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/" . getNomePastaSistema() . "/api/" . $pagina . "/cadastrar_" . $pagina . ".php?ACAO=EXCLUIR&codigo=" . $codigo . "'>Excluir</a>";
    return $sHTML;
}

function getAcaoAlterar($pagina, $codigo){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/" . getNomePastaSistema() . "/api/" . $pagina . "/cadastrar_" . $pagina . ".php?ACAO=ALTERAR&codigo=" . $codigo . "'>Alterar</a>";
    return $sHTML;
}

function getDescricaoPorCodigo($codigo, $pagina, $nomeColuna){    
    $arDadosTurmas = array();
    $dadosTurmas = @file_get_contents("../" . $pagina . "/" . $pagina . ".json");
    if($dadosTurmas){ 
        $arDadosTurmas = json_decode($dadosTurmas, true);
    }

    $nome = "Nome invalido!";
    foreach($arDadosTurmas as $aDados){
        if($aDados["codigo"] == $codigo){
            $nome = $aDados[$nomeColuna];
        }
    }

    return $nome;    
}

                
                