<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoEscola extends ManutencaoPadrao {

    protected function getPagina(){
        return 'escola';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);

        $aListaOpcoes = $this->getListaOpcao($tabela = "cidade", $campoChave = "codigo", $campoDescricao = "descricao", $condicao = "");
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "cidade", $tipoCampo = CampoFormulario::CAMPO_TIPO_SELECT, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes);

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "descricao", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_creche"       , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_basico"       , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_fundamental"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_medio"        , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_profissional" , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_tecnico"      , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "tipo_ensino_superior"     , $tipoCampo = CampoFormulario::CAMPO_TIPO_CHECKBOX, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);

        return $aDadosColunas;
    }

}

new ManutencaoEscola();