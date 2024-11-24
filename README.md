1) Clone the repository

    ~# git clone https://github.com/sthskr/repo1.git

2) Build docker images

    ~# docker compose build

3) Start docker containers

    ~# docker compose up -d

4) Access application container, set right permissions, initialize database, create symlink to public folder, retrieve the first data manually (there is cronjob to retrieve data once a day at 8:30)

    ~# docker exec -it my-laravel-app bash
    ~# chown -R www-data:www-data storage bootstrap/cache
    ~# chown -R www-data:www-data storage/logs
    ~# chmod -R 775 storage bootstrap/cache

For the next command, we have to wait until the database container is ready, if it is not ready we will see an error (on my machine takes ~30 seconds)

~# php artisan migrate
~# php artisan storage:link

With next command we download manually the items, if we don't want to wait, we can interrupt the proccess with Ctrl+C so we will have a limited number items.

~# php artisan retrieve-api-data

5) We can run the tests from tests/Feature/AyloTest.php and tests/Unit/AyloTest.php files with the next command:

~# php artisan test
