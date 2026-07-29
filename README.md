
# Ecommerce_Shoes_Store
A full-stack shoes store web application developed using PHP and MySQL. The project features user registration and login, product browsing, shopping cart, checkout, and an admin dashboard for managing products and orders.

Secure Shoes Store Website  
---------------------------
This is a secure e-commerce website for a shoe store developed using PHP, MySQL, HTML, CSS, and JavaScript.

<p align="center">
  <img src="https://github.com/user-attachments/assets/19cbe1b1-8831-4528-8f8d-4345c85a9ffb" width="900" alt="Home Page">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/6404979a-87a2-441d-8ec4-6cf6ff4e1068" width="900" alt="Product Details">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/15373ee2-3fd2-4a80-98e2-884d65e9b624" width="900" alt="Shopping Cart">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/0948f0e2-3ca0-49be-b407-7833df6fe169" width="900" alt="Checkout">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/c07648f6-a955-443e-a596-24a74bb91ae3" width="900" alt="Order Summary">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/28a9271d-4f68-4a05-92ed-04b8ecbc5c72" width="900" alt="Login">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/db602b25-0de8-43a4-8e38-26900382444d" width="700" alt="Registration">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/6fdaca65-63ec-4224-a516-b27176d2a5b4" width="900" alt="Email Verification">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/3196977f-630d-416d-b70c-6437fdeb75a3" width="900" alt="Admin Dashboard">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/d9709b94-b873-46bd-a3f8-bb7e4ee0485c" width="900" alt="Add Product">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/d9639b59-d637-426c-81ec-df8d3d7bf69e" width="500" alt="User Profile">
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/16987a4a-e207-4523-b172-1590c94c3cca" width="500" alt="Forgot Password">
</p>
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


