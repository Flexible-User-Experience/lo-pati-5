#!/bin/bash

echo "Bash build-csv-exports-files-from-old-local-database.sh commands"
echo "Started at $(date +"%T %d/%m/%Y")"
rm /tmp/*.csv
mysql --user=userflux -p -A lopati < ./scripts/database-exports/full-lopati-v1-export-local-queries.sql
mv /tmp/*.csv ./var/csv/imports/
php ./bin/console app:import:menu:level1 ./var/csv/imports/menulevel1.csv
php ./bin/console app:import:menu:level2 ./var/csv/imports/menulevel2.csv
php ./bin/console app:import:page ./var/csv/imports/page.csv
echo "Finished at $(date +"%T %d/%m/%Y")"
