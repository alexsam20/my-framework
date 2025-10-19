<?php

//namespace app\migrations;

use core\Database;

class m0001_create_posts_table
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function up(): void
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                content TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                slug VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci UNIQUE DEFAULT NULL,
                is_deleted TIMESTAMP DEFAULT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )  ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        $this->db->execute();
    }

    public function down(): void
    {
        $this->db->query("DROP TABLE posts;");
        $this->db->execute();
    }
}