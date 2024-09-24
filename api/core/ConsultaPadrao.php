<?php 
require_once("Utils.php");
class ConsultaPadrao {

    public function __construct(){
        $this->processaDados();
    }

    protected function processaDados(){
        $cabecalho = $this->getCabecalho();
        
        $aListaColunas = $this->getColunas();

        $colunas = "";
        foreach($aListaColunas as $coluna){
            $colunas .= "<th>" . $coluna . "</th>";
        }

        $linhas = $this->getLinhas();

        echo $cabecalho . $colunas . $linhas;
    }

    protected function getTitulo(){
        // ucfirst, coloca a primeira em maiusculo
        return ucfirst($this->getTabela());
    }

    protected function getCabecalho(){
        return '<!DOCTYPE html>
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Consulta de ' . $this->getTitulo() . '</title>
                </head>
                <style>
                    h1 {
                        text-align:center;
                    }
                    body {
                        display:flex;
                        width:98vw;
                        justify-content:center;
                        align-itens:center;
                        flex-direction:column;
                        margin-top:40px;
                    }
                </style>
                <body>
                    <h1>Consulta de ' . $this->getTitulo() . '</h1>
                    <table border="1">
                        <thead>';
    }

    protected function getColunas(){
        // Colunas
        return array();
    }

    protected function getTabela(){
        return 'TABELA DA CONSULTA';
    }
    
    protected function getSqlConsulta(){
        $sqlConsulta = " select * from " . $this->getTabela() . " order by " . $this->getColunaOrdenacao();
        return $sqlConsulta;
    }

    protected function getColunaOrdenacao(){
        return 'COLUNA DA ORDENACAO';
    }
    
    protected function getColunasBancoDados(){
        // Colunas
        return array();
    }

    protected function getDadosConsulta(){
        // Pegar os dados do banco de dados 
        $sqlConsulta = $this->getSqlConsulta();
        
        $aListaDadosConsulta = getQuery()->selectAll($sqlConsulta);

        return $aListaDadosConsulta;
    }

    protected function getLinhas(){
        $fimCabecalho = '</thead>';
        $inicioLinhas = '<tbody>';
        $consulta = $fimCabecalho . $inicioLinhas;

        // Pegar os dados do banco de dados 
        $aListaDadosConsulta = $this->getDadosConsulta();

        foreach($aListaDadosConsulta as $aDados){
            // INICIA A LINHA
            $consulta .= '<tr>';

            // COLUNAS
            $aColunas = $this->getColunasBancoDados();
            foreach($aColunas as $coluna){
                $consulta .= '   <td>' . $aDados[$coluna] . '</td>';
            }

            // FECHA A LINHA
            $consulta .= '</tr>';
        }

        $consulta .= '            
                </tbody>
            </table>
        </body>
        </html>';

        return $consulta;
    }
}