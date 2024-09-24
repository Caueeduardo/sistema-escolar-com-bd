<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaEscola extends ConsultaPadrao {

    protected function getTabela(){
        return 'escola';
    }

    protected function getColunaOrdenacao(){
        return 'codigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Descrição",
            "Cidade",
            "Creche",
            "Ensino Básico",
            "Ensino Fundamental",
            "Ensino Médio",
            "Ensino Profissionalizante",
            "Ensino Técnico",
            "Ensino Superior",
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "codigo",
            "descricao",
            "cidade",
            "tipo_ensino_creche",
            "tipo_ensino_basico",
            "tipo_ensino_fundamental",
            "tipo_ensino_medio",
            "tipo_ensino_profissional",
            "tipo_ensino_tecnico",
            "tipo_ensino_superior"
        );
    }

    protected function getDadosConsulta(){
        $aDados = parent::getDadosConsulta();

        $aDadosNew = array();
        foreach($aDados as $key => $aDadosAtual){
            $codigoCidade = $aDadosAtual["cidade"];

            // retorna o nome do sistema concatenado com o codigo
            $aDadosCidade = getQuery()->select("select descricao from cidade where codigo = " . $codigoCidade);

            $nomeConcatenado = $codigoCidade . " - " . $aDadosCidade["descricao"];

            $aDadosAtual["cidade"] = $nomeConcatenado;

            $aDadosNew[$key] = $aDadosAtual;
        }

        return $aDadosNew;
    }
}

new ConsultaEscola();