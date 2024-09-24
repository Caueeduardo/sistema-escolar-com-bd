<?php 
require_once("Utils.php");
class ConsultaPadraoCss {

    public function __construct(){
        require_once("../core/header.php");
        
        $this->processaDados();

        require_once("../core/footer.php");
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
        return '<h1>Consulta de ' . $this->getTitulo() . '</h1>
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
            </table>';

        return $consulta;
    }
}