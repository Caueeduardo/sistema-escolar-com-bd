<?php
require_once("../core/Utils.php");

class CadastrarAluno extends ConsultaAlteracaoPadrao {

    public function __construct(){
        $this->processaDadosPagina("aluno");
    }
    
}