<?php

require_once("../core/header.php");
require_once("../core/ManutencaoPadrao.php");
class ManutencaoUsuario extends ManutencaoPadrao {

    protected function getPagina(){
        return 'usuario';
    }

    protected function getColunaChave(){
        return 'usucodigo';
    }
     
    protected function getColunas() {
        $aDadosColunas = array();

        $aDadosColunas[] = CampoFormulario::adicionaCampo(
            $nomeCampo = "usucodigo",
            $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, 
            $tipoCampoBancodados = CampoFormulario::CAMPO_NUMERICO, 
            $obrigatorio = false, 
            $valor = "", $quebraLinha = true, 
            $aListaOpcoes = array(), 
            $descricaoCampo = "Código"
        );
        
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "usulogin"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes = array(), $descricaoCampo = "Login");
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "usunome"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes = array(), $descricaoCampo = "Nome");
        $aDadosColunas[] = CampoFormulario::adicionaCampo($nomeCampo = "ususenha"  , $tipoCampo = CampoFormulario::CAMPO_TIPO_TEXTO, $tipoCampoBancodados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes = array(), $descricaoCampo = "Senha");
        
        return $aDadosColunas;
    }

}

new ManutencaoUsuario();