<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaMateria extends ConsultaPadrao {

    protected function getTabela(){
        return 'materia';
    }

    protected function getColunaOrdenacao(){
        return 'codigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Turma",
            "Nome"
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "codigo",
            "turma",
            "nome"
        );
    }
}

new ConsultaMateria();