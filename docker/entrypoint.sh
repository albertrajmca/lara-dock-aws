#!/bin/bash

# I know this is not the proper way to check the mysql is 
# up and running to execute the migration and seeder
# in real cases the db will be exist and we can run 
# it directly in the docker file 
sleep 15;

echo "MySQL is running on port 3306"

# Run the migrations and seed the database
php artisan migrate --seed

# Start the Apache web server
apache2-foreground