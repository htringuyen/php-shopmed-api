create database if not exists medshop;
use medshop;

CREATE TABLE User (
                      id INT PRIMARY KEY AUTO_INCREMENT,
                      fullName VARCHAR(255),
                      email VARCHAR(255),
                      address VARCHAR(255),
                      phone VARCHAR(20)
);

CREATE TABLE AuthInfo (
                          id INT PRIMARY KEY AUTO_INCREMENT,
                          username VARCHAR(255),
                          passwordHash VARCHAR(255),
                          authority SMALLINT,
                          userId INT,
                          FOREIGN KEY (userId) REFERENCES User(id)
);

CREATE TABLE ProductCategory (
                                 id INT PRIMARY KEY AUTO_INCREMENT,
                                 name VARCHAR(255)
);

CREATE TABLE Product (
                         id INT PRIMARY KEY AUTO_INCREMENT,
                         name VARCHAR(255),
                         description TEXT,
                         categoryId INT,
                         inStockCount INT,
                         price DECIMAL(10, 2),
                         FOREIGN KEY (categoryId) REFERENCES ProductCategory(id)
);

CREATE TABLE ServiceCategory (
                                 id INT PRIMARY KEY AUTO_INCREMENT,
                                 name VARCHAR(255)
);

CREATE TABLE Service (
                         id INT PRIMARY KEY AUTO_INCREMENT,
                         name VARCHAR(255),
                         description TEXT,
                         categoryId INT,
                         price DECIMAL(10, 2),
                         FOREIGN KEY (categoryId) REFERENCES ServiceCategory(id)
);

CREATE TABLE ProductOrder (
                              id INT PRIMARY KEY AUTO_INCREMENT,
                              userId INT,
                              createdAt TIMESTAMP,
                              isPaid TINYINT(1),
                              isDelivered TINYINT(1),
                              status VARCHAR(50),
                              note TEXT,
                              FOREIGN KEY (userId) REFERENCES User(id)
);

CREATE TABLE CartItem (
                          id INT PRIMARY KEY AUTO_INCREMENT,
                          productId INT,
                          userId INT,
                          createdAt TIMESTAMP,
                          quantity INT,
                          isActive TINYINT(1),
                          FOREIGN KEY (productId) REFERENCES Product(id),
                          FOREIGN KEY (userId) REFERENCES User(id)
);

CREATE TABLE OrderItem (
                           id INT PRIMARY KEY AUTO_INCREMENT,
                           productId INT,
                           orderId INT,
                           price DECIMAL(10, 2),
                           quantity INT,
                           FOREIGN KEY (productId) REFERENCES Product(id),
                           FOREIGN KEY (orderId) REFERENCES ProductOrder(id)
);

CREATE TABLE ProductReview (
                               id INT PRIMARY KEY AUTO_INCREMENT,
                               content TEXT,
                               reviewedAt TIMESTAMP,
                               rating INT,
                               userId INT,
                               productId INT,
                               FOREIGN KEY (userId) REFERENCES User(id),
                               FOREIGN KEY (productId) REFERENCES Product(id)
);

CREATE TABLE Article (
                         id INT PRIMARY KEY AUTO_INCREMENT,
                         title VARCHAR(255),
                         content TEXT,
                         publishedOn TIMESTAMP,
                         userId INT,
                         FOREIGN KEY (userId) REFERENCES User(id)
);

CREATE TABLE ArticleComment (
                                id INT PRIMARY KEY AUTO_INCREMENT,
                                content TEXT,
                                commentedAt TIMESTAMP,
                                userId INT,
                                articleId INT,
                                FOREIGN KEY (userId) REFERENCES User(id),
                                FOREIGN KEY (articleId) REFERENCES Article(id)
);

-- Set the starting auto-increment value for each table
ALTER TABLE User AUTO_INCREMENT = 1000001;
ALTER TABLE AuthInfo AUTO_INCREMENT = 1000001;
ALTER TABLE ProductCategory AUTO_INCREMENT = 1000001;
ALTER TABLE Product AUTO_INCREMENT = 1000001;
ALTER TABLE ServiceCategory AUTO_INCREMENT = 1000001;
ALTER TABLE Service AUTO_INCREMENT = 1000001;
ALTER TABLE ProductOrder AUTO_INCREMENT = 1000001;
ALTER TABLE CartItem AUTO_INCREMENT = 1000001;
ALTER TABLE OrderItem AUTO_INCREMENT = 1000001;
ALTER TABLE ProductReview AUTO_INCREMENT = 1000001;
ALTER TABLE Article AUTO_INCREMENT = 1000001;
ALTER TABLE ArticleComment AUTO_INCREMENT = 1000001;
