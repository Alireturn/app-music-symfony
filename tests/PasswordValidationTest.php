<?php

use PHPUnit\Framework\TestCase;


class PasswordValidation
{
    public function validatePassword(string $password): bool
    {
        $pattern = '/^(?=.[0-9])(?=.[a-z])(?=.[A-Z])(?=.\W)(?!.* ).{8,16}$/';

        return preg_match($pattern, $password) === 1;
    }
}


class PasswordValidationTest extends TestCase
{
    public function testValidatePassword()
    {
        // Créez une instance de la classe PasswordValidation
        $validator = new PasswordValidation();

        // Valider un mot de passe valide
        $validPassword = 'Simplon38/!';
        $isValid = $validator->validatePassword($validPassword);
        $this->assertFalse($isValid);

        // Valider un mot de passe invalide
        $invalidPassword = 'weakpassword';
        $isValid = $validator->validatePassword($invalidPassword);
        $this->assertFalse($isValid);
    }
}