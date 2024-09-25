<?php

require_once ("../core/CampoFormulario.php");
class ManutencaoPadrao {

    public function __construct() {
        require_once("../core/header.php");

        $this->processaDados();

        require_once("../core/footer.php");
    }

    protected function getPagina(){
        return 'pagina';
    }

    protected function getTabela(){
        return $this->getPagina();
    }

    protected function getColunas(){
        return array();
    }

    protected function getSqlManutencao($codigo){
        return " select * from " . $this->getTabela() . " where codigo = $codigo";
    }

    public function getDadosCadastro($codigoAlterar, $aListaColunas){
        $sqlManutencao = $this->getSqlManutencao($codigoAlterar);

        $arDadosCadastro = getQuery()->selectAll($sqlManutencao);

        $encontrouRegistro = false;
        $aListaColunasComValor = array();
        foreach($arDadosCadastro as $aDados){
            $codigoAtual = $aDados["codigo"];
            if($codigoAlterar == $codigoAtual){
                $encontrouRegistro = true;
                foreach ($aListaColunas as $aColuna){

                    // echo '<br>campo:' .
                    // Passa valor para a coluna, pegando o retorno do banco de dados
                    $aColuna["valor"] = $aDados[$aColuna["campo"]];

                    $aListaColunasComValor[] = $aColuna;
                }
                // para a execução do loop
                break;
            }
        }

        return array($aListaColunasComValor, $encontrouRegistro);
    }

    protected function processaDadosExlusao($pagina){
        $codigoExcluir = $_GET["codigo"];

        getQuery()->executaQuery("delete from " . $this->getTabela() . " where codigo = " . $codigoExcluir);

        // Redireciona para a pagina de consulta
        header('Location: Consulta' . ucfirst($pagina) . '.php');
    }

    protected function processaDadosInclusao($pagina){
        $aColunas = $this->getColunas();
        $totalColunas = count($aColunas);

        $sqlInsert = "INSERT INTO " . $this->getTabela();

        $sqlInsert .= "(";
        $count = 1;
        foreach($aColunas as $aColuna){
            $sqlInsert .= $aColuna["campo"];

            if($count != $totalColunas){
                $sqlInsert .= ",";
            }

            $count++;
        }

        $sqlInsert .= ")";
        $sqlInsert .= " VALUES (";

        $arDados = $this->getDadosFormularioPadrao($pagina, $acao = "INCLUIR");

        $count = 1;
        foreach($aColunas as $aColuna){

            if($aColuna["campo"] == "codigo"){
                $sqlInsert .= (int)$arDados[$aColuna["campo"]];
            } else {
                 if ($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SELECT){
                     if(intval($arDados[$aColuna["campo"]]) > 0){
                         $sqlInsert .= $arDados[$aColuna["campo"]];
                     } else {
                        $sqlInsert .= "'" . $arDados[$aColuna["campo"]] . "'";
                     }
                 } else {
                     if ($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_TEXTO || $aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SENHA) {
                        $sqlInsert .= "'" . $arDados[$aColuna["campo"]] . "'";
                     } else {
                        $sqlInsert .= $arDados[$aColuna["campo"]];
                     }
                 }
            }

            if($count != $totalColunas){
                $sqlInsert .= ",";
            }

            $count++;
        }

        $sqlInsert .= ");";

        getQuery()->executaQuery($sqlInsert);

        // Redireciona para a pagina de consulta
        header('Location: Consulta' . ucfirst($pagina) . '.php');
    }

    protected function processaDadosAlteracao($pagina){
        $codigoAlterar = $_POST["codigo"];

        $sqlUpdate = "UPDATE " . $this->getTabela() . " SET ";

        $arDados = $this->getDadosFormularioPadrao($pagina, $acao = "ALTERAR");
        $aColunas = $this->getColunas();

        $totalColunas = count($aColunas);
        $count = 1;
        foreach($aColunas as $aColuna){
            if($aColuna["campo"] == "codigo"){
                $count++;
                continue;
            }

            if ($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SELECT){
                if(intval($arDados[$aColuna["campo"]]) > 0){
                    $sqlUpdate .= $aColuna["campo"] . " = " . $arDados[$aColuna["campo"]];
                } else {
                    $sqlUpdate .= $aColuna["campo"] . " = '" . $arDados[$aColuna["campo"]] . "'";
                }
            } else {
                if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_TEXTO || $aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SENHA){
                    $sqlUpdate .= $aColuna["campo"] . " = '" . $arDados[$aColuna["campo"]] . "'";
                } else {
                    $sqlUpdate .= $aColuna["campo"] . " = " . $arDados[$aColuna["campo"]];
                }
            }


            if($count != $totalColunas){
                $sqlUpdate .= ",";
            }

            $count++;
        }

        $sqlUpdate .= " WHERE codigo = " . $codigoAlterar;

        getQuery()->executaQuery($sqlUpdate);

        // Redireciona para a pagina de consulta
        header('Location: Consulta' . ucfirst($pagina) . '.php');
    }

    protected function processaDados(){
        $pagina = $this->getPagina();

        $codigo = "";
        $mensagemRegistroNaoEncontrado = "";

        $aListaColunas = $this->getColunas();
        $acaoFormulario = "INCLUIR";
        if(isset($_GET["ACAO"])){
            $acao = $_GET["ACAO"];
            if($acao == "ALTERAR"){
                $acaoFormulario = "CONFIRMAR_ALTERACAO";

                $codigo = $_GET["codigo"];
                list($aListaColunas, $encontrou) = $this->getDadosCadastro($codigo, $aListaColunas);

                if(!$encontrou){
                    $mensagemRegistroNaoEncontrado = "Não foi encontrado nenhum aluno para o codigo informado!Código: " . $codigo;
                }
            } else if($acao == "EXCLUIR"){
                $this->processaDadosExlusao($pagina);
            } else if($acao == "CONFIRMAR_INCLUSAO"){
                $acaoFormulario = "CONFIRMAR_INCLUSAO";
            }
        } else if(isset($_POST["ACAO"])) {
            $acao = $_POST["ACAO"];
            if($acao == "CONFIRMAR_INCLUSAO"){
                $this->processaDadosInclusao($pagina);
            } else if($acao == "CONFIRMAR_ALTERACAO"){
                $this->processaDadosAlteracao($pagina);
            }
        } else {
            header('Location: Consulta' . ucfirst($pagina) . '.php');
        }

        $sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

        // FORMULARIO DE CADASTRO
        $sHTML .= '<h2 style="text-align:center;">Formulário de ' . ucfirst($pagina) . '</h2>
        <h3>' . $mensagemRegistroNaoEncontrado . '</h3>
        <form action="Manutencao' . ucfirst($pagina) . '.php" method="POST">
            <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">            
            <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>';

        foreach ($aListaColunas as $aColuna){
            $obrigatorio = $aColuna["obrigatorio"] ? "required" : "";
            $quebraLinha = $aColuna["quebralinha"] ? "<br>" : "";

            if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SELECT){
                $aListaOption = $aColuna["listaopcoes"];
                $sHTML .= '<label for="' . $aColuna["campo"] . '">' . ucfirst($aColuna["campo"]) . ':</label>
                           <select id="' . $aColuna["campo"] . '" name="' . $aColuna["campo"] . '"  ' . $obrigatorio . '>';

                foreach ($aListaOption as $aOption) {
                    $selected = "";
                    if($aColuna["valor"] != ""){
                        if($aColuna["valor"] == $aOption["chave"]){
                            $selected = " selected ";
                        }
                    }

                    $sHTML .= '<option value="' . $aOption["chave"] . '" ' . $selected . '>' . $aOption["valor"] . '</option>';
                }

                $sHTML .= '</select>';
                $sHTML .= '<br>';
            } else {
                $sHTML .= '<label for="' . $aColuna["campo"] . '">' . ucfirst($aColuna["campo"]) . ':</label>
                           <input type="' . $aColuna["tipo"] . '" id="' . $aColuna["campo"] . '" name="' . $aColuna["campo"] . '"  ' . $obrigatorio . ' value="' . $aColuna["valor"] . '">';
            }

            $sHTML .= $quebraLinha;
        }

        $sHTML .= '<br><input type="submit" value="Enviar">';
        $sHTML .= '</form>';

        // CONSULTA DE DADOS
        $sHTML .= '</div>';

        echo $sHTML;
    }

    protected function getProximoCodigo($acao){
        if($acao == "ALTERAR"){
            return $_POST["codigo"];
        }

        $tabela = $this->getTabela();

        $sequenceName = $tabela . "_id_seq";
        $sqlProximoCodigo = "select nextval('$sequenceName') as codigo";

        $arDadosCadastro = getQuery()->select($sqlProximoCodigo);

        $proximoCodigo = $arDadosCadastro["codigo"];

        return $proximoCodigo;
    }

    protected function getDadosFormularioPadrao($acao){
        $aDadosAtual = array();
        $aListaColunas = $this->getColunas();
        foreach ($aListaColunas as $aColuna){
            if($aColuna["campo"] == "codigo"){
                $aDadosAtual[$aColuna["campo"]] = $this->getProximoCodigo($acao);
            } else {
                if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SENHA){
                    $aDadosAtual[$aColuna["campo"]] = password_hash($_POST[$aColuna["campo"]], PASSWORD_DEFAULT);
                } else {
                    $aDadosAtual[$aColuna["campo"]] = $_POST[$aColuna["campo"]];
                }
            }
        }

        return $aDadosAtual;
    }

    private function getDadosFormularioOld($pagina, $acao){

        return $this->getDadosFormularioPadrao($pagina, $acao);

        $aDadosAtual = array();
        switch ($pagina){
            case "materia":
                $aDadosAtual["codigo"] = $this->getProximoCodigo($acao);
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
                $aDadosAtual["codigo"] = $this->getProximoCodigo($acao);
                $aDadosAtual["escola"] = (int)$escola;
                $aDadosAtual["datainicio"] = $datainicio;
                $aDadosAtual["datafim"] = $datafim;
                $aDadosAtual["statuscurso"] = $statuscurso;
                $aDadosAtual["periodocurso"] = $periodocurso;

                break;
            case 'professor':
                $aDadosAtual["codigo"] = $this->getProximoCodigo($acao);
                $aDadosAtual["nome"] = $_POST["nome"];
                $aDadosAtual["email"] = $_POST["email"];
                $aDadosAtual["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);
                break;
            case 'escola':
                $aDadosAtual["codigo"] = $this->getProximoCodigo($acao);

                $descricao = $_POST["descricao"];
                $cidade = $_POST["cidade"];

                list(
                    $tipo_ensino_creche,
                    $tipo_ensino_basico,
                    $tipo_ensino_fundamental,
                    $tipo_ensino_medio,
                    $tipo_ensino_profissional,
                    $tipo_ensino_tecnico,
                    $tipo_ensino_superior) = $this->getTipoEnsino();

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
                $aDadosAtual["codigo"] = $this->getProximoCodigo($acao);
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

    protected function getTipoEnsino(){
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

    protected function getListaOpcao($tabela, $campoChave, $campoDescricao, $condicao = ""){
        $aListaOpcoes = array();
        $sql = "select $campoChave , $campoDescricao from $tabela $condicao order by $campoChave";
        $arDadosOpcoes = getQuery()->selectAll($sql);

        foreach($arDadosOpcoes as $aDados){
            $aListaOpcoes[$aDados[$campoChave]] = array("chave" => $aDados[$campoChave], "valor"=> $aDados[$campoDescricao]);
        }

        return $aListaOpcoes;
    }
}                
                