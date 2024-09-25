<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoAluno extends ManutencaoPadrao {

    protected function getPagina(){
        return 'aluno';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "nome", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "email", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "senha", $tipoCampo = CampoFormulario::CAMPO_TIPO_SENHA);

        return $aDadosColunas;
    }

}

new ManutencaoAluno();