In order to run code, you need to set up Web Server,
which will run `index1.html` and `index2.html` files, so PHP code will work properly

Here is a configuration file example for nginx
```
server {
    listen 80;
    server_name tracking.local;
    root /var/www/html/tracking/public;

    index index1.html index2.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

and you can test using
- http://tracking.local/index1.html
- http://tracking.local/index2.html