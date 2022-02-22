#!/bin/bash

echo "Bash build-csv-exports-files-from-old-local-database.sh commands"
echo "Started at $(date +"%T %d/%m/%Y")"
rm /tmp/*.csv
mysql --user=userflux -p -A lopati < ./scripts/database-exports/full-lopati-v1-export-local-queries.sql
mv /tmp/*.csv ./var/csv/imports/
php ./bin/console app:import:archive ./var/csv/imports/archive.csv
php ./bin/console app:import:artist ./var/csv/imports/artist.csv
php ./bin/console app:import:artist:translations ./var/csv/imports/artist_translations.csv
php ./bin/console app:import:menu:level1 ./var/csv/imports/menulevel1.csv
php ./bin/console app:import:menu:level1:translations ./var/csv/imports/menulevel1_translations.csv
php ./bin/console app:import:menu:level2 ./var/csv/imports/menulevel2.csv
php ./bin/console app:import:menu:level2:translations ./var/csv/imports/menulevel2_translations.csv
php ./bin/console app:import:page ./var/csv/imports/page.csv
php ./bin/console app:import:page:translations ./var/csv/imports/page_translations.csv
php ./bin/console app:import:fetch:page:menu:level1 ./var/csv/imports/menulevel1.csv
php ./bin/console app:import:fetch:page:menu:level2 ./var/csv/imports/menulevel2.csv
php ./bin/console app:import:newsletter:group ./var/csv/imports/newslettergroup.csv
php ./bin/console app:import:newsletter:user ./var/csv/imports/newsletteruser.csv
php ./bin/console app:import:fetch:newsletter:group:user ./var/csv/imports/newslettergroupnewsletteruser.csv
php ./bin/console app:import:newsletter ./var/csv/imports/newsletter.csv
php ./bin/console app:import:newsletter:post ./var/csv/imports/newsletterpost.csv
php ./bin/console app:import:config:calendar:working:day ./var/csv/imports/configcalendarworkingday.csv
php ./bin/console fos:elastica:populate
cp -r ../lo-pati/web/uploads/artists/* public/uploads/artists/
cp ../lo-pati/web/uploads/slides/* public/uploads/slides/
cp ../lo-pati/web/uploads/isolated-newsletter/* public/uploads/newsletters/
cp ../lo-pati/web/uploads/images/* public/uploads/images/
cp ../lo-pati/web/uploads/documents/* public/uploads/documents/
php ./bin/console app:initialize:visiting:hours
echo "Finished at $(date +"%T %d/%m/%Y")"
