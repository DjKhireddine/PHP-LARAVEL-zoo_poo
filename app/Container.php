<?php

namespace App;

use App\Database\DB;
use App\Database\Repository\AnimalRepository;

class Container {
    private static ?Zoo $zoo = null;

    public static function getZoo(): Zoo {
        if (self::$zoo === null) {
            $pdo = DB::getPdo();
            $repo = AnimalRepository::getInstance($pdo);
            self::$zoo = new Zoo($repo);
        }
        return self::$zoo;
    }
}
