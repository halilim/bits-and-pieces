# Check DNS records from PHP
php -r "print_r(dns_get_record('example.com', DNS_ALL));"
