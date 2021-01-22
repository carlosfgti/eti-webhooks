<?php

/**
 * Helpers
 */

 if (!function_exists('generatePassword')) {
    function generatePassword($qty = 8) {
        $alfaMaiusculo = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $alfaMinusculo = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $numeros = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numeros .= 1234567890;
        $caractersEspeciais = str_shuffle('!@#$%*-');

        $caracters = $alfaMaiusculo.$alfaMinusculo.$numeros.$caractersEspeciais;

        $password = substr(str_shuffle($caracters), 0, $qty);

        return $password;
    }
 }
