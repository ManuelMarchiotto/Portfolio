# UrbanWear | Professional E-Commerce Engine

UrbanWear is a high-performance e-commerce platform developed with a focus on robust backend architecture, data integrity, and clean code principles. It represents a professional-grade application designed to handle real-world commerce needs.

## 🚀 Project Overview
The goal was to build a production-ready e-commerce engine. Beyond the user-facing store, this project tackles core technical challenges such as **concurrency handling**, **transactional integrity**, and **separation of concerns**.

## 🛠 Tech Stack
- **Framework:** Laravel (PHP 8.3+)
- **Styling:** Tailwind CSS v4
- **Build Tool:** Vite
- **Database:** SQLite/MySQL (via Eloquent ORM)

## 🏗 Architecture & Design Decisions
*The following sections highlight the professional engineering approach taken during development:*

### 1. Separation of Concerns (Service Pattern)
Instead of implementing heavy business logic within Controllers, I adopted a **Service-Oriented Architecture**.
*   **Why?** By delegating core logic (such as order processing and cart management) to dedicated Service Classes, the code remains modular, easy to maintain, and—critically—unit-testable. This follows the **Single Responsibility Principle (SRP)**.

### 2. Data Integrity & Concurrency
One of the most critical challenges in e-commerce is preventing "overselling" (two users successfully purchasing the last item at the same time).
*   **Solution:** I implemented **Database Transactions** combined with `lockForUpdate()`. This ensures that the inventory check and order creation are atomic. If any part of the process fails, the transaction rolls back, ensuring 100% consistency between stock levels and order records.

### 3. Performance Optimization
*   **Eager Loading:** Implemented to solve the "N+1 Query" problem, ensuring that related data (like product categories) is fetched efficiently in a single database hit.
*   **Memory Management:** Optimized collection handling and data flow to ensure smooth performance during heavy operations like cart calculation.

---

## 🚀 Development Journey
The project followed a structured engineering path to ensure a robust final product:

1.  **Core Foundation:** Architecture design, database schema creation for products and categories.
2.  **Inquiry System:** Development of a performant product catalog with advanced filtering and search capabilities.
3.  **Stateful Cart Engine:** Implementation of a robust shopping cart logic handling multi-variant products (e.g., size selection) and accurate pricing.
4.  **Atomic Checkout:** Engineering a transaction-safe checkout flow, handling complex database locks to guarantee data integrity.
5.  **Refinement:** Architecture refactoring into Service Classes and optimizing code readability and speed.

---

## ✨ Key Features
- **Advanced Catalog:** Efficiently filterable product listing with multi-criteria search.
- **Safe Cart Management:** Robust handling of itemized queries and stock checks.
- **Transactionally Safe Orders:** A high-integrity checkout flow that ensures one-to-one consistency between payments and inventory.
- **Admin Dashboard:** A secure back-office for order management and product administration.

## 🚀 Installation & Setup
1. Clone the repository:
   ```sh
   git clone <repository_url>
   ```
2. Install dependencies:
   ```sh
   npm install
   composer install
   ```
3. Environment setup:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations and seed data:
   ```sh
   php artisan migrate --seed
   ```
5. Start the development server:
   ```sh
   php artisan serve
   npm run dev
   ```

---
*Developed with a focus on scalability, security, and high-quality engineering.*
