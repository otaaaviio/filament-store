# Filament Store

A web application built with Laravel and Filament.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Introduction

This project is a web application developed using Laravel, a PHP framework for web artisans, PostgreSQL, a robust
database, and Filament, an admin panel for Laravel applications. The application aims to provide a robust and
user-friendly interface for managing data and workflows.
Also, the application is designed to be modular and scalable, allowing developers to extend and customize it according
to their requirements.

## Features

- User authentication and authorization
- Data management with CRUD operations
- Responsive admin panel with Filament
- Dashboard with analytics and reporting
- Modular and scalable architecture

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- PostgreSQL

### Steps

1. **Clone the repository:**

```bash
git clone https://github.com/yourusername/filament-store.git
cd filament-store
```

2. **Install dependencies:**

```bash
composer install
```

3. **Setup the environment:**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Run the migrations and seeder:**

```bash
php artisan migrate --seed
```

5. **Start the development server:**

```bash
php artisan serve
```

## Configuration

### Environment Variables

example:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

## Usage

1. **Access the application:**

Once the application is running, you can access the Filament admin panel at [/admin]() by default. Log in with the credentials you configured during the seeding process.

2. **Manage data:**

You can manage data using the CRUD operations provided by Filament. Create, read, update, and delete records from the database using the user-friendly interface.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue if you encounter any problems or have any suggestions.

1. Fork the repository
2. Create a new branch (git checkout -b feature/your-feature)
3. Commit your changes (git commit -am 'Add your feature')
4. Push to the branch (git push origin feature/your-feature)
5. Create a new Pull Request

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

For any questions or inquiries, please contact oglamberty@inf.ufsm.br
