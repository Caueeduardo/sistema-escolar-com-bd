<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaTurma extends ConsultaPadrao {

    protected function getTabela(){
        return 'turma';
    }

    protected function getColunaOrdenacao(){
        return 'codigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Escola",
            "Nome",
            "Data Início",
            "Data Fim",
            "Status Curso",
            "Período Curso"
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "codigo",
            "escola",
            "nome",
            "datainicio",
            "datafim",
            "statuscurso",
            "periodocurso",
        );
    }

    protected function getDadosConsulta(){
        $aDados = parent::getDadosConsulta();

        $aDadosNew = array();
        foreach($aDados as $key => $aDadosAtual){
            $codigoEscola = $aDadosAtual["escola"];

            // retorna o nome da turma concatenado com o codigo
            $aDadosEscola = getQuery()->select("select descricao from escola where codigo = " . $codigoEscola);

            $nomeConcatenado = $codigoEscola . " - " . $aDadosEscola["descricao"];

            $aDadosAtual["escola"] = $nomeConcatenado;

            $aDadosNew[$key] = $aDadosAtual;
        }

        return $aDadosNew;
    }
}

new ConsultaTurma();