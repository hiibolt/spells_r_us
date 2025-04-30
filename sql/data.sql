-- Insert 20 products into the Product table
INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Anti-Gravity Spell', 100, 'Defy the laws of physics and float above your enemies.', 'https://github.com/user-attachments/assets/952a85fe-3186-4c0e-9c36-db6cf5a7d02d', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Phoenix Rebirth Spell', 75, 'Revive from ashes with blazing power and renewed strength.', 'https://github.com/user-attachments/assets/9ae818d7-d23a-4307-ab70-da4c58b2e3a4', 59.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Time Warp Spell', 80, 'Bend time to your will slow, rewind, or accelerate events.', 'https://github.com/user-attachments/assets/32b82d4c-64d7-4da6-bbf1-5c74d7364952', 54.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Mystery Spell', 120, 'An unpredictable spell that delivers a random magical effect.', 'https://github.com/user-attachments/assets/a8ee6279-723c-495e-b4b0-07f20bafce04', 29.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Impregnation Spell', 20, 'A powerful and ancient ritual for magical conception.', 'https://github.com/user-attachments/assets/c3860e69-c591-4619-88cf-3a85aac0ca8d', 199.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Mind Reading Spell', 90, 'Peer into the minds of your foes and learn their secrets.', 'https://github.com/user-attachments/assets/90ee8247-faac-4437-a0ee-bac2bdb1818e', 44.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Truth Spell', 85, 'Compel anyone to speak only the truth.', 'https://github.com/user-attachments/assets/110278a3-90d7-4db3-9a0d-1b01202dfe27', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Invisibility Spell', 70, 'Vanish from sight and evade detection.', 'https://github.com/user-attachments/assets/0d162845-49e0-436f-b963-9eb4adf0b5fa', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Fire Spell', 110, 'Unleash a burst of flames to scorch your enemies.', 'https://github.com/user-attachments/assets/cb20ecea-082b-4ecc-bc70-299499cea297', 34.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Speed Spell', 95, 'Boost your movement to lightning-fast speeds.', 'https://github.com/user-attachments/assets/78b63b11-fb8e-46fc-bf84-aa0a62358a9a', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Focus Spell', 150, 'Sharpen your concentration and eliminate mental distractions instantly.', 'https://github.com/user-attachments/assets/a34872c0-2786-46e2-826b-0fe5e9ff9b7c', 24.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Confidence Spell', 140, 'Boost your self esteem and speak with conviction in any situation.', 'https://github.com/user-attachments/assets/425d3db0-98f0-4e31-8688-07a987907280', 29.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Sleep Spell', 200, 'Fall asleep quickly and deeply for the ultimate rest.', 'https://github.com/user-attachments/assets/fdaa27fe-7ea5-40a8-877d-ed3b0ca2244d', 19.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Luck Shift Spell', 130, 'Subtly adjust odds in your favor in everyday life.', 'https://github.com/user-attachments/assets/e52b31b9-25fb-4e3a-b750-895e6bb3c38a', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Pain Dissolve Spell', 160, 'Melt away physical or emotional discomfort with ease.', 'https://github.com/user-attachments/assets/4adb561c-3219-406f-8700-c3a45ab1317e', 34.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Memory Recall Spell', 120, 'Access any memory with vivid clarity and detail.', 'https://github.com/user-attachments/assets/1b3f8d60-0a46-422f-9700-60cc2e991933', 44.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Charisma Spell', 110, 'Enhance your social charm and persuasive presence.', 'https://github.com/user-attachments/assets/a7834ffc-d03b-4c4f-9feb-0fc13f7be4fa', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Clarity Spell', 145, 'Gain instant mental clarity and emotional detachment.', 'https://github.com/user-attachments/assets/19a19362-81d7-420d-9e8b-a00b5823898d', 27.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Habit Break Spell', 100, 'Break destructive habits effortlessly with lasting impact.', 'https://github.com/user-attachments/assets/e2947403-584f-4a54-8a72-25c6bbb1209d', 59.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Time Dilation Spell', 95, 'Experience moments in slow motion to act with precision.', 'https://github.com/user-attachments/assets/c89a2f17-29f3-4ae0-8b32-fbf2cbfe3f84', 54.99);

-- Insert 5 users into the User table
INSERT INTO User (Email, Password, IsEmployee) VALUES
('shaivil@niu.edu', 'password123', True);

INSERT INTO User (Email, Password, IsEmployee) VALUES
('alex@niu.edu', 'password123', TRUE);

INSERT INTO User (Email, Password, IsEmployee) VALUES
('john@niu.edu', 'password123', TRUE);

INSERT INTO User (Email, Password, IsEmployee) VALUES
('antonio@niu.edu', 'password123', TRUE);

INSERT INTO User (Email, Password, IsEmployee) VALUES
('sarahjones123@niu.edu', 'VerySecurePassword!!!', FALSE);

-- Insert atleast 1 order per user into the Order table
INSERT INTO `Order` (UserId, Status, Notes, ShippingAddress, TotalPrice, OrderedAt) VALUES
(1, 'Shipped', 'Deliver to the office.', '1245 Stadium Dr S, DeKalb, IL 60115', 99.98, '2024-12-01 10:00:00');

INSERT INTO `Order` (UserId, Status, Notes, ShippingAddress, TotalPrice, OrderedAt) VALUES
(2, 'Pending', 'Handle with care.', '1245 Stadium Dr S, DeKalb, IL 60115', 59.99, '2025-01-15 14:23:00');

INSERT INTO `Order` (UserId, Status, Notes, ShippingAddress, TotalPrice, OrderedAt) VALUES
(3, 'Pending', 'Leave at the front door.', '1245 Stadium Dr S, DeKalb, IL 60115', 164.97, '2025-02-10 09:42:00');

INSERT INTO `Order` (UserId, Status, Notes, ShippingAddress, TotalPrice, OrderedAt) VALUES
(4, 'Cancelled', 'Cancelled by customer.', '1245 Stadium Dr S, DeKalb, IL 60115', 29.99, '2025-03-01 17:00:00');

INSERT INTO `Order` (UserId, Status, Notes, ShippingAddress, TotalPrice, OrderedAt) VALUES
(5, 'Processing', 'Awaiting confirmation.', '1245 Stadium Dr S, DeKalb, IL 60115', 399.98, '2025-04-05 08:15:00');

-- Inser the products into the UserPlacesOrder table
INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity) VALUES
(1, 1, 2);

INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity) VALUES
(2, 2, 1);

INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity) VALUES
(3, 3, 3);

INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity) VALUES
(4, 4, 1);

INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity) VALUES
(5, 5, 2);

-- Insert values into the UserPlacesOrder table
INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (1, 1);
INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (2, 2);
INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (3, 3);
INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (4, 4);
INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (5, 5);

