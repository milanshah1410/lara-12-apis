## 📘 Laravel API Documentation Project

This project provides a fully working Laravel REST API setup, including authentication, Post CRUD functionality, and beautiful autogenerated docs using [Scramble](https://github.com/dedoc/scramble).

---

### 🔧 Setup Instructions

1. **Clone the repository and install dependencies**

   ```bash
   git clone https://github.com/milanshah1410/lara-12-apis.git
   cd <project-folder>
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. \*\*Configure your \*\***`.env`**

   - Set your database credentials.
   - Add `SANCTUM_STATEFUL_DOMAINS` and `SESSION_DOMAIN` if needed.

3. **Run migrations and seeders**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Run the server**

   ```bash
   php artisan serve
   ```

---

### 🚀 API Features

#### 🛡️ Authentication

- **Login**

  - `POST /api/login`
  - Body:
    ```json
    {
      "email": "user@example.com",
      "password": "secret"
    }
    ```
  - Returns Bearer Token for protected routes.

- Uses `sanctum` for token-based authentication.

#### 📝 Post Management

| Method | Endpoint          | Description        |
| ------ | ----------------- | ------------------ |
| GET    | `/api/posts`      | List all posts     |
| POST   | `/api/posts`      | Create new post    |
| GET    | `/api/posts/{id}` | Show specific post |
| PUT    | `/api/posts/{id}` | Update post        |
| DELETE | `/api/posts/{id}` | Delete post        |

- Each route is protected with policies (`view`, `update`, `delete`).
- Validation handled by custom `FormRequest` classes.

---

### 📚 API Documentation

- Generated using [Scramble](https://github.com/dedoc/scramble)
- Visit `/docs/api` to view docs

---

### 🔐 Authorization & Policies

- Use Laravel’s Policy mechanism to protect Post actions.
- Add to controller:
  ```php
  $this->authorize('update', $post);
  ```
- Register in `AuthServiceProvider`:
  ```php
  protected $policies = [
      \App\Models\Post::class => \App\Policies\PostPolicy::class,
  ];
  ```

---

### ⚙️ Artisan Commands

Here are commonly used artisan make commands:

| Command                | Description                                           |
| ---------------------- | ----------------------------------------------------- |
| `make:model Post -mcr` | Create model with migration, controller, and resource |
| `make:request`         | Generate custom validation request                    |
| `make:policy`          | Create a new policy class                             |
| `make:seeder`          | Create database seeder                                |
| `make:controller`      | Create API controller                                 |
| `make:resource`        | Create API resource formatter                         |
| `make:factory`         | Create a model factory                                |

For full list, run:

```bash
php artisan list make
```

---

### 🔒 Token Storage

Tokens are generated using Sanctum:

```php
$user->createToken('api_token')->plainTextToken;
```

---

### 📌 Credits

- Laravel
- Sanctum
- Scramble

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