# E-BookShop Web Application

The E-Shop is a web application that allows users to browse, search, and purchase books online. It provides features for both customers and administrators to manage user accounts, browse book catalog, add items to the cart, and more.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)

## Features

- User authentication and Middleware - role-based access control (admin/customer).
- Browse and search book by author or title.
- View detailed information about each book.
- Add items to the shopping cart.
- Manage user profiles (customers and admins).
- Responsive design for mobile and desktop.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Dev-Clair/e-shop.git
   ```
2. Navigate to the project directory:
   ```bash
   cd e-shop
   ```
3. Install the required dependencies using Composer:
   ```bash
   composer install
   composer dump-autoload
   ```
4. Configure your web server (e.g., Apache, Nginx) to point to the project's `public` directory.

## Usage

1. Access the application through your web browser by visiting the appropriate URL.
2. Register an account as a customer or log in as an existing user.
3. Browse the book catalog, view book details, and add items to the cart.
4. Manage your profile information and view order history.
5. Administrators can manage user accounts, view sales reports, and update book inventory.

## Technologies Used

- PHP for backend logic.
- HTML, Boostrap and JQuery for frontend.
- MySQL database for data storage.
- Composer for dependency management.
- Bootstrap for responsive design.
- MVC (Model-View-Controller) design architecture.

## Contributing

Contributions are welcome! If you find a bug or want to enhance the project, please follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Make your changes and test them thoroughly.
4. Create a pull request describing the changes you've made.

## License

This project is licensed under the [MIT License](LICENSE).
