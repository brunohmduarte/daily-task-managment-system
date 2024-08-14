#!/bin/sh

# MySQL database connection data
DBHOST="127.0.0.1"
DBNAME="daily"
DBUSER="root"
PASSWORD=""
CHARSET="utf8"


DATE_CURRENT=$(date '+%Y%m%d%H%M%S')
FILENAME="db_"$DBNAME"_"$DATE_CURRENT".sql.tar.gz"
ROOT_FOLDER="/home/bruno/projects/stores/daily"
BACKUPFOLDER="$ROOT_FOLDER/backups"
BACKUP_FILEPATH="$BACKUPFOLDER/$FILENAME"
FILE_LOG="$ROOT_FOLDER/var/log/$(date +'%Y_%m_%d').log"

echo "mysqldump started at $(date +'%Y-%m-%d %H:%M:%S')" >> "$FILE_LOG"

#mysqldump --user=$DBUSER --password=$PASSWORD --default-character-set=$CHARSET --single-transaction $DBNAME | gzip > "$BACKUP_FILEPATH"
mysqldump -h $DBHOST -u$DBUSER -p$PASSWORD --default-character-set=$CHARSET --single-transaction $DBNAME | gzip > "$BACKUP_FILEPATH"

echo "mysqldump finished at $(date +'%Y-%m-%d %H:%M:%S')" >> "$FILE_LOG"

chown bruno "$BACKUP_FILEPATH"
chown bruno "$FILE_LOG"

echo "file permission changed" >> "$FILE_LOG"

find "$BACKUPFOLDER" -name db_$DBNAME_* -mtime +8 -exec rm {} \;

echo "old files deleted" >> "$FILE_LOG"
echo "operation finished at $(date +'%Y-%m-%d %H:%M:%S')" >> "$FILE_LOG"
echo "*****************" >> "$FILE_LOG"