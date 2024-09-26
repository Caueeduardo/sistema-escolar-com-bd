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
        return " select * from " . $this->getTabela() . " where " . $this->getColunaChave() . " = $codigo";
    }

    public function getDadosCadastro($codigoAlterar, $aListaColunas){
        // sql ALTERACAO = SELECT * FROM MATERIA WHERE CODIGO = 1
        $sqlManutencao = $this->getSqlManutencao($codigoAlterar);

        $arDadosCadastro = getQuery()->selectAll($sqlManutencao);

        $encontrouRegistro = false;
        $aListaColunasComValor = array();
        foreach($arDadosCadastro as $aDados){
            $codigoAtual = $aDados[$this->getColunaChave()];
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

        getQuery()->executaQuery(sSql: "delete from " . $this->getTabela() . " where " . $this->getColunaChave() . " = " . $codigoExcluir);

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

        $arDados = $this->getDadosFormularioPadrao($acao = "INCLUIR");

        $count = 1;
        foreach($aColunas as $aColuna){

            echo '<br>Campo:' . $aColuna["campo"] . ' - tipo:' . $aColuna["tipocampobancodados"];

            if ($aColuna["tipocampobancodados"] == CampoFormulario::CAMPO_NUMERICO){
                $sqlInsert .= (int)$arDados[$aColuna["campo"]];
            } else if ($aColuna["tipocampobancodados"] == CampoFormulario::CAMPO_TEXTO){
                $sqlInsert .= "'" . $arDados[$aColuna["campo"]] . "'";
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
        $codigoAlterar = $_POST[$this->getColunaChave()];

        $sqlUpdate = "UPDATE " . $this->getTabela() . " SET ";

        $arDados = $this->getDadosFormularioPadrao($acao = "ALTERAR");

        $aColunas = $this->getColunas();

        $totalColunas = count($aColunas);
        $count = 1;
        foreach($aColunas as $aColuna){
            if ($aColuna["tipocampobancodados"] == CampoFormulario::CAMPO_NUMERICO){
                $sqlUpdate .= $aColuna["campo"] . " = " . intval($arDados[$aColuna["campo"]]);
            } else if ($aColuna["tipocampobancodados"] == CampoFormulario::CAMPO_TEXTO){
                $sqlUpdate .= $aColuna["campo"] . " = '" . $arDados[$aColuna["campo"]] . "'";
            }

            if($count != $totalColunas){
                $sqlUpdate .= ",";
            }

            $count++;
        }

        $sqlUpdate .= " WHERE " . $this->getColunaChave() . " = " . $codigoAlterar;

        getQuery()->executaQuery($sqlUpdate);

        // Redireciona para a pagina de consulta
        header('Location: Consulta' . ucfirst($pagina) . '.php');
    }

    protected function getColunaChave(){
        return "codigo";
    }

    protected function getLarguraFormulario(){
        return "";
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

                $codigo = $_GET[$this->getColunaChave()];
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

        // $sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';
        $sHTML = '<link rel="stylesheet" href="../css/formulario.css">';
        $sHTML .= '<div>';
        // $sHTML = '';

        $larguraFormulario = $this->getLarguraFormulario();

        // FORMULARIO DE CADASTRO
        $sHTML .= '<h2 style="text-align:center;">Formulário de ' . ucfirst($pagina) . '</h2>
        <h3>' . $mensagemRegistroNaoEncontrado . '</h3>
        <form ' . $larguraFormulario . ' action="Manutencao' . ucfirst($pagina) . '.php" method="POST">
            <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">            
            <input type="hidden" id="' . $this->getColunaChave() . '" name="' . $this->getColunaChave() . '" value="' . $codigo . '" required>';

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
                if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_CHECKBOX){
                    $sHTML .= '<div style="display: flex;">';
                    $sHTML .= '<label class="tgl-btn" for="' . $aColuna["campo"] . '">' . ucfirst($aColuna["campo"]) . ':</label>';
                    $sHTML .= '<div class="checkbox-wrapper-64">
                                        <label class="switch">
                                            <input type="' . $aColuna["tipo"] . '" id="' . $aColuna["campo"] . '" name="' . $aColuna["campo"] . '"  ' . $obrigatorio . ' value="' . $aColuna["valor"] . '" >
                                            <span class="slider"></span>
                                        </label>
                                    </div>';
                    $sHTML .= '</div>';
                } else {
                    $descricaoCampo = ucfirst($aColuna["campo"]);
                    if($aColuna["descricaocampo"] != ""){
                        $descricaoCampo = $aColuna["descricaocampo"];
                    }

                    $sHTML .= '<label for="' . $aColuna["campo"] . '">' .  $descricaoCampo . ':</label>
                               <input type="' . $aColuna["tipo"] . '" id="' . $aColuna["campo"] . '" name="' . $aColuna["campo"] . '"  ' . $obrigatorio . ' value="' . $aColuna["valor"] . '">';
                }
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
            return $_POST[$this->getColunaChave()];
        }

        $tabela = $this->getTabela();

        $sequenceName = $tabela . "_id_seq";
        $sqlProximoCodigo = "select nextval('$sequenceName') as codigo";

        $arDadosCadastro = getQuery()->select($sqlProximoCodigo);

        $proximoCodigo = $arDadosCadastro["codigo"];

        return $proximoCodigo;
    }

    protected function getDadosFormularioPadrao($acao){

        // echo '<pre>' . print_r($_POST, true).'</pre>'; return true;

        $aDadosAtual = array();
        $aListaColunas = $this->getColunas();
        foreach ($aListaColunas as $aColuna){
            if($aColuna["campo"] == $this->getColunaChave()){
                $aDadosAtual[$aColuna["campo"]] = $this->getProximoCodigo($acao);
            } else {
                if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_SENHA){
                    $aDadosAtual[$aColuna["campo"]] = password_hash($_POST[$aColuna["campo"]], PASSWORD_DEFAULT);
                } else {
                    if($aColuna["tipo"] == CampoFormulario::CAMPO_TIPO_CHECKBOX){
                        $valor = isset($_POST[$aColuna["campo"]]) ? 1 : 0;
                        $aDadosAtual[$aColuna["campo"]] = $valor;
                    } else {
                        $aDadosAtual[$aColuna["campo"]] = $_POST[$aColuna["campo"]];
                    }
                }
            }
        }

        return $aDadosAtual;
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
                