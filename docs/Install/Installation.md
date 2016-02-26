Installation
------------

> At present this is put together from my notes on setting up the branch in the first place. It may not be 100%!

This branch at present requires you to already have a fully working LibreNMS install. It doesn't require to be installed on the same server, this branch purely needs access to the MySQL instance to work.

All of these commands are to be run as the librenms user.

If you are installing this on a different server to that of your origin LibreNMS install then please ensure you have added the LibreNMS user and set it's group as per the original install docs.

Requirements
------------

 - PHP 5.5.9 or newer
 - Web server such as Apache or Nginx

```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/bin --filename=composer
cd /opt/
sudo git clone https://github.com/librenms/librenmsv2 librenmsv2
sudo chown -R librenms:librenms /opt/librenmsv2/ -R
cd librenmsv2
cp .env.example .env
```

Please now edit the .env file and set your options.

```bash
composer install
php artisan key:generate
```

Now you will need to create your web server config.

| Distro  | Web Server  | Config  |
|---|---|---|
| CentOS / RHEL | Apache 2.2.17 or lower  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2217.txt)  |
| CentOS / RHEL | Apache 2.2.18 or later  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2218.txt)  |
| Ubuntu / Debian | Apache 2.2.17 or lower  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2217.txt)   |
| Ubuntu / Debian | Apache 2.2.18 or later  | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/apache_2218.txt)   |
| All | Nginx | [Config](https://raw.githubusercontent.com/librenms/librenmsv2/develop/docs/_configs/nginx.txt)   |
Now restart the web server.

| Distro  | Web Server  | Command  |
|---|---|---|
| CentOS / RHEL | Apache | sudo service httpd restart |
| Ubuntu / Debian | Apache | sudo service httpd restart |
| systemd based | Nginx | systemctl restart nginx.service |

You should now be able to login with your normal credentials.
