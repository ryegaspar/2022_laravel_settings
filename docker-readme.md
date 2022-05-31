#### services:
* nginx
* php alpine
* mysql

#### ports:
* localhost: 8050
* mysql: 3356 (external - for use in tableplus)
	* for laravel env use 3306, host = mysql
* php: 9050

#### commands
* run site
```bash
docker-compose up --build -d site
```
* run redis
```bash
docker-compose up --build -d redis
```
* run artisan commands:
```bash
docker-compose run --rm artisan migrate:fresh --seed
```
* run composer:
```bash
docker-compose run --rm composer dump-autoload
```