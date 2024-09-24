<?php

class ConexaoDB {

    const HOST = 'aws-0-sa-east-1.pooler.supabase.com';
    const PORT = '5432';
    const DBNAME = 'postgres';
    const USER = 'postgres.vtglfccczgitidfkllmq';
    const PASS = 'YLySVnSNQpOFjC2w';

    private static $conexao = null;

    public static function getInstance() {
        if (is_null(self::$conexao)) {
            self::conecta();
        }
        return self::$conexao;
    }

    public static function conecta() {
        if (is_null(self::$conexao)) {
            self::$conexao = pg_connect('host=' . self::HOST . ' port=' . self::PORT . ' dbname=' . self::DBNAME . ' user=' . self::USER . ' password=' . self::PASS);
            if (self::$conexao === false) {
                echo ('<p style="color:red; font-size:25px">Erro ao comunicar com banco de dados!</p>');
                
                throw new Exception('Erro ao comunicar com banco de dados!</p>');
            }
        }
        return self::$conexao;
    }

    public static function desconecta() {
        $bFechou = true;
        if (!is_null(self::$conexao)) {
            $bFechou = pg_close(self::$conexao);
            self::$conexao = null;
        }
        return $bFechou;
    }

    public function __destruct() {
        self::desconecta();
    }

}