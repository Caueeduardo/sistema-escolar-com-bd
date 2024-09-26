<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoCidade extends ManutencaoPadrao {

    protected function getPagina(){
        return 'cidade';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "descricao"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);
        
        return $aDadosColunas;
    }

}

new ManutencaoCidade();