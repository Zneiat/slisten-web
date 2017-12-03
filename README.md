# slisten-web
The Sincerely Listen By ZNEIAT.

### Install
```
git clone https://github.com/Zneiat/slisten-web.git
composer install
php -r "copy('.env.example', '.env');"
php artisan key:generate
php artisan migrate
nmp install
node message.js  # Windows Server 可下载 http://nssm.cc 让 nodejs 持久运作
```