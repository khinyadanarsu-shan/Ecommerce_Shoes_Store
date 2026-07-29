# Ecommerce_Shoes_Store
A full-stack shoes store web application developed using PHP and MySQL. The project features user registration and login, product browsing, shopping cart, checkout, and an admin dashboard for managing products and orders.

Secure Shoes Store Website  
---------------------------
This is a secure e-commerce website for a shoe store developed using PHP, MySQL, HTML, CSS, and JavaScript.

FEATURES:
-------------
- Customer registration and login
- Password strength checker
- CAPTCHA verification
- Email verification & welcome email
- Two-Factor Authentication (2FA) for login
- Product listing and modal-based product details
- Add to cart and cart update
- Checkout with payment options (Cash on Delivery & VISA)
- Order summary and success page
- Admin dashboard to manage products and users

REQUIREMENTS:
------------------
- XAMPP (Apache, MySQL, PHP)
- Web browser (Chrome, Firefox, etc.)

SETUP INSTRUCTIONS:
-----------------------

1. **Extract the ZIP file**
   - Extract the folder `shoes_store` from the ZIP archive.

2. **Move to XAMPP htdocs**
   - Copy the entire `shoes_store` folder to:
     ```
     C:\xampp\htdocs\
     ```

3. **Start XAMPP**
   - Open XAMPP Control Panel.
   - Start **Apache** and **MySQL**.

4. **Create the Database**
   - Go to:
     ```
     http://localhost/phpmyadmin
     ```
   - Click on “Import”.
   - Select the SQL file inside the `shoes_store` folder (usually named `shoes_store.sql`) and import it.

5. **Access the Website**
   - Open your browser and go to:
     ```
     http://localhost/shoes_store/home.php
     ```
 TESTING ACCOUNTS:
---------------------
- **Admin Email:** hsushan2162005@gmail.com  
  (Register with this email to gain admin access)

- **Other emails:** will register as customers

If you want to add “admin”, you have to go “password.php “ and add password. After that run and copy password that get after running and then go to http://localhost/phpmyadmin” and add data in name, email, password and role in users table.
 EMAIL CONFIGURATION:
-------------------------
- The system uses PHPMailer to send emails (for 2FA and registration).
- For live email features to work, you need to configure SMTP settings in `signin.php` and `register.php`.

RECOMMENDED:
-----------------
- Do not use real email credentials in a public setting.
- You may disable email sending during testing by commenting out PHPMailer sections.


