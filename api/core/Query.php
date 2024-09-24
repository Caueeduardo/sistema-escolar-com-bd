<?php

require_once ("ConexaoDB.php");
class Query {

    private $conexao;

    public function __construct() {
        $this->conexao = ConexaoDB::getInstance();
    }

    public function select($sSql) {
        $rSql = $this->query($sSql);
        if ($oLinhaAtual = pg_fetch_assoc($rSql)) {
            return $oLinhaAtual;
        }
        return false;
    }

    public function selectAll($sSql) {
        $rSql = $this->query($sSql);
        $aRetorno = Array();
        while ($oLinhaAtual = pg_fetch_assoc($rSql)) {
            $aRetorno[] = $oLinhaAtual;
        }
        return $aRetorno;
    }

    private function query($sSql) {
        $rRetorno = @pg_query($this->conexao, $sSql);
        if ($rRetorno !== false) {
            return $rRetorno;
        }
        
        $mensagem = "SQL: $sSql <br>Erros:" . pg_last_error($this->conexao);

        $mensagem_atual = 'Erro ao executar comando SQL.' . $mensagem;

        echo ('<p style="color:red; font-size:25px">' . $mensagem_atual . '</p>');

        throw new Exception($mensagem_atual);
    }

    public function executaQuery($sSql){
        return $this->query($sSql);
    }

}