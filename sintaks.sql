-- DDL
CREATE DATABASE inventaris_sekolah;

USE inventaris_sekolah;

CREATE TABLE rooms(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_ruangan VARCHAR(20) UNIQUE,
    room_name VARCHAR(50) NOT NULL,
    user_id INT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
    description TEXT NUll,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

SHOW TABLES;

DESC rooms;

CREATE TABLE barang(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_code VARCHAR(20) UNIQUE,
    item_name VARCHAR(50) NOT NULL,
    room_id INT UNSIGNED,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE,
    description TEXT NULL,
    rental_price FLOAT NOT NULL,
    late_fee_per_day FLOAT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE rooms MODIFY room_name VARCHAR(255) NOT NULL UNIQUE;

DESC rooms;

ALTER TABLE rooms CHANGE kode_ruangan room_code VARCHAR(20);

ALTER TABLE items add `condition` ENUM('good', 'fair', 'bad') NOT NULL AFTER description;

ALTER TABLE barang rename items;

DROP TABLE items;

DROP DATABASE inventaris_sekolah;

-- DMl

-- Buat Ulang Database dan tablenya

CREATE DATABASE inventaris_sekolah;

USE inventaris_sekolah;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    user_code VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    role ENUM('admin', 'operator', 'borrower'),
    gender ENUM('laki-laki', 'perempuan'),
    email_verified_at TIMESTAMP,
    password VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE rooms(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    room_code VARCHAR(20) UNIQUE,
    room_name VARCHAR(50) NOT NULL,
    user_id INT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
    description TEXT NUll,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE items(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_code VARCHAR(20) UNIQUE,
    item_name VARCHAR(50) NOT NULL,
    room_id INT UNSIGNED,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE ON UPDATE CASCADE,
    description TEXT NULL,
    `condition` ENUM('good', 'fair', 'bad') NOT NULL,
    rental_price FLOAT NOT NULL,
    late_fee_per_day FLOAT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE table borrows(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    verification_code_for_borrow_request VARCHAR(255) NULL,
    item_id INT UNSIGNED,
    user_id INT UNSIGNED,
    borrow_code VARCHAR(255) UNIQUE,
    borrow_date DATE NOT NULL,
    return_date DATE NOT NULL,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    borrow_status ENUM('pending', 'completed', 'borrowed', 'rejected') NOT NULL,
    borrow_quantity INT(15) NOT NULL,
    late_fee float(15) NOT NULL,
    total_rental_price float(15) NOT NULL,
    sub_total float(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO users (username, user_code, email, first_name, last_name, role, gender, email_verified_at, password, remember_token, created_at, updated_at)
VALUE ('arvin.ajif', 'JD001', 'arvin.ajif@example.com', 'Arvin', 'Ajif', 'admin', 'laki-laki', NULL, 'password123', NULL, NOW(), NOW());

INSERT INTO users (username, user_code, email, first_name, last_name, role, gender, email_verified_at, password, remember_token, created_at, updated_at) VALUE
('ali_ahmad', 'ADM0002', 'ali_ahmad@example.com', 'Ali', 'Ahmad', 'admin', 'laki-laki', NULL, 'password123', NULL, NOW(), NOW()),
('muthia.mutmainah_aprinelia', 'ADM0003', 'muthia.mutmainah_aplinelia@example.com', 'Muthia Mutmainah', 'Aprinelia', 'admin', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('dita.karang', 'OPR0001', 'dita.karang@example.com', 'Dita', 'Bayeo', 'operator', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('lee.soodam', 'OPR0002', 'lee.soodam@example.com', 'Neng', 'Dami', 'operator', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('park_jinny', 'OPR0003', 'park_jinny@example.com', 'Pink', 'Princess', 'operator', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('ogawa_mizuki', 'BRW0001', 'ogawa_mizuki@example.com', 'Oh', 'Mija', 'borrower', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('park_minji', 'BRW0002', 'park_minji@example.com', 'Orenji', 'Vitaminji', 'borrower', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('ji.yeong_ju', 'BRW0003', 'ji.yeong_ju@example.com', 'Zuu', 'Baedah', 'borrower', 'perempuan', NULL, 'password123', NULL, NOW(), NOW()),
('na.jaemin', 'ADM0004', 'na.jaemin@example.com', 'Na', 'Jaemin', 'admin', 'laki-laki', NULL, 'password123', NULL, NOW(), NOW()),
('moch_zayyan', 'OPR0004', 'moch_zayyan@example.com', 'Muhammad', 'Zayyan', 'operator', 'laki-laki', NULL, 'password123', NULL, NOW(), NOW());

INSERT INTO rooms(room_code, room_name, user_id, description)
VALUE ('RMAM8213B-0000001', 'R-A-1-01', 2, 'Ruang Kelas');

INSERT INTO rooms(room_code, room_name, user_id, description) VALUE
('RMAM8213B-0000001', 'R-A-1-01', 2, 'Ruang Kelas'),
('RM7328878-0000002', 'R-A-1-02', 4, 'Ruang Kelas'),
('RM7HJS823-0000003', 'R-A-1-03', 2, 'Ruang Kelas'),
('RMSHD8732-0000004', 'R-A-1-04', 4, 'Ruang Kelas');

INSERT INTO rooms(room_code, room_name, user_id, description) VALUE
('RMAM8213B-0000001', 'R-A-1-01', 2, 'Ruang Kelas'),
('RM7328878-0000002', 'R-A-1-02', 4, 'Ruang Kelas'),
('RM7HJS823-0000003', 'R-A-1-03', 2, 'Ruang Kelas'),
('RMSHD8732-0000004', 'R-A-1-04', 4, 'Ruang Kelas');


INSERT INTO items (item_code, item_name, room_id, description, `condition`, rental_price, late_fee_per_day, quantity, created_at, updated_at)
VALUE ('ITM001', 'Meja', 4, 'Meja', 'good', 10000, 20000, 22, NOW(), NOW());

INSERT INTO items (item_code, item_name, room_id, description, `condition`, rental_price, late_fee_per_day, quantity, created_at, updated_at)
VALUE ('ITM002', 'Buku', 5, 'Buku', 'good', 1000, 10000, 2, NOW(), NOW()),
VALUE ('ITM003', 'Lemari', 6, 'Lemari', 'fair', 18000, 22000, 1, NOW(), NOW()),
VALUE ('ITM004', 'Kursi', 4, 'Kursi', 'good', 14000, 18000, 42, NOW(), NOW());


INSERT INTO borrows (verification_code_for_borrow_request, item_id, user_id, borrow_code, borrow_date, return_date, borrow_status, borrow_quantity, late_fee, total_rental_price, sub_total, created_at, updated_at)
VALUE (NULL, 1, 7, 'BRW001', '2023-06-01', '2023-06-03', 'completed', 2, 0.0, 6000, 6000, NOW(), NOW());

INSERT INTO borrows (verification_code_for_borrow_request, item_id, user_id, borrow_code, borrow_date, return_date, borrow_status, borrow_quantity, late_fee, total_rental_price, sub_total, created_at, updated_at)
VALUES
('KJSADB', 3, 8, 'BRW002', '2023-06-03', '2023-06-06', 'pending', 1, 0, 0, 0, NOW(), NOW()),
(NULL, 4, 9, 'BRW004', '2023-06-04', '2023-06-07', 'completed', 39, 0.0, 1792000, 1792000, NOW(), NOW()),
(NULL, 4, 9, 'BRW005', '2023-06-05', '2023-06-08', 'borrowed', 3, 0, 0, 0, NOW(), NOW());

UPDATE borrows
SET borrow_status = 'borrowed',
    late_fee = 0,
    total_rental_price = 0,
    sub_total = 0,
    updated_at = NOW()
WHERE id = 2;

DELETE FROM borrows WHERE id = 3;

-- DML LANJUTAN


DESC items;
