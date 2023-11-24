use shopmed;

-- Insert data into User table
INSERT INTO User (id, fullName, email, address, phone) VALUES
                                                           (1000001, 'Dr. John Smith', 'john.smith@example.com', '123 Medical St', '555-1234'),
                                                           (1000002, 'Dr. Jane Doe', 'jane.doe@example.com', '456 Health Ave', '555-5678'),
                                                           (1000003, 'Alice Johnson', 'alice.johnson@example.com', '789 Wellness Blvd', '555-9012'),
                                                           (1000004, 'Bob Williams', 'bob.williams@example.com', '321 Pharmacy Lane', '555-3456'),
                                                           (1000005, 'Catherine Brown', 'catherine.brown@example.com', '654 Healthcare Rd', '555-7890');

-- Insert data into AuthInfo table
INSERT INTO AuthInfo (id, username, passwordHash, authority, userId) VALUES
                                                                         (1000001, 'dr_john', 'hashed_password', 1, 1000001),
                                                                         (1000002, 'dr_jane', 'hashed_password', 1, 1000002),
                                                                         (1000003, 'alice', 'hashed_password', 2, 1000003),
                                                                         (1000004, 'bob', 'hashed_password', 2, 1000004),
                                                                         (1000005, 'catherine', 'hashed_password', 2, 1000005);

-- Insert data into ProductCategory table
INSERT INTO ProductCategory (id, name) VALUES
                                           (1000001, 'Prescription Medications'),
                                           (1000002, 'Over-the-Counter Medications'),
                                           (1000003, 'Medical Supplies'),
                                           (1000004, 'Personal Care');

-- Insert data into Product table
INSERT INTO Product (id, name, description, categoryId, inStockCount, price) VALUES
                                                                                 (1000001, 'Antibiotic - Amoxicillin', 'Commonly used for bacterial infections', 1000001, 50, 14.99),
                                                                                 (1000002, 'Pain Reliever - Ibuprofen', 'Reduces pain and inflammation', 1000002, 100, 7.99),
                                                                                 (1000003, 'Blood Glucose Monitor', 'For monitoring blood sugar levels', 1000003, 20, 29.99),
                                                                                 (1000004, 'First Aid Kit', 'Essential supplies for emergencies', 1000003, 50, 49.99),
                                                                                 (1000005, 'Dental Floss', 'For effective oral hygiene', 1000004, 200, 2.99);

-- Insert data into ServiceCategory table
INSERT INTO ServiceCategory (id, name) VALUES
                                           (1000001, 'Pharmacy Consultation'),
                                           (1000002, 'Home Health Services'),
                                           (1000003, 'Health Check-up');

-- Insert data into Service table
INSERT INTO Service (id, name, description, categoryId, price) VALUES
                                                                   (1000001, 'Medication Consultation', 'Personalized advice on medications', 1000001, 19.99),
                                                                   (1000002, 'Home Medication Delivery', 'Convenient delivery to your doorstep', 1000002, 5.99),
                                                                   (1000003, 'Blood Pressure Check-up', 'Quick and accurate blood pressure measurement', 1000003, 9.99);

-- Insert data into ProductOrder table
INSERT INTO ProductOrder (id, userId, createdAt, isPaid, isDelivered, status, note) VALUES
                                                                                        (1000001, 1000001, '2023-01-01 12:00:00', 1, 0, 'Processing', 'Waiting for payment confirmation'),
                                                                                        (1000002, 1000002, '2023-01-02 14:30:00', 1, 1, 'Delivered', 'Left at the doorstep'),
                                                                                        (1000003, 1000003, '2023-01-03 15:45:00', 1, 1, 'Delivered', 'Signed by Alice Johnson'),
                                                                                        (1000004, 1000004, '2023-01-04 10:15:00', 0, 0, 'Pending', 'Payment not received'),
                                                                                        (1000005, 1000005, '2023-01-05 09:30:00', 1, 0, 'Processing', 'Preparing for shipment');

-- Insert data into CartItem table
INSERT INTO CartItem (id, productId, userId, createdAt, quantity, isActive) VALUES
                                                                                (1000001, 1000001, 1000001, '2023-01-01 10:00:00', 2, 1),
                                                                                (1000002, 1000002, 1000002, '2023-01-02 13:45:00', 1, 1),
                                                                                (1000003, 1000003, 1000003, '2023-01-03 15:00:00', 3, 1),
                                                                                (1000004, 1000004, 1000004, '2023-01-04 11:30:00', 1, 1),
                                                                                (1000005, 1000005, 1000005, '2023-01-05 08:45:00', 2, 1);

-- Insert data into OrderItem table
INSERT INTO OrderItem (id, productId, orderId, price, quantity) VALUES
                                                                    (1000001, 1000001, 1000001, 14.99, 2),
                                                                    (1000002, 1000002, 1000002, 7.99, 1),
                                                                    (1000003, 1000003, 1000003, 29.99, 3),
                                                                    (1000004, 1000004, 1000004, 49.99, 1),
                                                                    (1000005, 1000005, 1000005, 2.99, 2);

-- Insert data into ProductReview table
INSERT INTO ProductReview (id, content, reviewedAt, rating, userId, productId) VALUES
                                                                                   (1000001, 'Effective antibiotic!', '2023-01-03 15:00:00', 5, 1000001, 1000001),
                                                                                   (1000002, 'Reliable pain relief!', '2023-01-04 11:30:00', 4, 1000002, 1000002),
                                                                                   (1000003, 'Accurate blood pressure readings!', '2023-01-05 10:15:00', 5, 1000003, 1000003),
                                                                                   (1000004, 'Great for wound care!', '2023-01-06 14:00:00', 4, 1000004, 1000004),
                                                                                   (1000005, 'Fresh breath every time!', '2023-01-07 09:45:00', 5, 1000005, 1000005);

-- Insert data into Article table
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

--- additional data for cart items
-- Insert additional data into CartItem table
INSERT INTO CartItem (id, productId, userId, createdAt, quantity, isActive) VALUES
                                                                                (1000006, 1000003, 1000001, '2023-01-06 11:30:00', 2, 1),
                                                                                (1000007, 1000004, 1000002, '2023-01-07 13:45:00', 1, 1),
                                                                                (1000008, 1000005, 1000003, '2023-01-08 15:00:00', 3, 1),
                                                                                (1000009, 1000001, 1000004, '2023-01-09 09:30:00', 1, 1),
                                                                                (1000010, 1000002, 1000005, '2023-01-10 08:45:00', 2, 1),
                                                                                (1000011, 1000004, 1000001, '2023-01-11 14:30:00', 1, 1),
                                                                                (1000012, 1000005, 1000002, '2023-01-12 12:15:00', 2, 1),
                                                                                (1000013, 1000001, 1000003, '2023-01-13 10:00:00', 1, 1),
                                                                                (1000014, 1000002, 1000004, '2023-01-14 11:30:00', 3, 1),
                                                                                (1000015, 1000003, 1000005, '2023-01-15 09:45:00', 2, 1),
                                                                                (1000016, 1000004, 1000001, '2023-01-16 14:00:00', 1, 1),
                                                                                (1000017, 1000005, 1000002, '2023-01-17 12:30:00', 2, 1),
                                                                                (1000018, 1000001, 1000003, '2023-01-18 11:15:00', 1, 1),
                                                                                (1000019, 1000002, 1000004, '2023-01-19 10:30:00', 3, 1),
                                                                                (1000020, 1000003, 1000005, '2023-01-20 08:00:00', 2, 1);
