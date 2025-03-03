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
  - Sign in with Google
  - Sign in with Apple
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
│   └── images/
│       ├── logo.png
│       └── icons/
│           ├── google.png
│           ├── apple.png
│           └── email.png
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
3. Set up OAuth credentials for social login providers

## Deployment

This project is configured for easy deployment to Vercel:

1. Connect your GitHub repository to Vercel
2. Configure environment variables in the Vercel dashboard
3. Deploy

## Technologies Used

- HTML5/CSS3
- JavaScript
- PHP
- MySQL
- OAuth 2.0 for social login

## Future Improvements

- Add password reset functionality
- Implement user profile page
- Add JWT-based authentication
- Improve security measures

## License

[MIT License](LICENSE)

## Contact

For any questions or feedback, please open an issue on this repository.
