<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseBackupController extends Controller
{
    /**
     * Jalankan backup database dan download sebagai file .sql
     * Menggunakan PHP murni (tidak butuh mysqldump) — aman di shared hosting Hostinger.
     */
    public function download()
    {
        $db     = config('database.connections.mysql.database');
        $host   = config('database.connections.mysql.host');
        $user   = config('database.connections.mysql.username');
        $pass   = config('database.connections.mysql.password');
        $port   = config('database.connections.mysql.port', 3306);
        $now    = now()->format('Ymd_His');
        $filename = "backup_{$db}_{$now}.sql";

        // ─── Header untuk download file ─────────────────────────────────────
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        flush();

        // ─── Koneksi PDO langsung ────────────────────────────────────────────
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        $pdo = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);

        // ─── Header SQL ──────────────────────────────────────────────────────
        echo "-- ============================================================\n";
        echo "-- JukungSync - Backup Database\n";
        echo "-- Database  : {$db}\n";
        echo "-- Dibuat    : " . now()->format('Y-m-d H:i:s') . "\n";
        echo "-- ============================================================\n\n";
        echo "SET FOREIGN_KEY_CHECKS=0;\n";
        echo "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n";
        echo "SET NAMES utf8mb4;\n\n";

        // ─── Ambil daftar semua tabel ────────────────────────────────────────
        $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // ── DROP TABLE IF EXISTS ────────────────────────────────────────
            echo "-- -------- Tabel: `{$table}` --------\n";
            echo "DROP TABLE IF EXISTS `{$table}`;\n";

            // ── CREATE TABLE ────────────────────────────────────────────────
            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            $createSQL  = $createStmt['Create Table'] ?? ($createStmt['Create View'] ?? '');
            echo $createSQL . ";\n\n";

            // ── INSERT DATA ─────────────────────────────────────────────────
            $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
            if (count($rows) > 0) {
                $columns = array_keys($rows[0]);
                $colList = implode('`, `', $columns);

                // Batch insert per 500 baris agar tidak habis memory
                $chunks = array_chunk($rows, 500);
                foreach ($chunks as $chunk) {
                    $values = [];
                    foreach ($chunk as $row) {
                        $vals = array_map(function ($v) use ($pdo) {
                            if ($v === null) return 'NULL';
                            return $pdo->quote($v);
                        }, array_values($row));
                        $values[] = '(' . implode(', ', $vals) . ')';
                    }
                    echo "INSERT INTO `{$table}` (`{$colList}`) VALUES\n";
                    echo implode(",\n", $values) . ";\n";
                }
                echo "\n";
            }
        }

        echo "\nSET FOREIGN_KEY_CHECKS=1;\n";
        echo "-- ============================================================\n";
        echo "-- Selesai. Total tabel: " . count($tables) . "\n";
        echo "-- ============================================================\n";

        exit;
    }
}
