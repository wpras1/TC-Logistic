# Tech Logistics System 

## Overview

Welcome to the **Logistics System**, designed to efficiently manage logistics operations such as warehouse inventory, incoming goods, and outgoing goods. With this system, users can:

- View and manage the list of items in the warehouse.
- Add new products to the warehouse.
- Update existing products.
- Delete products.
- Track and update the usage of products in incoming and outgoing goods to ensure data consistency.

## Features

### Warehouse Management

- Add, view, update, and delete warehouse items.
- Prevent duplicate product names when adding or editing.
- Restrict updates or deletions if products are linked to incoming or outgoing goods.

### Incoming and Outgoing Goods Management

- Automatically update warehouse stock based on incoming and outgoing transactions.
- Delete related incoming and outgoing records if a product is removed from the warehouse.

## Requirements

- PHP 8.2 or higher.
- Laravel 9.
- MySQL (configured in `.env` file).
- MongoDB (optional for advanced features).

## Installation

### Step 1: Clone the Repository

Clone the repository using the following command:

`git clone https://github.com/wpras1/TC-Logistic.git`

### Step 2: Navigate to the Project Directory

Move into the project directory:

`cd TC-Logistic`

### Step 3: Install Dependencies

Install PHP and JavaScript dependencies by running:

`composer install`

`npm install && npm run dev`

### Step 4: Set Up the `.env` File

Configure your database credentials for MySQL (and optional MongoDB).

Example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logistics_db
DB_USERNAME=root
DB_PASSWORD=yourpassword


### Step 5: Run Migrations and Seeders

Set up the database schema and populate initial data by running:

`php artisan migrate --seed`

## Usage

### 1. Warehouse Management

- **Viewing Products**: Navigate to `/warehouse` to see all products in the warehouse.
- **Adding Products**:
    1. Click on the **Add Product** button.
    2. Fill in the product details:
        - Product Name
        - Quantity
        - Date In
    3. Submit the form.
    4. If a product name already exists, an alert will notify you.
- **Updating Products**:
    1. Click **Edit** on a product.
    2. Modify the details.
    3. Submit the form.
    4. If the new name matches an existing product, an alert will notify you.
- **Deleting Products**:
    1. Click **Delete** on a product.
    2. Confirm the deletion.
    3. If the product is linked to incoming or outgoing goods, related records will also be removed.

### 2. Incoming and Outgoing Goods Management

- Use the dedicated views for managing incoming and outgoing goods transactions.
- Ensure that warehouse stock is updated automatically for each transaction.

## Notes

- **Backup**: Always back up your database before making major changes.
- **Server Requirements**: Ensure that your server environment meets all Laravel prerequisites.

## Troubleshooting

### Issue: Duplicate Product Name Error

- **Cause**: Trying to add or edit a product with a name that already exists.
- **Solution**: Use a unique product name.

### Issue: Cannot Delete Product

- **Cause**: The product is linked to incoming or outgoing goods.
- **Solution**: Delete related incoming or outgoing records first.

## Contribution

Feel free to contribute to this project by submitting issues or pull requests on [GitHub](https://github.com/wpras1/TC-Logistic.git).

## License

This project is licensed under the **MIT License**.
