-- Insert 20 products into the Product table
INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Anti-Gravity Spell', 100, 'Defy the laws of physics and float above your enemies.', 'https://github.com/user-attachments/assets/d15062ac-561a-412f-85f2-24d2ddd600ce', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Phoenix Rebirth Spell', 75, 'Revive from ashes with blazing power and renewed strength.', 'https://github.com/user-attachments/assets/06aa2dac-687e-49a0-bc21-5b63c503229f', 59.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Time Warp Spell', 80, 'Bend time to your will slow, rewind, or accelerate events.', 'https://github.com/user-attachments/assets/5d55ad26-ce64-46a6-b85a-882b491ec8ab', 54.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Mystery Spell', 120, 'An unpredictable spell that delivers a random magical effect.', 'https://github.com/user-attachments/assets/27b87499-d82b-4aa2-9836-8b92530ef6eb', 29.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Impregnation Spell', 20, 'A powerful and ancient ritual for magical conception.', 'https://github.com/user-attachments/assets/c36dee98-5926-495b-ab23-fa2649afd678', 199.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Mind Reading Spell', 90, 'Peer into the minds of your foes and learn their secrets.', 'https://github.com/user-attachments/assets/0ae2c068-f88d-4207-9533-15343f48d3bf', 44.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Truth Spell', 85, 'Compel anyone to speak only the truth.', 'https://github.com/user-attachments/assets/4e6bfb28-c287-452e-8a38-7126c3c8536b', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Invisibility Spell', 70, 'Vanish from sight and evade detection.', 'https://github.com/user-attachments/assets/c0fcfd96-63d8-4f58-b35d-b2917422c560', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Fire Spell', 110, 'Unleash a burst of flames to scorch your enemies.', 'https://github.com/user-attachments/assets/e1ce2884-4805-4c3c-b3ee-f3c9e083f4d2', 34.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Speed Spell', 95, 'Boost your movement to lightning-fast speeds.', 'https://github.com/user-attachments/assets/b162898e-4d21-425d-8f1d-bb02e3194147', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Focus Spell', 150, 'Sharpen your concentration and eliminate mental distractions instantly.', 'https://github.com/user-attachments/assets/81c03a63-0191-4774-93d8-9f24d682f277', 24.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Confidence Spell', 140, 'Boost your self esteem and speak with conviction in any situation.', 'https://github.com/user-attachments/assets/aa489275-47ff-48f4-bcc5-f2d8f861ee27', 29.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Sleep Spell', 200, 'Fall asleep quickly and deeply for the ultimate rest.', 'https://github.com/user-attachments/assets/c5672280-881b-429f-b716-403929720202', 19.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Luck Shift Spell', 130, 'Subtly adjust odds in your favor in everyday life.', 'https://github.com/user-attachments/assets/07cd3226-7e08-4859-904c-e7ca1e6eb67c', 39.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Pain Dissolve Spell', 160, 'Melt away physical or emotional discomfort with ease.', 'https://github.com/user-attachments/assets/c560d492-3203-47a1-885a-913fdebd7eaf', 34.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Memory Recall Spell', 120, 'Access any memory with vivid clarity and detail.', 'https://github.com/user-attachments/assets/5f099070-bc1b-4f69-b901-5e61365c0b4a', 44.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Charisma Spell', 110, 'Enhance your social charm and persuasive presence.', 'https://github.com/user-attachments/assets/ef34fd20-3cd1-4bcd-af0b-7a2efc7f9933', 49.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Clarity Spell', 145, 'Gain instant mental clarity and emotional detachment.', 'https://github.com/user-attachments/assets/702e7dd2-1e0e-45c0-ab60-d86232a5ae4f', 27.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Habit Break Spell', 100, 'Break destructive habits effortlessly with lasting impact.', 'https://github.com/user-attachments/assets/af6f59ff-8586-42cb-8d3d-b062e848f537', 59.99);

INSERT INTO Product (Name, Inventory, Description, ImageUrl, Price) VALUES
('Time Dilation Spell', 95, 'Experience moments in slow motion to act with precision.', 'https://github.com/user-attachments/assets/071263e2-a459-4c26-be17-4a549e2be29d', 54.99);

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
INSERT INTO `Order` (UserId, Status, Notes, TotalPrice) VALUES
(1, 'Shipped', 'Deliver to the office.', 99.98);

INSERT INTO `Order` (UserId, Status, Notes, TotalPrice) VALUES
(2, 'Processing', 'Handle with care.', 59.99);

INSERT INTO `Order` (UserId, Status, Notes, TotalPrice) VALUES
(3, 'Delivered', 'Leave at the front door.', 164.97);

INSERT INTO `Order` (UserId, Status, Notes, TotalPrice) VALUES
(4, 'Pending', 'Awaiting confirmation.', 29.99);

INSERT INTO `Order` (UserId, Status, Notes, TotalPrice) VALUES
(5, 'Pending', 'Awaiting confirmation.', 399.98);

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