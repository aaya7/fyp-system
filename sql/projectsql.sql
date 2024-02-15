CREATE TABLE customers (
    customerID int NOT NULL, #studentid/staffid
    customerName varchar(100) NOT NULL,
    customerCategory varchar(10), #student/staff
    customerFaculty varchar(25), #KPPIM/FA/FSG
    customerCourse varchar(25), #CS230/CS110
    customerAddress varchar(100), #college address
    customerPnum varchar(20),
    customerEmail varchar(50), #studentemail/staffemail
    password varchar(255), -- The hashed password will be stored here
    token varchar(100), -- The token for additional security
    PRIMARY KEY (customerID)
);
 
CREATE TABLE sellers (
    sellerID int NOT NULL, #studentid/staffid
    sellerName varchar(100) NOT NULL,
    sellerCategory varchar(10), #student/staff
    sellerFaculty varchar(25), #KPPIM/FA/FSG
    sellerCourse varchar(25), #CS230/CS110
    sellerAddress varchar(100), #college address
    sellerPnum varchar(20),
    sellerEmail varchar(50), #studentemail/staffemail
    shopCategory varchar(50);
    shopName varchar(100),
    shopCreated date DEFAULT CURRENT_DATE();
    password varchar(255), -- The hashed password will be stored here
    token varchar(100), -- The token for additional security
    PRIMARY KEY (sellerID)
);

CREATE TABLE admin (
    adminID int NOT NULL AUTO_INCREMENT,
    adminName varchar(100) NOT NULL,
    adminDepartment varchar(10),
    adminPnum varchar(20),
    adminEmail varchar(50),
    password varchar(255), -- The hashed password will be stored here
    token varchar(100), -- The token for additional security
    PRIMARY KEY (adminID)
);

CREATE TABLE status (
    statusID int NOT NULL,
    status_statement varchar(100) NOT NULL,
    PRIMARY KEY (statusID)
);

CREATE TABLE discounts (
    discountID int NOT NULL AUTO_INCREMENT,
    discountName varchar(50),
    discount_percent int, #eg:50%
    PRIMARY KEY (discountID)
);

CREATE TABLE products(
    productID int NOT NULL AUTO_INCREMENT,
    productName varchar(100) NOT NULL,
    product_mandate date,
    product_expdate date,
    productQuantity int,
    productStatus varchar(15), #available/unavailable/instock/outofstock
    sellerID int,
    discountID int,
    PRIMARY KEY (productID),
    FOREIGN KEY (sellerID) REFERENCES sellers(sellerID),
    FOREIGN KEY (discountID) REFERENCES discounts(discountID)
);
CREATE TABLE productVariant (
    variantID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    productID int NOT NULL,
    variantQuantity int,
    flavor VARCHAR(255), -- For food
    size VARCHAR(10),    -- For clothes
    color VARCHAR(255),  -- For clothes
    types VARCHAR(255),
    FOREIGN KEY (productID) REFERENCES products(productID)
);

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL DEFAULT curdate(),
  `orderQuantity` int(11) NOT NULL,
  `codDate` date NOT NULL,
  `totalPayment` decimal(7,2) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
   PRIMARY KEY (orderID),
   FOREIGN KEY (customerID) REFERENCES customers(customerID),
   FOREIGN KEY (statusID) REFERENCES status(statusID)
);

CREATE TABLE order_items (
    orderItemID INT(11) AUTO_INCREMENT PRIMARY KEY,
    orderID INT(11)NOT NULL,
    productID INT(11)NOT NULL,
    itemQuantity INT(11)NOT NULL,
    itemPrice DECIMAL(7, 2)NOT NULL,
    FOREIGN KEY (orderID) REFERENCES orders(orderID),
    FOREIGN KEY (productID) REFERENCES products(productID)
);
CREATE TABLE cart (
    cartID int AUTO_INCREMENT,
    customerID int,
    productID int,
    cartQuantity int,
    PRIMARY KEY (cartID),
    FOREIGN KEY (customerID) REFERENCES customers(customerID),
    FOREIGN KEY (productID) REFERENCES products(productID)
);

-- FSG (Faculty of Applied Science)
-- AS120 Diploma in Applied Science

-- FA (Faculty of Accountancy)
-- AC120 Diploma in Accounting Information System
-- AC110 Diploma in Accountancy 
-- AC151 Foundation in Accountacy (ACCA FIA)

-- KPPIM (College of Computing, Informatics and Media)
-- CS110 Diploma in Computer Science
-- CS230 Bachelor of Computer Science (Honours)
-- CS111 Diploma in Statistics
-- CS112 Diploma in Actuarial Science
-- CS143 Diploma in Mathematical Sciences

-- Gamma A
-- Gamma B
-- Beta 1 - 12
-- Alpha 1 - 9
-- Non-residents

-- INSERT INTO `products`(`productID`, `productName`, `product_mandate`, `product_expdate`, `productQuantity`, `productStatus`, `sellerID`, `discountID`, `prodImage`, `productAddDate`) 
-- VALUES ('','[Antabax Body Soap]','[2022-08-03]','[2024-02-05]',27,'[Available]',2022337985,1, LOAD_FILE('C:\xampp\htdocs\Projects\fyproject\pic\Products\antabax.jpeg'), '');

INSERT INTO `discounts` (`discountID`, `discountName`, `discount_percent`) 
VALUES ('5', 'DISCOUNT5%', '5'), ('10', 'DISCOUNT10%', '10'), 
('15', 'DISCOUNT15%', '15'), ('20', 'DISCOUNT20%', '20'), 
('25', 'DISCOUNT25%', '25'), ('30', 'DISCOUNT30%', '30'), 
('35', 'DISCOUNT35%', '35'), ('40', 'DISCOUNT40%', '40'), 
('45', 'DISCOUNT45%', '45'), ('50', 'DISCOUNT50%', '50');