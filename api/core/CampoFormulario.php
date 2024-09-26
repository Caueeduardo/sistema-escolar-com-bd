<?php

class CampoFormulario {

    const CAMPO_TIPO_TEXTO = "text";
    const CAMPO_TIPO_SENHA = "password";
    const CAMPO_TIPO_SELECT = "select";
    const CAMPO_TIPO_CHECKBOX = "checkbox";

    const CAMPO_NUMERICO = "numeric";
    const CAMPO_TEXTO = "texto";

    /**
     * Retorna um novo campo de formulario, com base nos parametros passados
     * @param $nomeCampo
     * @param $tipoCampo
     * @param $tipoCampoBancoDados
     * @param bool $obrigatorio
     * @param string $valor
     * @param bool $quebraLinha
     * @param array $aListaOpcoes
     * @param array $descricaoCampo
     * @return array
     * @throws Exception
     */
    public static function adicionaCampo($nomeCampo, $tipoCampo, $tipoCampoBancoDados = CampoFormulario::CAMPO_TEXTO, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes = array(), $descricaoCampo = ""){
        if($tipoCampo == self::CAMPO_TIPO_SELECT && !count($aListaOpcoes)){
            throw new Exception("Não foi informada a lista de opções para o campo:<b>" . $nomeCampo . "</b>!");
        }

        return array(
            "campo" => $nomeCampo,
            "tipo" => $tipoCampo,
            "tipocampobancodados" => $tipoCampoBancoDados,
            "obrigatorio" => $obrigatorio,
            "valor" =>$valor,
            "quebralinha" =>$quebraLinha,
            "listaopcoes" =>$aListaOpcoes,
            "descricaocampo" =>$descricaoCampo
        );
    }
}