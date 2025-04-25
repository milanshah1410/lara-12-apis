# Laravel API Project with Scramble Documentation

This project is a RESTful API built using Laravel with structured response formatting, form request validation, service layer logic, and auto-generated API documentation using [Scramble (dedoc/scramble)](https://github.com/dedoc/scramble).

---

## 🚀 Requirements

- PHP >= 8.1
- Composer
- Laravel >= 10
- MySQL / MariaDB
- Scramble (API Documentation)
- Laravel Sanctum (for authentication)

---

## 📆 Setup Instructions

```bash
# Clone repository
git clone https://github.com/milanshah1410/lara-12-apis.git
cd your-project

# Install dependencies
composer install

# Copy and set environment variables
cp .env.example .env
php artisan key:generate

# Configure DB credentials in .env
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=secret

# Run migrations and seeders
php artisan migrate --seed

# Optional: Install frontend dependencies (if any)
npm install && npm run dev
```

---

## 🧪 Common Artisan Commands

```bash
php artisan migrate             # Run migrations
php artisan db:seed             # Run all seeders
php artisan migrate:fresh --seed  # Reset DB and re-seed
php artisan make:controller API/PostController --api
php artisan make:request StorePostRequest
php artisan make:resource PostResource
php artisan make:service PostService
```

---

## 🛠️ API Authentication (Login)

### 🔐 Login API

- **POST** `/api/login`
- **Payload:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

- **Response:**
```json
{
  "token": "your-api-token",
  "user": { "id": 1, "email": "user@example.com", ... }
}
```

---

## 📝 Post CRUD APIs (Protected)

All routes below require Bearer Token.

### Create Post
- **POST** `/api/posts`
- **Headers:** Authorization: Bearer `token`
- **Payload:**
```json
{
  "title": "My Post",
  "content": "Post content here..."
}
```

### List Posts
- **GET** `/api/posts`

### View Single Post
- **GET** `/api/posts/{id}`

### Update Post
- **PUT** `/api/posts/{id}`

### Delete Post
- **DELETE** `/api/posts/{id}`

---

## 📘 API Documentation

We use [Scramble](https://github.com/dedoc/scramble) to generate OpenAPI 3 documentation.

### Install Scramble

```bash
composer require dedoc/scramble --dev
php artisan vendor:publish --tag=dedoc-scramble-config
```

### Configure Scramble Security (except login)

In `AppServiceProvider` or `ScrambleServiceProvider`:

```php
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\Types\SecurityScheme;

Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
    $openApi->secure(
        SecurityScheme::http('bearer')
    );

    // Exclude login route
    $openApi->paths->each(function ($pathItem, $uri) {
        if ($uri === '/api/login') {
            foreach (['get', 'post', 'put', 'patch', 'delete'] as $method) {
                if ($operation = $pathItem->$method) {
                    $operation->security = [];
                }
            }
        }
    });
});
```

### View API Docs

Start the local server:

```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000/docs`

---

## ✅ Features

- Laravel Sanctum for API Auth
- Form Request Validation
- API Resource for Response Formatting
- Service Class Pattern
- Clean REST API Routes
- Auto API Docs with Scramble (OpenAPI)

---

## 📁 Folder Structure Highlights

```
app/
  ├── Http/
  │   ├── Controllers/API/
  │   ├── Requests/
  │   ├── Resources/
  │   └── Middleware/
  ├── Services/
routes/
  └── api.php
```

---

## 🔐 Authentication Notes

- Use the login API to get a Bearer token.
- Pass this token in `Authorization: Bearer {token}` header for protected routes.

---

## 📞 Support

For help, please contact the dev team or open an issue in the repository.

---

Milan Shah 🎉