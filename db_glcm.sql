CREATE DATABASE IF NOT EXISTS db_glcm;
USE db_glcm;

CREATE TABLE IF NOT EXISTS klasifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gambar_asli VARCHAR(255),
    gambar_edit VARCHAR(255),
    contrast FLOAT,
    dissimilarity FLOAT,
    homogeneity FLOAT,
    energy FLOAT,
    correlation FLOAT,
    asm FLOAT,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
