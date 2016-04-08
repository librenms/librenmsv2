Installation
------------

> This install guide has been tested but may not be yet 100% valid! Please feel free to open an issue or contribute on the guide  if needed.

This branch at present requires you to already have a fully working LibreNMS install. It doesn't require to be installed on the same server, this branch purely needs access to the MySQL instance to work.

All of these commands are to be run as the librenms user.

If you are installing this on a different server to that of your origin LibreNMS install then please ensure you have added the LibreNMS user and set it's group as per the original install docs.

Requirements
------------

 - PHP 5.5.9 or newer
 - Web server such as Apache or Nginx

Initial Setup
-------------
```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/bin --filename=composer
cd /opt/
sudo git clone https://github.com/librenms/librenmsv2 librenmsv2
cd librenmsv2
sudo mkdir logs
sudo chown -R librenms:librenms /opt/librenmsv2
```

Basic settings
--------------
```bash
cp .env.example .env
```
Now edit the .env file and set your options.

Replace the database configuration with the one used by Librenms (have a look at the config.php file in /opt/librenms directory)
```yaml
DB_HOST=127.0.0.1
DB_DATABASE=librenms
DB_USERNAME=username
DB_PASSWORD=password
```

If v1 is installed in a non-standard location, and you would like to import config.php settings, set V1_INSTALL_DIR. Or set this to empty if you don't want config.php imported.
```yaml
V1_INSTALL_DIR=/opt/librenms
```


Install requirements and generate unique key.
```bash
composer install
php artisan key:generate
```

If you have issues running composer install try: `composer install --no-scripts`


Make sure librenms user is part of webserver Group and can write logs in storage directory
```bash
usermod -a -G librenms www-data
chmod -R g+w storage bootstrap/cache logs
```


Web Server
----------
Now you will need to create your web server config and modify as needed.

| Distro  | Web Server  | Config |
|---|---|---|
| CentOS / RHEL, Ubuntu / Debian | Apache 2.2.17 or lower  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2217.txt)  |
| CentOS / RHEL, Ubuntu / Debian | Apache 2.2.18 or later  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2218.txt)  |
| CentOS / RHEL, Ubuntu / Debian | Nginx | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/nginx.txt)   |

If you want to run this on the same server as your current LibreNMS install on another port then just modify the beginning of your webserver config:

Apache:
```apache
Listen 81
<VirtualHost *:81>
```

Nginx:
```nginx
listen 81;
```
Now restart the web server.

| Distro  | Web Server  | Command  |
|---|---|---|
| CentOS / RHEL 6, Ubuntu 14.04, Debian 7 | Apache | sudo service httpd restart |
| CentOS / RHEL 7+, Ubuntu 15.04+, Debian 8+ | Apache | systemctl restart httpd.service |
| CentOS / RHEL 6, Ubuntu 14.04, Debian 7 | Nginx | sudo service nginx restart |
| CentOS / RHEL 7+, Ubuntu 15.04+, Debian 8+ | Nginx | systemctl restart nginx.service |

You should now be able to login with your normal credentials.
