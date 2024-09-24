<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaProfessor extends ConsultaPadrao {

    protected function getTabela(){
        return 'professor';
    }

    protected function getColunaOrdenacao(){
        return 'codigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Nome",
            "E-mail",
            "Senha"
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "codigo",
            "nome",
            "email",
            "senha",
        );
    }
}

new ConsultaProfessor();