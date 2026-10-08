<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * List of country phone codes with flags and country names.
     */
    public static function getCountryCodes(): array
    {
        return [
            '+58' => ['flag' => '🇻🇪', 'name' => 'Venezuela', 'code' => '+58'],
            '+1'  => ['flag' => '🇺🇸', 'name' => 'EE. UU. / Canadá', 'code' => '+1'],
            '+34' => ['flag' => '🇪🇸', 'name' => 'España', 'code' => '+34'],
            '+57' => ['flag' => '🇨🇴', 'name' => 'Colombia', 'code' => '+57'],
            '+52' => ['flag' => '🇲🇽', 'name' => 'México', 'code' => '+52'],
            '+54' => ['flag' => '🇦🇷', 'name' => 'Argentina', 'code' => '+54'],
            '+56' => ['flag' => '🇨🇱', 'name' => 'Chile', 'code' => '+56'],
            '+51' => ['flag' => '🇵🇪', 'name' => 'Perú', 'code' => '+51'],
            '+593' => ['flag' => '🇪🇨', 'name' => 'Ecuador', 'code' => '+593'],
            '+591' => ['flag' => '🇧🇴', 'name' => 'Bolivia', 'code' => '+591'],
            '+598' => ['flag' => '🇺🇾', 'name' => 'Uruguay', 'code' => '+598'],
            '+595' => ['flag' => '🇵🇾', 'name' => 'Paraguay', 'code' => '+595'],
            '+502' => ['flag' => '🇬🇹', 'name' => 'Guatemala', 'code' => '+502'],
            '+503' => ['flag' => '🇸🇻', 'name' => 'El Salvador', 'code' => '+503'],
            '+504' => ['flag' => '🇭🇳', 'name' => 'Honduras', 'code' => '+504'],
            '+505' => ['flag' => '🇳🇮', 'name' => 'Nicaragua', 'code' => '+505'],
            '+506' => ['flag' => '🇨🇷', 'name' => 'Costa Rica', 'code' => '+506'],
            '+507' => ['flag' => '🇵🇦', 'name' => 'Panamá', 'code' => '+507'],
            '+1787' => ['flag' => '🇵🇷', 'name' => 'Puerto Rico', 'code' => '+1787'],
            '+1809' => ['flag' => '🇩🇴', 'name' => 'Rep. Dominicana', 'code' => '+1809'],
            '+53'  => ['flag' => '🇨🇺', 'name' => 'Cuba', 'code' => '+53'],
        ];
    }

    /**
     * Dictionary of area codes per country.
     */
    public static function getAreaCodes(): array
    {
        return [
            '+58' => [
                '0414' => '0414 (Movistar)',
                '0424' => '0424 (Movistar)',
                '0412' => '0412 (Digitel)',
                '0416' => '0416 (Movilnet)',
                '0426' => '0426 (Movilnet)',
                '414' => '414 (Movistar)',
                '424' => '424 (Movistar)',
                '412' => '412 (Digitel)',
                '416' => '416 (Movilnet)',
                '426' => '426 (Movilnet)',
                '0212' => '0212 (Caracas / La Guaira / Miranda)',
                '0241' => '0241 (Valencia / Carabobo)',
                '0243' => '0243 (Maracay / Aragua)',
                '0251' => '0251 (Barquisimeto / Lara)',
                '0261' => '0261 (Maracaibo / Zulia)',
                '0274' => '0274 (Mérida)',
                '0276' => '0276 (San Cristóbal / Táchira)',
                '0281' => '0281 (Barcelona / Anzoátegui)',
                '0286' => '0286 (Puerto Ordaz / Bolívar)',
                '0295' => '0295 (Porlamar / Nueva Esparta)',
            ],
        ];
    }
}
