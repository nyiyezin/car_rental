# Car Rental System

## Database Schema

### Tables

#### 1. `customers`

| Column Name          | Data Type    | Constraints                                 |
| -------------------- | ------------ | ------------------------------------------- |
| `id`                 | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT       |
| `identification_num` | VARCHAR(255) | NOT NULL, UNIQUE                            |
| `name`               | VARCHAR(255) | NOT NULL                                    |
| `phone_number`       | VARCHAR(255) | NULL (optional if email is provided)        |
| `email`              | VARCHAR(255) | NULL (optional if phone number is provided) |
| `created_at`         | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP         |
| `updated_at`         | TIMESTAMP    | NULL, on update CURRENT_TIMESTAMP           |
| `deleted_at`         | TIMESTAMP    | NULL                                        |

#### 2. `car`

| Column Name           | Data Type      | Constraints                           |
| --------------------- | -------------- | ------------------------------------- |
| `id`                  | INT            | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| `registration_number` | VARCHAR(255)   | NOT NULL, UNIQUE                      |
| `model_name`          | VARCHAR(255)   | NOT NULL                              |
| `model_year`          | INT            | NOT NULL                              |
| `total_kilometers`    | FLOAT          | NOT NULL                              |
| `luggage_capacity`    | INT            | NOT NULL                              |
| `passenger_capacity`  | INT            | NOT NULL                              |
| `daily_rate`          | INT            | NOT NULL                              |
| `late_fee_per_hour`   | INT            | NOT NULL                              |
| `rate_per_kilometer`  | DECIMAL(10, 2) | NULL                                  |
| `is_available`        | BOOL           | NOT NULL                              |
| `created_at`          | TIMESTAMP      | NOT NULL, DEFAULT CURRENT_TIMESTAMP   |
| `updated_at`          | TIMESTAMP      | NULL, on update CURRENT_TIMESTAMP     |
| `deleted_at`          | TIMESTAMP      | NULL                                  |

#### 3. `drivers`

| Column Name      | Data Type    | Constraints                           |
| ---------------- | ------------ | ------------------------------------- |
| `id`             | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| `name`           | VARCHAR(255) | NOT NULL                              |
| `daily_rate`     | INT          | NOT NULL                              |
| `license_number` | VARCHAR(255) | NOT NULL, UNIQUE                      |
| `phone_number`   | VARCHAR(255) | NOT NULL                              |
| `is_available`   | BOOL         | NOT NULL                              |
| `created_at`     | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP   |
| `updated_at`     | TIMESTAMP    | NULL, on update CURRENT_TIMESTAMP     |
| `deleted_at`     | TIMESTAMP    | NULL                                  |

#### 4. `bookings`

| Column Name           | Data Type                                              | Constraints                                      |
| --------------------- | ------------------------------------------------------ | ------------------------------------------------ |
| `id`                  | INT                                                    | NOT NULL, PRIMARY KEY, AUTO_INCREMENT            |
| `rental_start_date`   | TIMESTAMP                                              | NOT NULL                                         |
| `rental_end_date`     | TIMESTAMP                                              | NOT NULL                                         |
| `status`              | ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed') | NOT NULL                                         |
| `is_driver_included`  | BOOL                                                   | NOT NULL                                         |
| `car_id`              | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES `car(id)`       |
| `customer_id`         | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES `customers(id)` |
| `payment_id`          | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES `payments(id)`  |
| `pickup_location_id`  | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES `locations(id)` |
| `dropoff_location_id` | INT                                                    | NOT NULL, FOREIGN KEY REFERENCES `locations(id)` |
| `created_at`          | TIMESTAMP                                              | NOT NULL, DEFAULT CURRENT_TIMESTAMP              |
| `updated_at`          | TIMESTAMP                                              | NULL, on update CURRENT_TIMESTAMP                |
| `deleted_at`          | TIMESTAMP                                              | NULL                                             |

#### 5. `locations`

| Column Name  | Data Type      | Constraints                           |
| ------------ | -------------- | ------------------------------------- |
| `id`         | INT            | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| `address`    | VARCHAR(255)   | NOT NULL                              |
| `latitude`   | DECIMAL(10, 8) | NOT NULL                              |
| `longitude`  | DECIMAL(11, 8) | NOT NULL                              |
| `deleted_at` | TIMESTAMP      | NULL                                  |

#### 6. `payments`

| Column Name      | Data Type    | Constraints                           |
| ---------------- | ------------ | ------------------------------------- |
| `id`             | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| `payment_status` | VARCHAR(255) | NOT NULL                              |
| `total_amount`   | INT          | NOT NULL                              |
| `tax_amount`     | INT          | NOT NULL                              |
| `created_at`     | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP   |
| `updated_at`     | TIMESTAMP    | NULL, on update CURRENT_TIMESTAMP     |
| `deleted_at`     | TIMESTAMP    | NULL                                  |

#### 7. `driver_car_history`

| Column Name   | Data Type                   | Constraints                                    |
| ------------- | --------------------------- | ---------------------------------------------- |
| `id`          | INT                         | NOT NULL, PRIMARY KEY, AUTO_INCREMENT          |
| `driver_id`   | INT                         | NOT NULL, FOREIGN KEY REFERENCES `drivers(id)` |
| `car_id`      | INT                         | NOT NULL, FOREIGN KEY REFERENCES `car(id)`     |
| `booking_id`  | INT                         | NULL, FOREIGN KEY REFERENCES `bookings(id)`    |
| `driver_type` | ENUM('customer', 'company') | NOT NULL, COMMENT 'Driver type'                |
| `created_at`  | TIMESTAMP                   | NOT NULL, DEFAULT CURRENT_TIMESTAMP            |
| `updated_at`  | TIMESTAMP                   | NULL, on update CURRENT_TIMESTAMP              |
| `deleted_at`  | TIMESTAMP                   | NULL                                           |

#### 8. `users`

| Column Name  | Data Type    | Constraints                                  |
| ------------ | ------------ | -------------------------------------------- |
| `id`         | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT        |
| `name`       | VARCHAR(255) | NOT NULL                                     |
| `username`   | VARCHAR(255) | NOT NULL, UNIQUE                             |
| `password`   | VARCHAR(255) | NOT NULL                                     |
| `email`      | VARCHAR(255) | NOT NULL, UNIQUE                             |
| `role_id`    | INT          | NOT NULL, FOREIGN KEY REFERENCES `roles(id)` |
| `created_at` | TIMESTAMP    | NOT NULL, DEFAULT CURRENT_TIMESTAMP          |
| `updated_at` | TIMESTAMP    | NULL, on update CURRENT_TIMESTAMP            |
| `deleted_at` | TIMESTAMP    | NULL                                         |

#### 9. `roles`

| Column Name  | Data Type    | Constraints                           |
| ------------ | ------------ | ------------------------------------- |
| `id`         | INT          | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| `role_name`  | VARCHAR(255) | NOT NULL, UNIQUE                      |
| `deleted_at` | TIMESTAMP    | NULL                                  |

---

## System Workflow

### 1. Customer Inquiries

-   Customers search for cars based on rental dates.
-   Available cars are retrieved from the `car` table.

### 2. Customer Registration

-   Information like identification, contact details, etc., is stored in `customers`.

### 3. Booking Process

-   Customers select a car, specify rental dates and locations.
-   Total amount is calculated and recorded in `bookings`.

### 4. Driver Assignment (Optional)

-   If needed, an available driver is assigned, and a fee is added to the total.

### 5. Payment Process

-   Payment is processed, and `payments` is updated with the payment status.

### 6. Car Rental Period

-   Customer picks up and returns the car per scheduled times and locations.

### 7. Admin Management

-   Admins manage bookings, view records, and handle operations through the admin panel.
