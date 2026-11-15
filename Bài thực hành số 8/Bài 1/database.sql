-- 1. Tao co so du lieu
CREATE DATABASE product_management
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 2. Su dung database
USE product_management;

-- 3. Tao bang products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL CHECK (price > 0),
    stock INT NOT NULL CHECK (stock >= 0)
);

-- 4. Them 3 san pham mau
INSERT INTO products (name, price, stock)
VALUES
('But bi', 5000, 20),
('Vo o ly', 12000, 15),
('Thuoc ke', 8000, 0);

-- 5. Kiem tra du lieu
SELECT * FROM products;
