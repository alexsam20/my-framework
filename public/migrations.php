<?php
/********** php -S localhost:8000 -t public/ **********/
declare(strict_types=1);
namespace app\migration;


use core\Database;
require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';
require_once HELPERS . DS . 'functions.php';

$app = new \core\Application();
require_once CONFIG . DS . 'routes.php';

function applyMigrations($pdo): void
{
    createMigrationsTable($pdo);
    $dataBaseObjects = getAppliedMigrations($pdo);
    $appliedMigrations = [];
    foreach ($dataBaseObjects as $value) {
        $appliedMigrations[] = $value->migration;
    }
    $newMigrations = [];
    $files = scandir(APP . '/migrations');
    $toApplyMigrations = array_diff($files, $appliedMigrations);


    foreach ($toApplyMigrations as $migration) {
        if ($migration ==='.' || $migration === '..') {
            continue;
        }
        require_once APP . '/migrations/' . $migration;
        $className = pathinfo($migration, PATHINFO_FILENAME);
        $instance = new $className();
        logging("Applying migration $migration");
        $instance->up();
        logging("Applied migration $migration");
        $newMigrations[] = $migration;
    }

    if (!empty($newMigrations)) {
        saveMigrations($newMigrations, $pdo);
    } else {
        logging('All migrations are applied');
    }
}

function createMigrationsTable($pdo): void
{
    $pdo->query("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $pdo->execute();
}

function getAppliedMigrations($pdo): false|array
{
    $pdo->query("SELECT migration FROM migrations;");
    return $pdo->resultSet();
}

function saveMigrations(array $migrations, $pdo): void
{
    $str = implode(',', array_map(static fn($m) => "('$m')", $migrations));
    $pdo->query("INSERT INTO migrations (migration) VALUE $str");
    $pdo->execute();
}

function logging($message): void
{
    echo '<strong>[' . date('Y-m-d H:i:s') . ']</strong> - ' . $message . '<br />';
}
/** TODO Пересмотреть подключение соединения с базой даных */
//function execDump($path_dump, $pdo)
//{
//    $data = file_get_contents(DOCUMENT_ROOT . $path_dump);
//    $pdo->query($data);
//    $pdo->execute();
//}
applyMigrations(db());
//execDump('/files/dump-data.sql', $pdo);
