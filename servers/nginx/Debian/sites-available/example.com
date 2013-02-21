# place in /etc/nginx/sites-available/ and symlink to /etc/nginx/sites-enabled/

# These shouldn't be accessible from the web anyway, redirect rogue links back to the original
#   (e.g. in order not to give duplicate content to search engines like www.example.com/etc and ns1.example.com/etc).
# If your original URL is w/o www., replace the www.example.com in the last server directive below with the example.com here.
server {
    listen       80;
    server_name  example.com mail.example.com ns1.example.com ns2.example.com;
    return       301 http://www.example.com$request_uri;
}

# Static subdomains. Redirect requests that are made to the root (e.g. http://static.example.com/) back to the original.
server {
    server_name s1.example.com s2.example.com s3.example.com;

    listen  80;

    access_log /var/log/nginx/example.access_log;
    error_log /var/log/nginx/example.error_log;

    root /home/example/public_html;

    include global/server.conf;

    location / {
        return 301 http://www.example.com$request_uri;
    }
}

server {
    server_name www.example.com;

    listen 80;
    # Uncomment for SSL support.
    # listen 443 default_server ssl;
    # ssl_certificate      /home/example/ssl/ssl.cert;
    # ssl_certificate_key  /home/example/ssl/ssl.key;

    access_log /var/log/nginx/example.access_log;
    error_log /var/log/nginx/example.error_log;

    root /home/example/public_html;

    include global/server.conf;

    location / {
        # Uncomment (after generating .htpasswd) for HTTP Basic Auth support.
        # auth_basic              "Login";
        # auth_basic_user_file    /home/example/.htpasswd;

        # Main PHP URL rewrite, modify for your needs.
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        # set this in /etc/php-fpm.d/YOUR-USER.conf
        fastcgi_pass 127.0.0.1:9001;

        # NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
    }

    # Prohibit some URL's (e.g. ones that meant to be accessed only locally).
    # location ~ /test/ {
    #     return 403;
    # }
}