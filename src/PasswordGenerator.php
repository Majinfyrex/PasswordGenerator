<?php

namespace Zakar\PasswordGenerator;

class PasswordGenerator
{
    private static $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private static $lower = 'abcdefghijklmnopqrstuvwxyz';
    private static $numbers = '0123456789';
    private static $special = '!@#$%^&*()';

    /**
     * Génère un mot de passe aléatoire sécurisé.
     *
     * @param int $length La longueur souhaitée du mot de passe.
     * @param array $characterTypes Les types de caractères à inclure (ex : ['upper', 'lower']).
     * @return string Le mot de passe généré.
     * @throws InvalidArgumentException Si la longueur est inférieure à 4 ou aucun type de caractère n'est sélectionné.
     */
    public static final function generatePassword(int $length, array $characterTypes): string
    {
        if ($length < 4) {
            throw new \InvalidArgumentException("La longueur du mot de passe doit être d'au moins 4 caractères.");
        }

        // Construction de la chaîne de caractères en fonction des types sélectionnés
        $allCharacters = '';
        $password = [];

        if (in_array('upper', $characterTypes)) {
            $allCharacters .= self::$upper;
        }
        if (in_array('lower', $characterTypes)) {
            $allCharacters .= self::$lower;
        }
        if (in_array('numbers', $characterTypes)) {
            $allCharacters .= self::$numbers;
        }
        if (in_array('special', $characterTypes)) {
            $allCharacters .= self::$special;
        }

        // Si aucun type de caractère n'est sélectionné, renvoyer une exception personalisée
        if (empty($allCharacters)) {
            throw new \InvalidArgumentException("Vous devez sélectionner au moins un type de caractère.");
        }

        // Compléter le mot de passe avec des caractères aléatoires jusqu'à atteindre la longueur souhaitée
        for ($i = 0; $i < $length; $i++) {
            $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Mélanger les caractères du mot de passe pour plus de sécurité
        shuffle($password);

        // Convertir le tableau en une chaîne de caractères et retourner le mot de passe généré
        return implode('', $password);
    }

    public static function isStrongPassword(string $password): bool
    {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[!@#$%^&*()]/', $password);
    }
}
