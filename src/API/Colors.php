<?php

namespace ebitkov\TodoistSDK\API;

class Colors
{
    public static $colors = [
        30 => ['name' => 'berry_red', 'hex' => '#b8256f'],
        31 => ['name' => 'red', 'hex' => '#db4035'],
        32 => ['name' => 'orange', 'hex' => '#ff9933'],
        33 => ['name' => 'yellow', 'hex' => '#fad000'],
        34 => ['name' => 'olive_green', 'hex' => '#afb83b'],
        35 => ['name' => 'lime_green', 'hex' => '#7ecc49'],
        36 => ['name' => 'green', 'hex' => '#299438'],
        37 => ['name' => 'mint_green', 'hex' => '#6accbc'],
        38 => ['name' => 'teal', 'hex' => '#158fad'],
        39 => ['name' => 'sky_blue', 'hex' => '#14aaf5'],
        40 => ['name' => 'light_blue', 'hex' => '#96c3eb'],
        41 => ['name' => 'blue', 'hex' => '#4073ff'],
        42 => ['name' => 'grape', 'hex' => '#884dff'],
        43 => ['name' => 'violet', 'hex' => '#af38eb'],
        44 => ['name' => 'lavender', 'hex' => '#eb96eb'],
        45 => ['name' => 'magenta', 'hex' => '#e05194'],
        46 => ['name' => 'salmon', 'hex' => '#ff8d85'],
        47 => ['name' => 'charcoal', 'hex' => '#808080'],
        48 => ['name' => 'grey', 'hex' => '#b8b8b8'],
        49 => ['name' => 'taupe', 'hex' => '#ccac93'],
    ];


    /**
     * Gets the ID of a color by its name.
     */
    public static function getIdByName(string $name): int
    {
        foreach (self::$colors as $id => $color) {
            if ($color['name'] == $name) {
                return $id;
            }
        }

        throw new \InvalidArgumentException(sprintf('%s is an invalid color!', $name));
    }

    public static function isValid(string $colorName): bool
    {
        foreach (self::$colors as $color) {
            if ($color['name'] === $colorName) return true;
        }

        return false;
    }
}