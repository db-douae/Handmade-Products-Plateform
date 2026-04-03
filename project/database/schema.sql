CREATE TABLE users(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    interests TEXT,
    role ENUM('buyer','artisan') NOT NULL DEFAULT 'buyer'
);

CREATE TABLE artisan_shops (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  shop_name VARCHAR(255) NOT NULL,
  category_name VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
CREATE TABLE products (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shop_id       INT UNSIGNED  NOT NULL,
    product_name  VARCHAR(255)  NOT NULL,
    price         DECIMAL(10,2) NOT NULL,
    product_info  TEXT,
    image_product VARCHAR(500),
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (shop_id) REFERENCES artisan_shops(id) ON DELETE CASCADE
);

CREATE TABLE artisans(
    id INT UNSIGNED PRIMARY KEY,
    description TEXT,
    shop_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (shop_id) REFERENCES artisan_shops(id)
);

CREATE TABLE notifications(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN,
    type ENUM('customize_order','customize_product','normal_order','refuse_order','accept_order')
    NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE delivery_info (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_number VARCHAR(255) NOT NULL,
    address VARCHAR(100) NOT NULL,
    wilaya VARCHAR(20) NOT NULL,
    delivery_date DATE NOT NULL
);

CREATE TABLE normal_orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    delivery_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED DEFAULT 1,
    status ENUM('pending','confirmed','delivered') DEFAULT 'pending',
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (delivery_id) REFERENCES delivery_info(id)
);

CREATE TABLE customize_products (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL UNIQUE,
    color      VARCHAR(100),
    size       VARCHAR(100),
    text       TEXT,
    status     VARCHAR(100) NOT NULL DEFAULT 'available',
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
  
CREATE TABLE customize_orders (
    id                   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id              INT UNSIGNED NOT NULL,
    customize_product_id INT UNSIGNED NOT NULL,
    order_name           VARCHAR(255) NOT NULL,
    order_definition     TEXT,
    status               ENUM('pending','confirmed','delivered') NOT NULL DEFAULT 'pending',
    order_date           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)              REFERENCES users(id)              ON DELETE CASCADE,
    FOREIGN KEY (customize_product_id) REFERENCES customize_products(id) ON DELETE CASCADE
);

CREATE TABLE customer_reviews (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    rating     TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment    TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_review_user_product (user_id, product_id),
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
 
SET FOREIGN_KEY_CHECKS = 1;
