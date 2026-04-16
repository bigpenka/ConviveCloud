<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRut implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Limpiar el RUT (quitar puntos, guiones y dejar en mayúscula la K)
        $rutLimpio = preg_replace('/[^0-9Kk]/', '', strtoupper($value));

        // 2. Validar largo mínimo
        if (strlen($rutLimpio) < 8) {
            $fail('El formato del RUT es incorrecto.');
            return;
        }

        // 3. Separar número y dígito verificador
        $numero = substr($rutLimpio, 0, -1);
        $dv_ingresado = substr($rutLimpio, -1);

        // 4. Algoritmo Módulo 11
        $suma = 0;
        $factor = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $factor * $numero[$i];
            $factor = $factor == 7 ? 2 : $factor + 1;
        }

        $dv_esperado = 11 - ($suma % 11);

        if ($dv_esperado == 11) {
            $dv_calculado = '0';
        } elseif ($dv_esperado == 10) {
            $dv_calculado = 'K';
        } else {
            $dv_calculado = (string) $dv_esperado;
        }

        // 5. Comprobar si coincide
        if ($dv_calculado !== $dv_ingresado) {
            $fail('El RUT ingresado no es válido (Dígito verificador incorrecto).');
        }
    }
}