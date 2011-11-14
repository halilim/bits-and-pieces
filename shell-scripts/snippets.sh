# Check DNS records from PHP
php -r "print_r(dns_get_record('example.com', DNS_ALL));"

# Defrag C and D drives & shutdown - for Windows (save as *.cmd/*.bat)
defrag C: D: /H /U /V /X > %USERPROFILE%\Desktop\defrag_%date%.log
shutdown /s