<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoProfessor extends ManutencaoPadrao {

    protected function getPagina(){
        return 'professor';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "nome"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "email" , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "senha" , $tipoCampo = CampoFormulario::CAMPO_TIPO_SENHA, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO);

        return $aDadosColunas;
    }

}

new ManutencaoProfessor();