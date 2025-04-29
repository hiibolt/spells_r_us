DROP TABLE IF EXISTS UserPlacesOrder;
DROP TABLE IF EXISTS ProductInUserCart;
DROP TABLE IF EXISTS ProductPartOfOrder;

DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS Product;

CREATE TABLE `User` (
    UserId INT PRIMARY KEY AUTO_INCREMENT,
    IsEmployee BOOLEAN NOT NULL DEFAULT False,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Product (
    ProductId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Inventory INT NOT NULL, 
    Description VARCHAR(255) NOT NULL,
    ImageUrl VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE `Order` (
    OrderId INT PRIMARY KEY AUTO_INCREMENT,
    UserId INT NOT NULL,
    Status VARCHAR(50) NOT NULL DEFAULT 'Processing',
    Notes VARCHAR(255) NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    ShippedAt DATETIME DEFUALT NULL,
    ShippingAddress VARCHAR(512) NOT NULL,
    FOREIGN KEY (UserId) REFERENCES `User`(UserId)
);

CREATE TABLE UserPlacesOrder (
    UserId INT,
    OrderId INT,
    PRIMARY KEY (UserId, OrderId),
    FOREIGN KEY (UserId) REFERENCES `User`(UserId),
    FOREIGN KEY (OrderId) REFERENCES `Order`(OrderId)
);

CREATE TABLE ProductInUserCart (
    UserId INT,
    ProductId INT,
    Quantity INT NOT NULL,
    PRIMARY KEY (UserId, ProductId),
    FOREIGN KEY (UserId) REFERENCES `User`(UserId),
    FOREIGN KEY (ProductId) REFERENCES Product(ProductId)
);

CREATE TABLE ProductPartOfOrder (
    OrderId INT,
    ProductId INT,
    Quantity INT NOT NULL,
    PRIMARY KEY (OrderId, ProductId),
    FOREIGN KEY (OrderId) REFERENCES `Order`(OrderId),
    FOREIGN KEY (ProductId) REFERENCES Product(ProductId)
);