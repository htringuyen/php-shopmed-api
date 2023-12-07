use shopmed;

-- Insert data into User table
INSERT INTO User (id, fullName, email, address, phone) VALUES
    (1000001, 'Dr. John Smith', 'john.smith@example.com', '123 Medical St', '555-1234'),
    (1000002, 'Dr. Jane Doe', 'jane.doe@example.com', '456 Health Ave', '555-5678'),
    (1000003, 'Alice Johnson', 'alice.johnson@example.com', '789 Wellness Blvd', '555-9012'),
    (1000004, 'Bob Williams', 'bob.williams@example.com', '321 Pharmacy Lane', '555-3456'),
    (1000005, 'Catherine Brown', 'catherine.brown@example.com', '654 Healthcare Rd', '555-7890'),
    (1000006, 'David Nguyen', 'david.nguyen@example.com', '101 Wall St', '555-1122'), -- Vietnamese address
    (1000007, 'Eva Tran', 'eva.tran@example.com', '202 Main St, Miami', '555-3344'),       -- Vietnamese address
    (1000008, 'Francisco Le', 'francisco.le@example.com', '303 Medical St', '555-5566'), -- Vietnamese address
    (1000009, 'Giselle Pham', 'giselle.pham@example.com', '404 Hospital St', '555-7788'), -- Vietnamese address
    (1000010, 'Hoa Luu', 'hoa.luu@example.com', '505 Pharmacy St', '555-9900');          -- Vietnamese address

-- Insert data into AuthInfo table
INSERT INTO AuthInfo (id, username, passwordHash, authority, userId) VALUES
    (1000001, 'dr_john', 'hashed_password', 1, 1000001),
    (1000002, 'dr_jane', 'hashed_password', 1, 1000002),
    (1000003, 'alice', 'hashed_password', 2, 1000003),
    (1000004, 'bob', 'hashed_password', 2, 1000004),
    (1000005, 'catherine', 'hashed_password', 2, 1000005),
    (1000006, 'david', 'hashed_password', 2, 1000006),
    (1000007, 'eva', 'hashed_password', 2, 1000007),
    (1000008, 'francisco', 'hashed_password', 2, 1000008),
    (1000009, 'giselle', 'hashed_password', 2, 1000009),
    (1000010, 'hoa', 'hashed_password', 2, 1000010);

-- Insert data into ProductCategory table
INSERT INTO ProductCategory (id, name) VALUES
    (1000001, 'Thuốc Prescription'),      -- Vietnamese name
    (1000002, 'Thuốc không cần đơn'),      -- Vietnamese name
    (1000003, 'Dụng cụ y tế'),             -- Vietnamese name
    (1000004, 'Chăm sóc cá nhân');         -- Vietnamese name

-- Insert data into Product table
INSERT INTO Product (id, name, description, categoryId, inStockCount, price) VALUES
    (1000001, 'Kháng sinh', 'Thường được sử dụng cho các nhiễm khuẩn', 1000001, 50, 14.99),
    (1000002, 'Thuốc giảm đau', 'Giảm đau và chống viêm', 1000002, 100, 7.99),
    (1000003, 'Máy đo đường huyết', 'Dùng để theo dõi đường huyết', 1000003, 20, 29.99),
    (1000004, 'Bộ kit cấp cứu', 'Cung cấp đồ dùng cần thiết cho trường hợp khẩn cấp', 1000003, 50, 49.99),
    (1000005, 'Chỉ nha khoa', 'Giữ sạch răng hiệu quả', 1000004, 200, 2.99),
    (1000006, 'Vitamin C', 'Tăng cường sức khỏe', 1000001, 80, 9.99),
    (1000007, 'Nước sát trùng', 'Diệt khuẩn và bảo vệ', 1000002, 120, 4.99),
    (1000008, 'Máy đo huyết áp', 'Đo huyết áp nhanh chóng và chính xác', 1000003, 30, 39.99),
    (1000009, 'Dầu gội chống rụng tóc', 'Dưỡng tóc và ngăn rụng tóc', 1000004, 60, 12.99),
    (1000010, 'Khẩu trang y tế', 'Bảo vệ khỏi vi khuẩn và bụi', 1000001, 100, 3.99);

INSERT INTO ServiceCategory (id, name) VALUES
                                           (1000001, 'Pharmacy Consultation'),
                                           (1000002, 'Home Health Services'),
                                           (1000003, 'Health Check-up');

INSERT INTO Service (id, name, description, categoryId, price) VALUES
                                                                   (1000001, 'Medication Consultation', 'Personalized advice on medications', 1000001, 19.99),
                                                                   (1000002, 'Home Medication Delivery', 'Convenient delivery to your doorstep', 1000002, 5.99),
                                                                   (1000003, 'Blood Pressure Check-up', 'Quick and accurate blood pressure measurement', 1000003, 9.99);

INSERT INTO ProductOrder (id, userId, createdAt, isPaid, isDelivered, status, note) VALUES
                                                                                        (1000001, 1000001, '2023-01-01 12:00:00', 1, 0, 'Processing', 'Waiting for payment confirmation'),
                                                                                        (1000002, 1000002, '2023-01-02 14:30:00', 1, 1, 'Delivered', 'Left at the doorstep'),
                                                                                        (1000003, 1000003, '2023-01-03 15:45:00', 1, 1, 'Delivered', 'Signed by Alice Johnson'),
                                                                                        (1000004, 1000004, '2023-01-04 10:15:00', 0, 0, 'Pending', 'Payment not received'),
                                                                                        (1000005, 1000005, '2023-01-05 09:30:00', 1, 0, 'Processing', 'Preparing for shipment');


INSERT INTO CartItem (id, productId, userId, createdAt, quantity, isActive) VALUES
    (1000001, 1000001, 1000001, '2023-01-01 10:00:00', 2, 1),
    (1000002, 1000002, 1000002, '2023-01-02 13:45:00', 1, 1),
    (1000003, 1000003, 1000003, '2023-01-03 15:00:00', 3, 1),
    (1000004, 1000004, 1000004, '2023-01-04 11:30:00', 1, 1),
    (1000005, 1000005, 1000005, '2023-01-05 08:45:00', 2, 1),
    (1000006, 1000006, 1000006, '2023-01-06 11:30:00', 2, 1),
    (1000007, 1000007, 1000007, '2023-01-07 13:45:00', 1, 1),
    (1000008, 1000008, 1000008, '2023-01-08 15:00:00', 3, 1),
    (1000009, 1000009, 1000009, '2023-01-09 11:30:00', 1, 1),
    (1000010, 1000010, 1000010, '2023-01-10 08:45:00', 2, 1);


INSERT INTO OrderItem (id, productId, orderId, price, quantity) VALUES
                                                                    (1000001, 1000001, 1000001, 14.99, 2),
                                                                    (1000002, 1000002, 1000002, 7.99, 1),
                                                                    (1000003, 1000003, 1000003, 29.99, 3),
                                                                    (1000004, 1000004, 1000004, 49.99, 1),
                                                                    (1000005, 1000005, 1000005, 2.99, 2);


INSERT INTO Article (id, title, content, publishedOn, userId) VALUES
                                                                  (1000001, 'Healthy Living Tips', 'Discover ways to improve your health and well-being.', '2023-01-01 08:00:00', 1000001),
                                                                  (1000002, 'Common Cold Remedies', 'Learn about effective remedies to relieve common cold symptoms.', '2023-01-02 09:30:00', 1000002),
                                                                  (1000003, 'Stress Management Techniques', 'Explore techniques to manage stress and maintain mental well-being.', '2023-01-03 10:45:00', 1000003),
                                                                  (1000004, 'Importance of Regular Exercise', 'Understand the benefits of regular exercise for overall health.', '2023-01-04 12:15:00', 1000004),
                                                                  (1000005, 'Dental Care Tips', 'Tips for maintaining good oral hygiene and preventing dental issues.', '2023-01-05 14:00:00', 1000005);

-- Insert data into ArticleComment table
INSERT INTO ArticleComment (id, content, commentedAt, userId, articleId) VALUES
                                                                             (1000001, 'Great article! Very informative.', '2023-01-01 09:00:00', 1000002, 1000001),
                                                                             (1000002, 'I tried these remedies, and they worked wonders!', '2023-01-02 10:00:00', 1000003, 1000002),
                                                                             (1000003, 'Thanks for sharing these helpful techniques!', '2023-01-03 11:15:00', 1000004, 1000003),
                                                                             (1000004, 'Exercise has improved my health significantly.', '2023-01-04 13:00:00', 1000005, 1000004),
                                                                             (1000005, 'Excellent tips for maintaining oral health.', '2023-01-05 15:30:00', 1000001, 1000005);
