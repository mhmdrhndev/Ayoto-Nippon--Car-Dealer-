<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->bangunUlangSqlite(['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Lunas', 'Batal']);

            return;
        }
        DB::statement("ALTER TABLE leads MODIFY status ENUM('Baru','Dihubungi','TestDrive','SPK','Deal','Lunas','Batal') DEFAULT 'Baru'");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->bangunUlangSqlite(['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Batal']);

            return;
        }
        DB::statement("UPDATE leads SET status = 'Deal' WHERE status = 'Lunas'");
        DB::statement("ALTER TABLE leads MODIFY status ENUM('Baru','Dihubungi','TestDrive','SPK','Deal','Batal') DEFAULT 'Baru'");
    }

    // SQLite tak bisa MODIFY kolom: bangun ulang tabel dengan CHECK status baru.
    private function bangunUlangSqlite(array $status): void
    {
        $daftar = "'".implode("','", $status)."'";
        DB::statement('PRAGMA foreign_keys = OFF');
        DB::statement("UPDATE leads SET status = 'Deal' WHERE status NOT IN ({$daftar})");
        DB::statement(<<<SQL
            CREATE TABLE leads_baru (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                customer_id BIGINT NULL REFERENCES customers (id) ON DELETE SET NULL,
                sales_id BIGINT NULL REFERENCES users (id) ON DELETE SET NULL,
                sumber VARCHAR(255) NOT NULL DEFAULT 'Web',
                status VARCHAR(255) NOT NULL DEFAULT 'Baru' CHECK (status IN ({$daftar})),
                kebutuhan_text TEXT NULL,
                followup_at DATETIME NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        SQL);
        DB::statement('INSERT INTO leads_baru SELECT * FROM leads');
        DB::statement('DROP TABLE leads');
        DB::statement('ALTER TABLE leads_baru RENAME TO leads');
        DB::statement('CREATE INDEX leads_status_sales_id_index ON leads (status, sales_id)');
        DB::statement('PRAGMA foreign_keys = ON');
    }
};
