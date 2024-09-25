<?php

require_once("../core/ConsultaPadraoAlteracao.php");
class ConsultaAluno extends ConsultaPadraoAlteracao {

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