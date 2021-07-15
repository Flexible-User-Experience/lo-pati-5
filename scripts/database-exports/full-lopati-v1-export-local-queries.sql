-- Local exports to CSV

SELECT C.*
INTO OUTFILE '/tmp/menulevel1.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Categoria C
ORDER BY C.id;

SELECT SC.*, C.nom AS categoria
INTO OUTFILE '/tmp/menulevel2.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.SubCategoria SC
JOIN lopati.Categoria C ON C.id = SC.categoria_id
ORDER BY SC.id;

SELECT P.*, C.nom AS categoria, SC.nom AS subcategoria
INTO OUTFILE '/tmp/page.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Pagina P
JOIN lopati.Categoria C ON C.id = P.categoria_id
JOIN lopati.SubCategoria SC ON SC.id = P.subCategoria_id
ORDER BY P.id;
