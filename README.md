# Symfony Project

## 📦 Project Overview

This is a Symfony-based PHP news application.

## 🛠️ Tech Stack

- PHP ^8.2
- Symfony ^7.3
- Composer
- Doctrine ORM
- Twig
- PostgreSQL 17

## 🚀 Getting Started

### Installation

1. Clone the repository:

```bash
git clone https://github.com/utupursi/blogs.git
```

2. Install dependencies:

```bash
   composer install
```

3. Copy .env to .env.local and configure your local database and environment settings:

```bash
cp .env .env.local
```

4. Set up the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Run fixtures:

```bash
php bin/console doctrine:fixtures:load
```

6. Run server:

```bash
symfony server:start
```

7. Run command to send top 10 most commented news email manually
```bash
php bin/console App\Command\SendTopCommentedNews
```

##  Routing
- /login
- /admin/category - admin category management page
- /admin/news - admin news management page
- / - public interface
