-- Local exports to CSV

SELECT S.*
INTO OUTFILE '/var/lib/mysql-files/slideshow.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.slider_image S
ORDER BY S.id;

SELECT A.*
INTO OUTFILE '/var/lib/mysql-files/archive.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Arxiu A
ORDER BY A.id;

SELECT A.*
INTO OUTFILE '/var/lib/mysql-files/artist.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Artista A
ORDER BY A.id;

SELECT C.*
INTO OUTFILE '/var/lib/mysql-files/menulevel1.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Categoria C
ORDER BY C.id;

SELECT SC.*, C.nom AS categoria
INTO OUTFILE '/var/lib/mysql-files/menulevel2.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.SubCategoria SC
LEFT JOIN lopati.Categoria C ON C.id = SC.categoria_id
ORDER BY SC.id;

SELECT P.*, C.nom AS categoria, SC.nom AS subcategoria
INTO OUTFILE '/var/lib/mysql-files/page.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Pagina P
LEFT JOIN lopati.Categoria C ON C.id = P.categoria_id
LEFT JOIN lopati.SubCategoria SC ON SC.id = P.subCategoria_id
ORDER BY P.id;
