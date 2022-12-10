Requirement :
1. PHP ^8.0
2. Composer (https://getcomposer.org/)

Instalasi :
1. Rename file .env.example ke .env
2. Isi informasi database (cth. HOST, USERNAME, PASSWORD, DBNAME) pada file .env
3. Jalankan perintah
    1. composer install
    2. php artisan key:generate
    3. php artisan migrate:fresh --seed
4. Jalankan development server "php artisan serve"
