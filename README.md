step-1

git clone https://github.com/shakilkhan80/banking-system.git
cd repository

step-2
composer install

copy .env.example to .env file
make a database in local
set database 

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banking_system
DB_USERNAME=root
DB_PASSWORD=

step 3 

php artisan migrate
npm run dev(optional)

step 4
data set in database
php artisan tinker
App\Models\Account::create(['balance'=>1000,'free_withdrawals'=>3]);

last step 
php artisan migrate
