CREATE DATABASE IF NOT EXISTS shop_db;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT ON shop_db.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE shop_db;
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  quantity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
  userName VARCHAR(255) PRIMARY KEY NOT NULL,
  userPassword VARCHAR(255) NOT NULL
);



INSERT INTO products (product_name, price) VALUES ('Brick', 10.00);
INSERT INTO products (product_name, price) VALUES ('Cement', 5.50);

INSERT INTO orders (product_id, quantity) VALUES (1, 100);
INSERT INTO orders (product_id, quantity) VALUES (2, 50);

