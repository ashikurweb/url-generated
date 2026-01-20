# LinkFlow - Advanced URL Shortener

LinkFlow is a modern, full-featured URL shortener application built with **Laravel** (Backend) and **Vue.js** (Frontend). It offers a premium dashboard for managing links, tracking analytics, and ensuring secure redirection.

## 🚀 Features

-   **Shorten URLs**: Create clean, short links instantly.
-   **Custom Slugs**: define your own custom aliases (e.g., `linkflow.test/?url_id=sale2024`).
-   **Live Analytics**: Track clicks and engagement in real-time.
-   **Visitor Preview**: "Live Preview" modal for visitors to verify destination before redirecting.
-   **Dark Mode**: Fully supported dark/light theme.
-   **Responsive Design**: Optimized for all devices.

## 🛠 Tech Stack

-   **Backend**: Laravel 11
-   **Frontend**: Vue.js 3, Tailwind CSS
-   **Database**: MySQL / SQLite
-   **Tools**: Vite, Axios, GSAP (Animations)

---

## ⚙️ Installation & Setup

Follow these steps to set up the project locally.

### Prerequisites

-   PHP >= 8.3
-   Composer
-   Node.js (22)
-   MySQL (or use SQLite)

### 1. Clone the Repository

```bash
git clone <repository_url>
cd url-generated
```

### 2. Backend Setup (Laravel)

Install PHP dependencies:

```bash
composer install
```

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

**Configure Database:**
Open `.env` and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

_(Alternatively, you can reset the database and use SQLite by commenting out DB credentials and uncommenting `DB_CONNECTION=sqlite`)_

Run migrations:

```bash
php artisan migrate
```

### 3. Frontend Setup (Vue.js)

Install Node dependencies:

```bash
npm install
```

### 4. Seed Dummy Data (Optional)

To populate the database with 50+ dummy URL records for testing:

```bash
php artisan db:seed
```

### 5. Running the Application

You need to run both the Laravel backend and the Vite frontend server.

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend):**

```bash
npm run dev
```

Visit `http://127.0.0.1:8000` in your browser.

---

## 🧪 Testing Seeding

The project includes a `UrlSeeder` that generates 50 random URL records.

To run just the URL seeder:

```bash
php artisan db:seed --class=UrlSeeder
```

To refresh the database and seed everything:

```bash
php artisan migrate:fresh --seed
```

## 📝 Usage

1.  **Dashboard**: Visit the home page to see your dashboard.
2.  **Create Link**: Click "New Link" to shorten a URL.
3.  **Preview**: Click the "Live Preview" icon in the table to see the visitor modal.
4.  **Redirection**: Use `http://127.0.0.1:8000/?url_id=<code>` to test redirection (admin view) or live preview (visitor view).

---

Made with ❤️ by Ashikur Rahman.
