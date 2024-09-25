<?php

class CampoFormulario {

    const CAMPO_TIPO_TEXTO = "text";
    const CAMPO_TIPO_SENHA = "password";
    const CAMPO_TIPO_SELECT = "select";

    /**
     * Retorna um novo campo de formulario, com base nos parametros passados
     * @param $nomeCampo
     * @param $tipoCampo
     * @param bool $obrigatorio
     * @param string $valor
     * @param bool $quebraLinha
     * @param array $aListaOpcoes
     * @return array
     * @throws Exception
     */
    public static function adicionaCampo($nomeCampo, $tipoCampo, $obrigatorio = false, $valor = "", $quebraLinha = true, $aListaOpcoes = array()){
        if($tipoCampo == self::CAMPO_TIPO_SELECT && !count($aListaOpcoes)){
            throw new Exception("Não foi informada a lista de opções para o campo:<b>" . $nomeCampo . "</b>!");
        }

        return array(
            "campo" => $nomeCampo,
            "tipo" => $tipoCampo,
            "obrigatorio" => $obrigatorio,
            "valor" =>$valor,
            "quebralinha" =>$quebraLinha,
            "listaopcoes" =>$aListaOpcoes
        );
    }
}