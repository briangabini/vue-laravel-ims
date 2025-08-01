# Vue.js and Laravel Inventory Management System

This is an inventory management system built with Vue.js and Laravel for the course Security Development.

## Technologies Used

*   **Backend:** Laravel 12
*   **Frontend:** Vue 3, Vite
*   **Styling:** Tailwind CSS, ShadCN
*   **Authentication:** Laravel Fortify (under the hood)
*   **Database:** SQLite (default), MySQL, PostgreSQL


## Access Control Matrix

| Privilege / Action | Website Administrator | Product Manager | Customer |
| :--- | :--- | :--- | :--- |
| **Products** | | | |
| View All Products (Admin) | Yes | Yes | No |
| Create New Products | Yes | Yes | No |
| Edit Products | Yes | Yes | No |
| Delete Products | Yes | No | No |
| View Public Products | Yes | Yes | Yes |
| **Categories** | | | |
| Manage Categories | Yes | Yes | No |
| **Orders** | | | |
| View All Orders | Yes | Yes | No |
| Update Order Status | Yes | Yes | No |
| Place an Order | No | No | Yes |
| View Own Orders | No | No | Yes |
| **Users & Roles** | | | |
| View All Users | Yes | No | No |
| Manage Users (CRUD) | Yes | No | No |
| Manage Roles & Permissions | Yes | No | No |
| **System** | | | |
| Access Admin Dashboard | Yes | Yes | No |
| Access Customer Dashboard | No | No | Yes |
| Access Logs | Yes | No | No |

## Security Checklist

### 2.1. Authentication

- Require authentication for all pages and resources, except those specifically intended to be public.
- All authentication controls should fail securely.
- Only cryptographically strong one-way salted hashes of passwords are stored.
- Authentication failure responses should not indicate which part of the authentication data was incorrect.
- Enforce password complexity and length requirements.
- Password entry should be obscured on the user’s screen.
- Enforce account disabling after an established number of invalid login attempts.
- Password reset questions should support sufficiently random answers.
- Prevent password re-use.
- Passwords should be at least one day old before they can be changed.
- The last use of a user account should be reported to the user at their next successful login.
- Re-authenticate users prior to performing critical operations such as password change.

### 2.2. Authorization/Access Control

- Use a single site-wide component to check access authorization.
- Access controls should fail securely.
- Enforce application logic flows to comply with business rules.

### 2.3. Data Validation

- All validation failures should result in input rejection.
- Validate data range and length.

### 2.4. Error Handling and Logging

- Use error handlers that do not display debugging or stack trace information.
- Implement generic error messages and use custom error pages.
- Logging controls should support both success and failure of specified security events.
- Restrict access to logs to only website administrators.
- Log all input validation failures.
- Log all authentication attempts, especially failures.
- Log all access control failures.

## Demo Images

### Admin
- [Dashboard](demo_images/admin/dashboard.png)
- Categories
  - [Manage](demo_images/admin/categories/category-manage.png)
  - [Create](demo_images/admin/categories/category-create.png)
  - [Edit](demo_images/admin/categories/category-edit.png)
- Logs
  - [Security List](demo_images/admin/logs/logs-security-list.png)
  - [Error List](demo_images/admin/logs/logs-error-list.png)
  - [Log Details](demo_images/admin/logs/logs-log-details.png)
- Orders
  - [Manage](demo_images/admin/orders/orders-manage.png)
  - [Edit](demo_images/admin/orders/orders-edit.png)
- Products
  - [List](demo_images/admin/products/products-list.png)
  - [Create](demo_images/admin/products/products-create.png)
  - [Edit](demo_images/admin/products/products-edit.png)
- Roles
  - [Manage](demo_images/admin/roles/roles-manage.png)
  - [Create](demo_images/admin/roles/roles-create.png)
  - [Edit](demo_images/admin/roles/roles-edit.png)
- Settings
  - [Profile](demo_images/admin/settings/settings-profile.png)
  - [Password](demo_images/admin/settings/settings-password.png)
  - [Security Questions](demo_images/admin/settings/settings-security-questions.png)
  - [Appearance](demo_images/admin/settings/settings-appearance.png)
  - [Account Deletion Confirmation](demo_images/admin/settings/settings-account-deletion-confirmation.png)
- Users
  - [Manage](demo_images/admin/users/users-manage.png)
  - [Create](demo_images/admin/users/users-create.png)
  - [Edit](demo_images/admin/users/users-edit.png)

### Manager
- [Dashboard](demo_images/manager/dashboard.png)
- Categories
  - [Manage](demo_images/manager/categories/categories-manage.png)
  - [Create](demo_images/manager/categories/categories-create.png)
  - [Edit](demo_images/manager/categories/categories-edit.png)
- Orders
  - [Manage](demo_images/manager/orders/orders-manage.png)
  - [Edit](demo_images/manager/orders/orders-edit.png)
- Products
  - [Manage](demo_images/manager/products/products-manage.png)
  - [Create](demo_images/manager/products/products-create.png)
  - [Edit](demo_images/manager/products/products-edit.png)
- Settings
    - [Profile](demo_images/manager/settings/settings-profile.png)
    - [Password](demo_images/manager/settings/settings-password.png)
    - [Security Questions](demo_images/manager/settings/settings-security-questions.png)
    - [Appearance](demo_images/manager/settings/settings-appearance.png)

### Customer
- Auth
  - [Previous Login Attempt (Success)](demo_images/customers/auth/login-attempts/auth-previous-login-attempt-success.png)
  - [Previous Login Attempt (Failure)](demo_images/customers/auth/login-attempts/auth-previous-login-attempt-failure.png)
- Cart
  - [Empty](demo_images/customers/cart/cart-empty.png)
  - [Not Empty](demo_images/customers/cart/cart-not-empty.png)
  - [Modify Quantity](demo_images/customers/cart/cart-modify-quantity.png)
  - [Order Placed](demo_images/customers/cart/cart-order-placed.png)
- Home
  - [Home Page](demo_images/customers/home/home-page.png)
  - [Filtered and Sorted](demo_images/customers/home/home-page-filtered-sorted.png)
  - [Add to Cart Alert](demo_images/customers/home/home-page-add-to-cart-alert.png)
- Orders
  - [View Order](demo_images/customers/orders/view-order.png)
- Settings
  - [Profile](demo_images/customers/settings/settings-profile.png)
  - [Password](demo_images/customers/settings/settings-password.png)
  - [Security Questions](demo_images/customers/settings/settings-security-questions.png)
  - [Login Attempts](demo_images/customers/settings/settings-login-attempts.png)
  - [Account Deletion Confirmation](demo_images/customers/settings/settings-account-deletion-confirmation.png)

### Universal
- Forgot Password
  - [Email](demo_images/universal/forgot-password/forgot-password-email.png)
  - [Security Question](demo_images/universal/forgot-password/forgot-password-security-question.png)
  - [Security Question Filled](demo_images/universal/forgot-password/forgot-password-security-question-filled.png)
  - Reset Password
    - [Reset Password](demo_images/universal/forgot-password/reset-password/reset-password.png)
    - [Reset Password Complete](demo_images/universal/forgot-password/reset-password/reset-password-complete.png)
- Login
  - [Login](demo_images/universal/login/login.png)
  - [Login Filled](demo_images/universal/login/login-filled.png)
- Sign Up
  - [Sign Up](demo_images/universal/sign-up/sign-up.png)
  - [Sign Up Filled](demo_images/universal/sign-up/sign-up-filled.png)
