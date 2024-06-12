<?php

namespace App\Abstracts;

use PDO;
use App\Config;

final class DB
{
    private static PDO $instance;

    private function __construct() {}

    public static function getInstance(): \PDO
    {
        if (empty(self::$instance)) {

            $db_drive     = config('DB_DRIVE', 'mysql');
            $db_host      = config('DB_HOST');
            $db_port      = config('DB_PORT');
            $db_name      = config('DB_NAME');
            $db_user      = config('DB_USER');
            $db_password  = config('DB_PASSWORD');

            self::$instance = new PDO(
                $db_drive . ":host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name,
                $db_user,
                $db_password
            );
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return self::$instance;
        }
        return self::$instance;

    }
}