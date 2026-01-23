-- Fix sequence untuk tabel level2s
-- Jalankan query ini di PostgreSQL untuk memperbaiki sequence

-- 1. Cek nilai sequence saat ini
SELECT currval ('level2s_id_seq') AS current_sequence_value;

-- 2. Cek ID tertinggi di tabel
SELECT MAX(id) AS max_id FROM level2s;

-- 3. Reset sequence ke nilai yang benar (MAX(id) + 1)
SELECT setval (
        'level2s_id_seq', (
            SELECT COALESCE(MAX(id), 0) + 1
            FROM level2s
        ), false
    );

-- 4. Verifikasi sequence sudah benar
SELECT currval ('level2s_id_seq') AS new_sequence_value;