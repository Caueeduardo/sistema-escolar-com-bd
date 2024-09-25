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
            "nome",
            "datainicio",
            "datafim",
            "statuscurso",
            "periodocurso",
        );
    }
}

new ConsultaTurma();