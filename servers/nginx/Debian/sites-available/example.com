# place in /etc/nginx/sites-available/ and symlink to /etc/nginx/sites-enabled/
server {
    server_name example.com *.example.com;

    access_log /var/log/nginx/example.access_log;
    error_log /var/log/nginx/example.error_log;

    root /home/example/public_html;
    
    include global/server.conf;
}