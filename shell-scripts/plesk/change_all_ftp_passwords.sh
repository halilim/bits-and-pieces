#!/bin/sh
# http://8bitpipe.com/?p=293
# Generates 16 character passwords. Puts all logins and passwords into ftp_passwords file.
for i in $(mysql -NB psa -uadmin -p`cat /etc/psa/.psa.shadow` -e 'select login from sys_users;');
    do export PSA_PASSWD="$(openssl rand 12 -base64)";
    /usr/local/psa/admin/bin/usermng --set-user-passwd --user=$i;
    echo "$i: $PSA_PASSWD" >> ftp_passwords;
done