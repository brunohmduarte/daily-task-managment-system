#!/bin/bash

if [ $# -lt 1 ]; then
    echo "Usage: $0 <project-name>"
    exit 1
fi

FOLDER="$HOME/projects/stores"
WORKSPACE_FILENAME="$1.code-workspace"


# Removing project folder...
if [ -d "$FOLDER" ]; then
    echo "Removing project folder..."
    rm -rf "$FOLDER/$1"
fi

# Removing project worksapce...
if [ -f "$FOLDER/$WORKSPACE_FILENAME" ]; then
    echo "Removing project worksapce file..."
    rm -f "$FOLDER/$WORKSPACE_FILENAME"
fi

# Removing database...
echo "Removing database..."
docker exec -it devilbox_mysql_1 /usr/bin/mysql -hmysql -uroot -pmagento -e "DROP DATABASE IF EXISTS $1;"

echo "Done!"
