<h1 align="center" style="color: red;">LimsLv</h1>

# LimsLv: Lasha's Inventory Management System

LimsLv is a experimental inventory management system, designed for small to medium-sized businesses. Built with Laravel, it provides tools to manage products, orders, and accounting seamlessly while maintaining a user-friendly interface for both admins and customers.

## Features

- **Role-Based Access Control:**
  - **Admin:** Full access to all features.
  - **Customer:** Limited access to shop and personal order history.
  - **AdminGuest:** Full preview access to all sections.

- **Order Management:**
  - Separate views for active, finished, and canceled orders.
  - Update order statuses dynamically with role restrictions.

- **Accounting Module:**
  - Unified view for purchases and orders with profit calculation.
  - Color-coded UI for quick insights (red for expenses, green for revenues).

- **Inventory Tracking:**
  - Product stock levels and detailed history of purchases.
  - Real-time calculations for total costs, revenues, and profits.

- **Responsive Design:**
  - Powered by Tailwind CSS for modern and mobile-friendly layouts.

### Prerequisites
- PHP >= 8.1
- Composer
- Laravel 11.x
- MySQL
- Node.js and npm (for front-end assets)

