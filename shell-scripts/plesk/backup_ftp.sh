#!/bin/sh
# Create the folders before use (/usr/local/src/backup/sql and /usr/local/src/backup/web).
# Replace uppercase parts accordingly.
# cron at 01:00 daily: 0 1 * * * /usr/local/src/backup/backup_ftp.sh

find /usr/local/src/backup/sql -mtime +7 -type f -name "*" -exec rm -f '{}' \;

rsync -uvaH /var/www/vhosts/DOMAIN --exclude=/var/www/vhosts/DOMAIN/statistics /usr/local/src/backup/web
# ... (additional domains)

mysqldump -uadmin -pMYSQL_PWD DATABASE > /usr/local/src/backup/sql/DATABASE_`date -I`.sql
# ... (additional databases)

tar -zcvf /usr/local/src/backup/sql.tar.gz /usr/local/src/backup/sql
tar -zcvf /usr/local/src/backup/web.tar.gz /usr/local/src/backup/web
tar -zcvf /usr/local/src/backup/etc.tar.gz /etc

cd /usr/local/src/backup
ftp -n -i BACKUP_SRV_IP <<!
quote user FTP_USER
quote pass FTP_PASS
binary
cd BACKUP_DIR
put sql.tar.gz
put etc.tar.gz
put web.tar.gz
quit
!