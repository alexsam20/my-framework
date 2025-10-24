<?php

use core\Database;

class m0002_create_gallery_table
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function up(): void
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS gallery (
                id INT AUTO_INCREMENT PRIMARY KEY,
                post_id INT,
                image VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        $this->db->execute();
    }

    public function down(): void
    {
        $this->db->query("DROP TABLE gallery;");
        $this->db->execute();
    }
}