CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT UNIQUE,
    password VARCHAR(255) NOT NULL,
    interests TEXT,
    role ENUM('buyer','artisan') NOT NULL DEFAULT 'buyer'
);

CREATE TABLE artisans(
    id INT PRIMARY KEY,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
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
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_number INT NOT NULL,
    address VARCHAR(100) NOT NULL,
    wilaya VARCHAR(20) NOT NULL,
    delivery_date DATE NOT NULL,
);

CREATE TABLE normal_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    product_id INT NOT NULL,
    delivery_id INT NOT NULL,
    quantity INT DEFAULT 1,
    status ENUM('pending','confirmed','delivered') NOT NULL,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (delivery_id) REFERENCES delivery_info(id)
);
CREATE TABLE `artisan_shops` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `artisan_id`    INT UNSIGNED NOT NULL,
  `shop_name`     VARCHAR(255) NOT NULL,
  `category_name` VARCHAR(255)          DEFAULT NULL,
  `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_shop_artisan` (`artisan_id`),
  CONSTRAINT `fk_shop_artisan`
    FOREIGN KEY (`artisan_id`) REFERENCES `artisans` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `products` (
  `id`            INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `shop_id`       INT UNSIGNED   NOT NULL,
  `product_name`  VARCHAR(255)   NOT NULL,
  `price`         DECIMAL(10,2)  NOT NULL,
  `product_info`  TEXT,
  `image_product` VARCHAR(500)            DEFAULT NULL,
  `created_at`    TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_products_shop` (`shop_id`),
  CONSTRAINT `fk_products_shop`
    FOREIGN KEY (`shop_id`) REFERENCES `artisan_shops` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `customize_products` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT UNSIGNED NOT NULL,
  `color`      VARCHAR(100)          DEFAULT NULL,
  `size`       VARCHAR(100)          DEFAULT NULL,
  `text`       TEXT,
  `status`     VARCHAR(100) NOT NULL DEFAULT 'available',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_customize_product` (`product_id`),
  CONSTRAINT `fk_customize_products_product`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `customize_orders` (
  `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`              INT UNSIGNED NOT NULL,
  `customize_product_id` INT UNSIGNED NOT NULL,
  `order_name`           VARCHAR(255) NOT NULL,
  `order_definition`     TEXT,
  `status`               ENUM('pending','confirmed','delivered') NOT NULL DEFAULT 'pending',
  `order_date`           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_customize_orders_user`    (`user_id`),
  KEY `idx_customize_orders_product` (`customize_product_id`),
  CONSTRAINT `fk_customize_orders_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_customize_orders_product`
    FOREIGN KEY (`customize_product_id`) REFERENCES `customize_products` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `customer_reviews` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `rating`     TINYINT UNSIGNED NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment`    TEXT                      DEFAULT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_review_user_product` (`user_id`, `product_id`),
KEY `idx_reviews_product` (`product_id`),
  KEY `idx_reviews_user`    (`user_id`),
  CONSTRAINT `fk_reviews_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reviews_product`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
SET FOREIGN_KEY_CHECKS = 1;
