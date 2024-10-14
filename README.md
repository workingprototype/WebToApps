# WebToApp Builder

Welcome to **App Builder**, your all-in-one solution for creating and configuring desktop applications effortlessly. With a user-friendly interface, you can customize various aspects of your app, from design to functionality.

## Features

### 🌟 Custom App data
- Easily create forms to capture essential app details, including:
  - App Name
  - Version
  - Description
  - App ID
  - Product Name

### 🎨 Customizable Menus
- Build and customize your application's menus dynamically.
- Add custom menu items with links and actions.
- Remove unwanted menus before finalizing your app.

### 🖼️ Icon & Logo Upload
- Upload your app's icon and logo.
- Automatically convert uploaded images to the required formats and store them correctly for easy access.

### 📏 Adjustable Dimensions
- Specify custom dimensions for your app's main window and splash screen, including:
  - Width
  - Height

### 🎨 Theme Customization
- Select your app's theme colors using RGB values for a personalized look and feel.

### 📦 Built-in Plug-in Support ( coming soon )
- Predefined scripts for packaging and distribution, simplifying the build process.

### 💻 Cross-Platform Support
- Create applications that can be packaged for Windows, macOS, and Linux, ensuring a broad reach for your software.


To run this application, you need the following:

PHP >= 8.0
Composer
Laravel >= 9.x
MySQL


1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/your-laravel-app.git
   cd your-laravel-app
   ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Copy the environment file:**

   ```bash
   cp .env.example .env
   ```

4. **Generate an application key:**

   ```bash
   php artisan key:generate
   ```

5. **Configure the database:**

   Open the `.env` file and set the following values:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations:**

   ```bash
   php artisan migrate
   ```

## Configuration

Make sure to adjust any other configuration settings in the `.env` file according to your environment and requirements.

## Usage

To start the development server, run:

```bash
php artisan serve
```

You can then access the application at [http://localhost:8000](http://localhost:8000).

