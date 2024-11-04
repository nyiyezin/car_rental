# Car Rental System

A structured system to manage car rentals, customer bookings, and payments, allowing for seamless customer and admin interactions.

## Database Schema

### Tables

#### 1. `customer_details`

| Column Name         | Data Type                   | Constraints                                 |
| ------------------- | --------------------------- | ------------------------------------------- |
| id                  | INT                         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT       |
| identification_type | ENUM('passport', 'id_card') | NOT NULL                                    |
| identification_num  | VARCHAR(255)                 | NOT NULL, UNIQUE                            |
| name                | VARCHAR(255)                 | NOT NULL                                    |
| phone_number        | VARCHAR(255)                 | NULL (optional if email is provided)        |
| email               | VARCHAR(255)                 | NULL (optional if phone number is provided) |
| created_at          | TIMESTAMP                   | NOT NULL, DEFAULT CURRENT_TIMESTAMP         |
| updated_at          | TIMESTAMP                   | NULL, on update CURRENT_TIMESTAMP           |

#### 2. `car`

| Column Name         | Data Type      | Constraints                           |
| ------------------- | -------------- | ------------------------------------- |
| id                  | INT            | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| registration_number | VARCHAR(255)    | NOT NULL, UNIQUE                      |
| model_name          | VARCHAR(255)    | NOT NULL                              |
| model_year          | INT            | NOT NULL                              |
| total_kilometers    | FLOAT          | NOT NULL                              |
| luggage_capacity    | INT            | NOT NULL                              |
| passenger_capacity  | INT            | NOT NULL                              |
| daily_rate          | INT            | NOT NULL                              |
| late_fee_per_hour   | INT            | NOT NULL                              |
| availability_status | BOOL           | NOT NULL                              |
| rate_per_kilometer  | DECIMAL(10, 2) | NULL                                  |
| created_at          | TIMESTAMP      | NOT NULL, DEFAULT CURRENT_TIMESTAMP   |
| updated_at          | TIMESTAMP      | NULL, on update CURRENT_TIMESTAMP     |

#### 3. `driver_details`

| Column Name         | Data Type   | Constraints                           |
| ------------------- | ----------- | ------------------------------------- |
| id                  | INT         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| name                | VARCHAR(255) | NOT NULL                              |
| daily_rate          | INT         | NOT NULL                              |
| license_number      | VARCHAR(255) | NOT NULL, UNIQUE                      |
| phone_number        | VARCHAR(255) | NOT NULL                              |
| availability_status | BOOL        | NOT NULL                              |
| created_at          | TIMESTAMP   | NOT NULL, DEFAULT CURRENT_TIMESTAMP   |
| updated_at          | TIMESTAMP   | NULL, on update CURRENT_TIMESTAMP     |

#### 4. `booking_details`

| Column Name         | Data Type                                              | Constraints                                           |
| ------------------- | ------------------------------------------------------ | ----------------------------------------------------- |
| id                  | INT                                                    | NOT NULL, PRIMARY KEY, AUTO_INCREMENT                 |
| rental_start_time   | TIMESTAMP                                              | NOT NULL                                              |
| rental_end_time     | TIMESTAMP                                              | NOT NULL                                              |
| total_amount        | INT                                                    | NOT NULL                                              |
| status              | ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed') | NOT NULL                                              |
| driver_included     | BOOL                                                   | NOT NULL                                              |
| car_id              | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES car(id)              |
| customer_id         | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES customer_details(id) |
| actual_return_time  | TIMESTAMP                                              | NULL                                                  |
| pickup_location_id  | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES locations(id)        |
| dropoff_location_id | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES locations(id)        |
| created_at          | TIMESTAMP                                              | NOT NULL, DEFAULT CURRENT_TIMESTAMP                   |
| updated_at          | TIMESTAMP                                              | NULL, on update CURRENT_TIMESTAMP                     |

#### 5. `locations`

| Column Name | Data Type      | Constraints                           |
| ----------- | -------------- | ------------------------------------- |
| id          | INT            | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| address     | VARCHAR(255)   | NOT NULL                              |
| latitude    | DECIMAL(10, 8) | NOT NULL                              |
| longitude   | DECIMAL(11, 8) | NOT NULL                              |

#### 6. `payment_details`

| Column Name  | Data Type   | Constraints                                          |
| ------------ | ----------- | ---------------------------------------------------- |
| id           | INT         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT                |
| bill_date    | DATE        | NOT NULL                                             |
| bill_status  | VARCHAR(255) | NOT NULL                                             |
| paid_amount  | INT         | NOT NULL                                             |
| total_amount | INT         | NOT NULL                                             |
| tax_amount   | INT         | NOT NULL                                             |
| booking_id   | INT         | NOT NULL, FOREIGN KEY REFERENCES booking_details(id) |
| late_fee     | INT         | NULL                                                 |
| created_at   | TIMESTAMP   | NOT NULL, DEFAULT CURRENT_TIMESTAMP                  |
| updated_at   | TIMESTAMP   | NULL, on update CURRENT_TIMESTAMP                    |

#### 7. `driver_car_history`

| Column Name | Data Type                   | Constraints                                         |
| ----------- | --------------------------- | --------------------------------------------------- |
| id          | INT                         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT               |
| driver_id   | INT                         | NOT NULL, FOREIGN KEY REFERENCES driver_details(id) |
| car_id      | INT                         | NOT NULL, FOREIGN KEY REFERENCES car(id)            |
| booking_id  | INT                         | NULL, FOREIGN KEY REFERENCES booking_details(id)    |
| driver_type | ENUM('customer', 'company') | NOT NULL, COMMENT 'Driver type'                     |
| created_at  | TIMESTAMP                   | NOT NULL, DEFAULT CURRENT_TIMESTAMP                 |
| updated_at  | TIMESTAMP                   | NULL, on update CURRENT_TIMESTAMP                   |

#### 8. `users`

| Column Name | Data Type    | Constraints                                |
| ----------- | ------------ | ------------------------------------------ |
| id          | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT      |
| username    | VARCHAR(255)  | NOT NULL, UNIQUE                           |
| password    | VARCHAR(255) | NOT NULL                                   |
| email       | VARCHAR(255)  | NOT NULL, UNIQUE                           |
| role_id     | INT          | NOT NULL, FOREIGN KEY REFERENCES roles(id) |
| created_at  | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP        |
| updated_at  | TIMESTAMP    | NULL, on update CURRENT_TIMESTAMP          |

#### 9. `booking_confirmations`

| Column Name       | Data Type | Constraints                                          |
| ----------------- | --------- | ---------------------------------------------------- |
| id                | INT       | NOT NULL, PRIMARY KEY, AUTO_INCREMENT                |
| booking_id        | INT       | NOT NULL, FOREIGN KEY REFERENCES booking_details(id) |
| admin_user_id     | INT       | NOT NULL, FOREIGN KEY REFERENCES users(id)           |
| confirmation_time | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP                  |
| notes             | TEXT      | NULL                                                 |

#### 10. `roles`

| Column Name | Data Type   | Constraints                           |
| ----------- | ----------- | ------------------------------------- |
| id          | INT         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| role_name   | VARCHAR(255) | NOT NULL, UNIQUE                      |

---

## System Workflow

### 1. Customer Inquiries

-   Customers search for cars based on rental dates.
-   Available cars are retrieved from the `car` table.

### 2. Customer Registration

-   Information like identification, contact details, etc., is stored in `customer_details`.

### 3. Booking Process

-   Customers select a car, specify rental dates and locations.
-   Total amount is calculated and recorded in `booking_details`.

### 4. Driver Assignment (Optional)

-   If needed, an available driver is assigned and fee added to total.

### 5. Payment Process

-   Payment is processed, and `payment_details` is updated with payment status.

### 6. Booking Confirmation

-   Admin confirms booking, recorded in `booking_confirmations`.

### 7. Car Rental Period

-   Customer picks up and returns car as per scheduled times and locations.

### 8. Post-Rental Processing

-   Late fees, damages, and return data are recorded as needed.

### 9. Admin Management

-   Admins manage bookings, view records, and handle operations through the admin panel.

---
