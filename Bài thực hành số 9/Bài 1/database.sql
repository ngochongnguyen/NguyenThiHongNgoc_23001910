-- UPLOAD ANH VA PHAN TRANG SAN PHAM
-- PHAN 1: CAP NHAT CO SO DU LIEU

-- 1. Kiem tra bang products
DESCRIBE products;

-- 2. Them cot image de luu duong dan anh
ALTER TABLE products
ADD COLUMN image VARCHAR(255) NULL
AFTER stock;

-- 3. Kiem tra lai cau truc bang
DESCRIBE products;

-- 4. Kiem tra danh sach san pham
SELECT
    id,
    name,
    price,
    stock,
    image
FROM products
ORDER BY id DESC;


