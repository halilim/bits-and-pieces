# place in /etc/nginx/sites-available/ and symlink to /etc/nginx/sites-enabled/
server {
        server_name example.com *.example.com;

        access_log /var/log/nginx/example.access_log;
        error_log /var/log/nginx/example.error_log;

        root /home/example/public_html;

        location ~ .php$ {
                try_files $uri =404;
                fastcgi_pass   127.0.0.1:9000;
                fastcgi_index  index.php;
                include fastcgi_params;
                fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
        location / {
                try_files       $uri $uri/ /index.php;
        }
        location ~* \.(?:ico|css|js|gif|jpe?g|png)$ {
                # Some basic cache-control for static files to be sent to the browser
                expires 30d;
                add_header Pragma public;
                add_header Cache-Control "public, must-revalidate, proxy-revalidate";
                access_log off;
                log_not_found off;
        }
        location ~ /\. { access_log off; log_not_found off; deny all; }
}r