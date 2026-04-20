<?php

declare(strict_types=1);

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        require_once APP_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
        $this->db = Database::connection();
    }
}
