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

    protected function getDadosConsulta(){
        $aDados = parent::getDadosConsulta();

        $aDadosNew = array();
        foreach($aDados as $key => $aDadosAtual){
            $codigoTurma = $aDadosAtual["turma"];

            // retorna o nome da turma concatenado com o codigo
            $aDadosTurma = getQuery()->select("select nome from turma where codigo = " . $codigoTurma);

            $nomeConcatenado = $codigoTurma . " - " . $aDadosTurma["nome"];

            $aDadosAtual["turma"] = $nomeConcatenado;

            $aDadosNew[$key] = $aDadosAtual;
        }

        return $aDadosNew;
    }
}

new ConsultaMateria();