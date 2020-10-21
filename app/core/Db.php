<?php

namespace app\core;

use PDO;

class Db
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] .
                ';port=' . $_ENV['DB_PORT'] .
                ';dbname=' . $_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );

            if ($_ENV['APP_DEBUG'] === true) $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            else $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            View::error_page_with_message($e->getMessage());
        }
    }
}