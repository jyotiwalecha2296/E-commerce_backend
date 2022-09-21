git clone https://github.com/jyotiwalecha2296/E-Commerce_backend.git
copy env.example file and rename .env and update configration
php artisan migrate:refresh --seed
php artisan key:generate
php artisan db:seed --class=CreateUsersSeeder
php artisan db:seed --class=CountryCodeSeeder
php artisan db:seed --class=MenuTypeSeeder
php artisan db:seed --class=SettingsSeeder
