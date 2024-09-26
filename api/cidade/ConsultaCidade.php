<?php

require_once("../core/ConsultaPadrao.php");
class ConsultaCidade extends ConsultaPadrao {

    protected function getTabela(){
        return 'cidade';
    }

    protected function getColunaOrdenacao(){
        return 'codigo';
    }

    protected function getColunas(){
        // Colunas
        return array(
            "Código",
            "Descrição"
        );
    }

    protected function getColunasBancoDados(){
        // Colunas na mesma ordem dos titulos
        return array(
            "codigo",
            "descricao"
        );
    }
}

new ConsultaCidade();