<?php 

static $Query;

function getQuery() {
    if (!isset($Query)) {
        require_once("Query.php");
        $Query = new Query();
    }
    return $Query;
}
