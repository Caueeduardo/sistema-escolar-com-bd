<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaAluno extends ConsultaPadrao {

    protected function getTabela(){
        return 'aluno';
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

new ConsultaAluno();