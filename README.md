# PHP Auth

A demonstration website showcasing frontend and backend skills with a focus on authentication flows and data handling.

## Project Overview

PHP Auth is a simple yet comprehensive web application that implements various authentication methods including social login (Google, Apple) and traditional email-based authentication. The project demonstrates:

- Frontend development with responsive design
- Backend data processing and storage
- Form validation and handling
- Authentication flows
- Database integration

## Features

- Clean, responsive landing page
- Multiple authentication options:
  - Sign in with Google (Not OAuth)
  - Sign in with Apple (Not API)
  - Email-based authentication
- Secure data handling
- Form validation
- Success feedback after authentication
- Mobile-friendly design

## Project Structure

```
root/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
├── includes/
│   ├── config.php
│   ├── db.php
│   └── functions.php
├── index.php           # Landing page
├── auth.php            # Authentication page
├── process-auth.php    # Processes form submissions
├── success.php         # Success page after authentication
└── database.sql        # SQL structure for database
```

## Setup and Installation

1. Clone this repository:
   ```
   git clone https://github.com/awanicaleb/php-auth.git
   ```

2. Create a database and import the structure from `database.sql`

3. Copy `includes/config.sample.php` to `includes/config.php` and update with your database credentials and other configuration

4. Set up a local development server or deploy to your hosting provider

## Configuration

To configure the application:

1. Update database credentials in `includes/config.php`
2. Configure email settings for form submissions (if using email logging)
<!-- 3. Set up OAuth credentials for social login providers -->

## Deployment

This project is configured for easy deployment. I used [Infinity Free](https://infinityfree.com/) to deploy and it simple and easy.
1. Configure environment variables
2. Copy files and folder from project root to your htdocs in your hosting provider's file manager
3. Done!

## Technologies Used

- HTML5/CSS3
- JavaScript
- PHP
- MySQL

## Future Improvements

- Add password reset functionality
- Implement user profile page
- Add JWT-based authentication
- Improve security measures

## License

[MIT License](LICENSE)

## Contact

For any questions or feedback, please open an issue on this repository.
