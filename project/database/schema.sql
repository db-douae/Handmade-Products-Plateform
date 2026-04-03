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
    quantity INT DEFAULT 1,
    status ENUM('pending','confirmed','delivered') NOT NULL,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (delivery_id) REFERENCES delivery_info(id)
);
