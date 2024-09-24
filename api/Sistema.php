<?php 

class Sistema {

    public function __construct(){
        $this->processaDados();
    }

    protected function processaDados(){
        require_once("core/header.php");

        require_once("core/sistema.php");
        
        require_once("core/footer.php");
    }
}

new Sistema();