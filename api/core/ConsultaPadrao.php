<?php 
require_once("Utils.php");
class ConsultaPadrao {

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
        
        $colunas .= "<th colspan='2' width='200'>Ações</th>";

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
                <body>
                    <h1>Consulta de ' . $this->getTitulo() . '</h1>
                    <a href="Manutencao' . ucfirst($this->getTabela()) . '.php?ACAO=CONFIRMAR_INCLUSAO"><button class="button" type="button">Incluir<button></a>
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

            $codigo = $aDados[$this->getColunaChave()];
            
            $consulta .= $this->getAcoes($this->getTabela(), $codigo);

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

    protected function getColunaChave(){
        return 'codigo';
    }

    // acoes da consulta
    protected function getAcaoExcluir($pagina, $codigo){
        $sHTML = "<a id='acaoExcluir' href='http://localhost/" . getNomePastaSistema() . "/api/" . $pagina . "/Manutencao" . ucfirst($pagina) . ".php?ACAO=EXCLUIR&codigo=" . $codigo . "'>Excluir</a>";
        return $sHTML;
    }

    protected function getAcaoAlterar($pagina, $codigo){
        $sHTML = "<a id='acaoAlterar' href='http://localhost/" . getNomePastaSistema() . "/api/" . $pagina . "/Manutencao" . ucfirst($pagina) . ".php?ACAO=ALTERAR&codigo=" . $codigo . "'>Alterar</a>";
        return $sHTML;
    }

    protected function getAcoes($pagina, $codigo){
        return
            '<td>' . $this->getAcaoExcluir($pagina, $codigo). '</td>' .
            '<td>' . $this->getAcaoAlterar($pagina, $codigo) . '</td>';
    }
}