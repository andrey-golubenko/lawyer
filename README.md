# Lawyer WordPress Theme

<div align="center">
  <img src="https://img.shields.io/badge/WordPress-5.0+-blue.svg" alt="WordPress 5.0+">
  <img src="https://img.shields.io/badge/PHP-7.0+-green.svg" alt="PHP 7.0+">
  <img src="https://img.shields.io/badge/License-GPL_v3-blue.svg" alt="License GPL v3">
</div>

## 🌍 Demo

Explore the live demo of Lawyer to experience its features firsthand:

- **Live Demo**: [Lawyer](https://lawlex.com.ua/)

## 🎯 Core Features

- **Custom WordPress Theme for Law Firms**
- **SEO Optimization**
  - Meta title management
  - Meta description generation
  - Custom SEO class implementation
- **Navigation System**
  - Custom header menu support
  - Registered menu locations
- **Media Management**
  - Featured image support
  - Custom image sizes
    - Main post thumbnails (730x487)
    - Small recent post thumbnails (78x80)
- **HTML5 Support**
  - Modern markup for:
    - Search forms
    - Comment forms
    - Comment lists
    - Galleries
    - Captions

## 🛠️ Technology Stack

- **WordPress Core**
- **PHP**
- **Custom SEO Implementation**
- **WordPress Theme API**

## 🔧 Theme Features

The theme includes:

- Custom header menu support
- Title tag support
- Post thumbnail support
- HTML5 markup support
- Custom image sizes
- SEO optimization tools
- Security enhancements
  - License and readme file removal
  - WordPress version number removal
  - Script version string removal

## 🚀 Installation

1. Upload the theme to your WordPress installation:
   ```bash
   /wp-content/themes/lawyer/
   ```

2. Activate the theme through the WordPress admin panel:
   - Navigate to Appearance > Themes
   - Click "Activate" on the Lawyer theme

3. Configure the theme:
   - Set up menus under Appearance > Menus
   - Configure widgets if applicable
   - Set featured images for posts

## 📂 Project Structure

```plaintext
lawyer/
├── theme lawyer/                   # Main WordPress theme directory
│   ├── functions.php               # Theme setup, features and functionality
│   │   ├── Menu registration
│   │   ├── Theme support setup
│   │   ├── Image sizes config
│   │   └── Security enhancements
│   ├── layouts/                    # Theme layout templates
│   ├── templates/                  # Page templates
│   ├── assets/                     # Theme assets
│   │   ├── css/                    # Stylesheets
│   │   ├── js/                     # JavaScript files
│   │   └── fonts/                  # Custom fonts
│   └── includes/                   # Theme includes and modules
│
└── LICENSE                         # GNU GPL v3 License file
```

## 🔨 Development Notes

### Theme Setup
The theme is initialized in `functions.php` with:
- Text domain loading
- Navigation menu registration
- Theme feature support
- Custom image size definitions

### SEO Implementation
Custom SEO class provides:
- Meta title generation
- Meta description management
- Maximum character length control
- Custom filters for meta information

## 📜 License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.
