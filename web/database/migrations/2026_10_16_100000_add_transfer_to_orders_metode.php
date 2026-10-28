<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->bangunUlangSqlite("'Cash','Kredit','TradeIn','Transfer'");

            return;
        }
        DB::statement("ALTER TABLE orders MODIFY metode ENUM('Cash','Kredit','TradeIn','Transfer') NOT NULL");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $this->bangunUlangSqlite("'Cash','Kredit','TradeIn'");

            return;
        }
        DB::statement("UPDATE orders SET metode = 'Cash' WHERE metode = 'Transfer'");
        DB::statement("ALTER TABLE orders MODIFY metode ENUM('Cash','Kredit','TradeIn') NOT NULL");
    }

    // SQLite tak bisa MODIFY kolom: bangun ulang tabel dengan CHECK metode baru.
    private function bangunUlangSqlite(string $daftar): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        DB::statement("UPDATE orders SET metode = 'Cash' WHERE metode NOT IN ({$daftar})");
        DB::statement(<<<SQL
            CREATE TABLE orders_baru (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                no_spk VARCHAR(255) NOT NULL UNIQUE,
                customer_id BIGINT NOT NULL REFERENCES customers (id) ON DELETE CASCADE,
                unit_id BIGINT NOT NULL REFERENCES units (id) ON DELETE CASCADE,
                branch_id BIGINT NOT NULL REFERENCES branches (id) ON DELETE CASCADE,
                metode VARCHAR(255) NOT NULL CHECK (metode IN ({$daftar})),
                leasing_id BIGINT NULL REFERENCES leasing_partners (id) ON DELETE SET NULL,
                dp_rencana BIGINT NOT NULL DEFAULT 0,
                tenor SMALLINT NULL,
                angsuran_estimasi BIGINT NULL,
                booking_fee BIGINT NOT NULL,
                status VARCHAR(255) NOT NULL DEFAULT 'MenungguBayar' CHECK (status IN ('MenungguBayar','MenungguVerifikasi','Deal','Ditolak','Expired','Batal')),
                deadline_at DATETIME NOT NULL,
                bukti_path VARCHAR(255) NULL,
                verified_by BIGINT NULL REFERENCES users (id) ON DELETE SET NULL,
                verified_at DATETIME NULL,
                tolak_alasan TEXT NULL,
                bast_path VARCHAR(255) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        SQL);
        DB::statement('INSERT INTO orders_baru SELECT * FROM orders');
        DB::statement('DROP TABLE orders');
        DB::statement('ALTER TABLE orders_baru RENAME TO orders');
        DB::statement('CREATE INDEX orders_status_deadline_at_index ON orders (status, deadline_at)');
        DB::statement('PRAGMA foreign_keys = ON');
    }
};
