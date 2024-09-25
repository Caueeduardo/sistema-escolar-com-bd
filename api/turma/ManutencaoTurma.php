<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoTurma extends ManutencaoPadrao {

    protected function getPagina(){
        return 'turma';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "nome", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);

        $aListaOpcoes = $this->getListaOpcao($tabela = "escola", $campoChave = "codigo", $campoDescricao = "descricao", $condicao = "");
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "escola", $tipoCampo = CampoFormulario::CAMPO_TIPO_SELECT, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes);
        
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "datainicio", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = false);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "datafim", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);

        $aListaOpcoes = array(
            array ("chave" => "ABERTO", "valor" => "ABERTO"),
            array ("chave" => "ANDAMENTO", "valor" => "ANDAMENTO"),
            array ("chave" => "CONCLUIDO", "valor" => "CONCLUIDO")
        );
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "statuscurso", $tipoCampo = CampoFormulario::CAMPO_TIPO_SELECT, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes);

        $aListaOpcoes = array(
            array ("chave" => "Matutino", "valor" => "Matutino"),
            array ("chave" => "Vespertino", "valor" => "Vespertino"),
            array ("chave" => "Noturno", "valor" => "Noturno")
        );
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "periodocurso", $tipoCampo = CampoFormulario::CAMPO_TIPO_SELECT, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes);

        return $aDadosColunas;
    }

    protected function getLarguraFormulario(){
        return 'style="width:80vw;"';
    }
}

new ManutencaoTurma();