Logistics System - README

Overview

This system is designed to manage logistics operations, including warehouse inventory, incoming goods, and outgoing goods. It allows users to:

View the list of items in the warehouse.

Add new products to the warehouse.

Update existing products.

Delete products.

Track the usage of products in incoming and outgoing goods to ensure data consistency.

Features

Warehouse Management

Add, view, update, and delete warehouse items.

Prevent duplicate product names while adding or editing.

Restrict updates or deletion if products are linked to incoming or outgoing goods.

Incoming and Outgoing Goods Management

Automatically update warehouse stock based on incoming and outgoing transactions.

Delete related incoming and outgoing records if a product is removed from the warehouse.

Requirements

PHP 8.2 or higher.

Laravel 9.

MySQL (configured in .env file).

MongoDB (optional for advanced features).

Installation

Clone the repository:

git clone https://github.com/your-repo/logistics-system.git

Navigate to the project directory:

cd logistics-system

Install dependencies:

composer install
npm install && npm run dev

Set up the .env file:

Configure database credentials (MySQL and optional MongoDB).

Example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logistics_db
DB_USERNAME=root
DB_PASSWORD=yourpassword

Run migrations and seeders to set up the database:

php artisan migrate --seed

Usage

1. Warehouse Management

Viewing Products

Navigate to /warehouse to view all products in the warehouse.

Adding Products

Click on the Add Product button.

Fill in the form fields:

Product Name

Quantity

Date In

Submit the form.

If the product name already exists, an alert will notify you.

Updating Products

Click the Edit button on a product.

Modify the fields as needed.

Submit the form.

If the new product name matches an existing product, an alert will notify you.

Deleting Products

Click the Delete button on a product.

Confirm the deletion.

If the product is linked to incoming or outgoing goods, related records will also be removed.

2. Incoming and Outgoing Goods Management

Use dedicated views for incoming and outgoing goods to add or manage transactions.

Ensure consistency with warehouse stock automatically.

Notes

Always back up your database before making major changes.

Ensure the server environment meets all Laravel requirements.

Troubleshooting

Issue: Duplicate Product Name Error

Cause: Trying to add or edit a product with a name that already exists in the warehouse.

Solution: Use a unique product name.

Issue: Cannot Delete Product

Cause: Product is linked to incoming or outgoing goods.

Solution: Delete related incoming or outgoing records first.

Contribution

Feel free to contribute to this project by submitting issues or pull requests on GitHub.

License

This project is licensed under the MIT License.