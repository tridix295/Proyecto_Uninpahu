<?php
namespace Helpers;

class hash{

    /**
     * Genera un hash para una cadena de texto determinada.
     * @param string $pass Cadena a hashear.
     * @return string hash
    */
    public static function generatePasswordHash(string $pass){
        return self::buildHash($pass);
    }

    /**
     * Revisa la valides de un hash para una cadena de texto determinada.
     * @param string $pass Cadena a evaluar.
     * @param string $hash
     * @return bool
    */
    public static function verifyPasswordHash($pass,$hash):bool{
        return self::make($pass,$hash);
    }

    /**
     * Genera un hash para una cadena de texto determinada con el algoritmo bcrypt.
     * @param string $pass Cadena a hashear.
     * @return string hash
    */
    private static function buildHash(string $pass){
        $pass = $pass . pass_secret;
        return password_hash($pass,PASSWORD_DEFAULT);
    }

    /**
     * Valida la valides de un hash para una cadena de texto determinada.
     * @param string $pass Cadena a evaluar.
     * @param string $hash
     * @return bool
    */
    private static function make($pass,$hash){
        $pass .=  pass_secret;
        return password_verify($pass,$hash);
    }
}

?>