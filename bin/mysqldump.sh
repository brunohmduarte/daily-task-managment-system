#!/bin/sh

# MySQL database connection data
DBHOST="127.0.0.1"
DBNAME="daily"
DBUSER="root"
PASSWORD="magento"
CHARSET="utf8"

DATE_CURRENT=$(date '+%Y%m%d')
ROOT_FOLDER="$HOME/.corsair/projects/daily"
BACKUPFOLDER="$ROOT_FOLDER/backups"
BACKUP_FILEPATH="$BACKUPFOLDER/db_"$DBNAME"_"$DATE_CURRENT".sql"
FILE_LOG="$ROOT_FOLDER/var/log/backup.log"

echo "mysqldump started at $(date +'%Y-%m-%d %H:%M:%S')" >> "$FILE_LOG"
docker exec devilbox_mysql_1 /usr/bin/mysqldump -h$DBHOST -u$DBUSER -p$PASSWORD daily > $BACKUP_FILEPATH

echo "old files deleted" >> "$FILE_LOG"
find "$BACKUPFOLDER" -name "db_"$DBNAME"_"* -mtime +8 -exec rm {} \;

echo "operation finished at $(date +'%Y-%m-%d %H:%M:%S')" >> "$FILE_LOG"
echo "" >> "$FILE_LOG"
