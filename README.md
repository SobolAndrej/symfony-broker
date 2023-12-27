### Tech Stack: PHP 8.2, Nginx, Mysql 8.0.33, RabbitMq v3

### Setup Project

1. Install docker and docker-compose 1.26.0+

2. For MacOS only. Run the following command to create a network alias for the IP specified in `.env`
   ```shell script
   sudo ifconfig lo0 alias 127.0.40.1 up
   ```

3. Build Docker containers and start them
   ```shell script
   docker-compose up -d --build
   ```
4. Run composer
   ```shell script
   docker-compose exec php composer install
   ```

5. Run migrations via
   ```shell script
   docker-compose exec php php bin/console doctrine:migrations:migrate
   ```

6. Create several users in DB

7. Use commands for message generation:
   ```shell script
   docker-compose exec php php bin/console user:balance:increase
   ```
   ```shell script
   docker-compose exec php php bin/console user:balance:decrease
   ```
   ```shell script
   docker-compose exec php php bin/console user:balance:transfer
   ```

8. Use command for messages consume:
   ```shell script
   docker-compose exec php php bin/console messenger:consume
   ```

9. For Development only. Copy `phpstan.dist.neon` to `phpstan.neon` for correct PHPStan use.


### Tests Run

### Prepare:

Give to Database User all privileges:
Run:
   ```shell script
   docker-compose exec db mysql -u root
   ```
enter `root`
Run
   ```shell script
   GRANT ALL PRIVILEGES ON * . * TO 'dev'@'%';
   FLUSH PRIVILEGES;
   exit;
   ```

Create test DB:
   ```shell script
   docker-compose exec php php bin/console --env=test doctrine:database:create
   ```
Apply all migrations:
   ```shell script
   docker-compose exec php php bin/console --env=test doctrine:schema:create
   ```

Before each test reload fixtures:
   ```shell script
   docker-compose exec php php bin/console --env=test doctrine:fixtures:load -n
   ```

Tests run:
   ```shell script
   docker-compose exec php php bin/phpunit
   ```
