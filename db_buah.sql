-- Buat database
CREATE DATABASE IF NOT EXISTS db_buah;
USE db_buah;

-- Buat tabel klasifikasi
CREATE TABLE IF NOT EXISTS klasifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_file VARCHAR(255),
    hasil VARCHAR(100),
    contrast FLOAT,
    dissimilarity FLOAT,
    homogeneity FLOAT,
    energy FLOAT,
    correlation FLOAT,
    asm FLOAT,
    mean_r FLOAT,
    mean_g FLOAT,
    mean_b FLOAT,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP
);
