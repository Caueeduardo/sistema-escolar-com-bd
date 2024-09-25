<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoMateria extends ManutencaoPadrao {

    protected function getPagina(){
        return 'materia';
    }

    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "codigo", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO);
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "nome", $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO);

        $aListaOpcoes = $this->getListaOpcao($tabela = "turma", $campoChave = "codigo", $campoDescricao = "nome", $condicao = "");
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "turma", $tipoCampo = CampoFormulario::CAMPO_TIPO_SELECT, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes);

        return $aDadosColunas;
    }

}

new ManutencaoMateria();