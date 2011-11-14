#!/bin/bash
# Original src: http://www.cyberciti.biz/faq/mac-osx-unix-get-an-alert-when-my-disk-is-full/
# Src: https://github.com/halilim/shell-scripts/blob/master/hdLowWarn.sh
# Can be placed in /usr/local/bin
# Edit parts:
#	* FS - which mount point? e.g. / or /usr
#	* sysadmin@example.com - enter a real email address here
# After done editing, don't forget:
#	chmod +x hdLowWarn.sh
# For checking daily:
#	crontab -e
#	@daily /usr/local/bin/hdLowWarn.sh
FS="/"
THRESHOLD=90
OUTPUT=($(LC_ALL=C df -P ${FS}))
CURRENT=$(echo ${OUTPUT[11]} | sed 's/%//')
[ $CURRENT -gt $THRESHOLD ] && echo "Host: $HOSTNAME - Mount point: $FS - Use: %$CURRENT" | mail -s "$HOSTNAME $FS %$CURRENT full" sysadmin@example.com
