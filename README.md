# rakstamgaldsCMS

**rakstāmgalds un digitālā emuāru klade**

## Table of Contents

- [Description](#description)
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Configuration](#configuration)
- [Contributing](#contributing)
- [License](#license)
- [Contact Information](#contact-information)

## Description

rakstamgaldsCMS is a lightweight and efficient content management system built with PHP. It is designed to provide a seamless blogging experience, focusing on simplicity, functionality, and maintainability. This CMS includes user authentication, CRUD operations for posts, categories, and tags, and a user-friendly admin panel.

## Installation

1. **Download the Repository:**
   ```sh
   git clone https://github.com/rolzav/rakstamgaldsCMS.git
   cd rakstamgaldsCMS

Set Up the Database:

Ensure you have SQLite installed.
Run the init_db.php script to initialize the database:
sh
php init_db.php
Configure the Web Server:

Ensure your web server is configured to serve the files from the rakstamgaldsCMS directory.
Make sure the data directory and nextgencmsblogging.db file are writable by the web server.
Update Configuration:

Update config/config.php with your specific configurations if necessary.
Usage
Access the CMS:

Navigate to the URL where the CMS is hosted in your web browser.
Admin Panel:

Log in with the default admin credentials:
Username: admin
Password: admin123
Change the default password immediately after logging in for the first time for security purposes.
Creating Content:
Use the admin panel to manage posts, categories, and tags.

# Features
User authentication (login, logout)
CRUD operations for posts, categories, and tags
Basic routing using the Flight microframework
CSRF protection
Data sanitization
Role-based access control
Templating and Views

#Configuration
config/config.php:

<?php
return [
    'db' => [
        'database' => __DIR__ . '/../data/nextgencmsblogging.db',
    ],
];
?>
Ensure the database path is correct and the data directory is writable.

# Contributing
Contributions are welcome! Please follow these steps:
Fork the repository.
Create a new branch for your feature or bugfix.
Commit your changes.
Push your changes to your forked repository.
Create a pull request to the main repository.

# License
This project is licensed under the MIT License. See the LICENSE file for details.

# Contact Information
For any inquiries or issues, please contact:
Name: rolzav
GitHub: rolzav
# Code
Feel free to adjust any sections to better fit your project's specific details or preferences. If you need any further customizations or additional information, please let me know!


Data tree:
~/www/x.demo.id.lv/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│       └── app.js
│   ├── images/
│       └── (social media icons and other images)
├── config/
│   └── config.php
├── includes/
│   ├── init.php
│   ├── db.php
│   ├── sessions.php
│   ├── functions.php
│   ├── helpers.php
│   └── middleware.php
├── routes/
│   ├── home.php
│   ├── blog.php
│   ├── post.php
│   ├── about.php
│   ├── login.php
│   ├── logout.php
│   ├── admin.php
│   ├── category.php
│   └── tag.php
├── views/
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── create_category.php
│   │   ├── create_post.php
│   │   ├── create_tag.php
│   │   ├── edit_category.php
│   │   ├── edit_post.php
│   │   ├── edit_tag.php
│   │   ├── categories.php
│   │   ├── posts.php
│   │   └── tags.php
│   ├── 404.php
│   ├── home.php
│   ├── blog.php
│   ├── post.php
│   ├── about.php
│   ├── login.php
│   ├── categories.php
│   ├── category.php
│   ├── tags.php
│   └── tag.php
├── data/
│   └── nextgencmsblogging.db
├── vendor/
│   └── flight/
│       └── Flight.php
├── logs/
│   └── error.log
├── init_db.php
├── .htaccess
└── index.php
