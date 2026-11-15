-- 1. Tao co so du lieu
CREATE DATABASE product_management
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 2. Su dung co so du lieu
USE product_management;

-- 3. Tao bang products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL CHECK (price > 0),
    stock INT NOT NULL CHECK (stock >= 0)
);

-- 4. Them 3 dong du lieu mau
INSERT INTO products (name, price, stock)
VALUES
('Bút bi', 5000, 20),
('Vở ô ly', 12000, 15),
('Thước kẻ', 8000, 0);
