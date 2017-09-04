# create the database
# there must exist a user account with 
# name: umbrellapp, pass: secret
# on mysql db listening on localhost (127.0.0.1)
# port: 3306
# this can be changed by .env file inside the main folder
php artisan migrate

# unit test
phpunit

# seed the database to start rolling
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=CitiesTableSeeder
php artisan db:seed --class=FavoritesTableSeeder
php artisan db:seed --class=ForecastTableSeeder
