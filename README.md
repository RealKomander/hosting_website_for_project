# hosting_website_for_project
How to use:
## 1) create a MySQL database:
```sql
CREATE TABLE Users (
    user_ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone_number VARCHAR(15),
    password_hash VARCHAR(255),
    user_type ENUM('customer', 'administrator', 'billing_operator'),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE HostingPlans (
    plan_ID INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(50),
    CPU_cores INT,
    memory_GB INT,
    storage_GB INT,
    price DECIMAL(10, 2)
);

CREATE TABLE ServerNodes (
    server_ID INT AUTO_INCREMENT PRIMARY KEY,
    hostname VARCHAR(100),
    IP_address VARCHAR(15),
    drive_capacity_GB INT,
    RAM_amount_GB INT
);

CREATE TABLE VMs (
    VM_ID INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    plan_ID INT,
    server_ID INT,
    status ENUM('Running', 'Stopped', 'Suspended'),
    ordered_until TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES Users(user_ID),
    FOREIGN KEY (plan_ID) REFERENCES HostingPlans(plan_ID),
    FOREIGN KEY (server_ID) REFERENCES ServerNodes(server_ID)
);

CREATE TABLE Payments (
    payment_ID INT AUTO_INCREMENT PRIMARY KEY,
    customer_ID INT,
    amount DECIMAL(10, 2),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method ENUM('Credit Card', 'PayPal'),
    status ENUM('Completed', 'Pending', 'Failed'),
    FOREIGN KEY (customer_ID) REFERENCES Users(user_ID)
);

-- These tables are necessary to populate. Here are the values that I used in my project:
INSERT INTO HostingPlans (plan_name, CPU_cores, memory_GB, storage_GB, price) VALUES
('Proxy (Bungeecord/Velocity)', 1.5, 1.5, 20, 1.20),
('Earth', 1.5, 1.5, 30, 2.00),
('Cobblestone', 1.5, 3, 50, 2.80),
('Stone', 1.5, 4.5, 70, 5.56),
('Andesite', 2, 5, 80, 7.96),
('Flint', 2, 5.5, 90, 9.96),
('Water', 2.5, 6, 100, 11.96),
('Lapis Lazuli', 4, 7, 110, 15.96),
('Gold', 4.5, 8, 150, 19.96),
('Diamond', 4.5, 10, 160, 25.96),
('Netherite', 5, 14, 150, 35.96),
('Wither', 6, 18, 200, 47.96);

INSERT INTO ServerNodes (hostname, IP_address, drive_capacity_GB, RAM_amount_GB) VALUES
('r5950x-1.roothost.cloud', '192.168.1.104', 1920, 128),
('r7700-1.roothost.cloud', '192.168.1.105', 1024, 32),
('2680v4-1.roothost.cloud', '192.168.1.110', 1920, 256),
('2680v4-2.roothost.cloud', '192.168.1.111', 1920, 256),
('2680v4-3.roothost.cloud', '192.168.1.112', 1920, 256);
```
## 2) enter valid MySQL credentials in db.php
