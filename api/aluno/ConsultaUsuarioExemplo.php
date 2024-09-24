<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaAluno extends ConsultaPadrao {

    protected function getTabela(){
        return 'usuario';
    }

    protected function getColunaOrdenacao(){
        return 'usucodigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Login",
            "Nome",
            "Senha"
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "usucodigo",
            "usulogin",
            "usunome",
            "ususenha",
        );
    }
}

new ConsultaAluno();