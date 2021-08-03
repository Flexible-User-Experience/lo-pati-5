-- Local exports to CSV

SELECT S.*
INTO OUTFILE '/tmp/slideshow.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.slider_image S
ORDER BY S.id;

SELECT A.*
INTO OUTFILE '/tmp/archive.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Arxiu A
ORDER BY A.id;

SELECT A.*
INTO OUTFILE '/tmp/artist.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Artista A
ORDER BY A.id;

SELECT C.*, P.data_publicacio, P.titol
INTO OUTFILE '/tmp/menulevel1.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Categoria C
LEFT JOIN lopati.Pagina P ON p.id = C.link_id
ORDER BY C.id;

SELECT SC.*, C.nom AS categoria, P.data_publicacio, P.titol
INTO OUTFILE '/tmp/menulevel2.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.SubCategoria SC
LEFT JOIN lopati.Categoria C ON C.id = SC.categoria_id
LEFT JOIN lopati.Pagina P ON p.id = SC.link_id
ORDER BY SC.id;

SELECT P.*, C.nom AS categoria, SC.nom AS subcategoria
INTO OUTFILE '/tmp/page.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.Pagina P
LEFT JOIN lopati.Categoria C ON C.id = P.categoria_id
LEFT JOIN lopati.SubCategoria SC ON SC.id = P.subCategoria_id
ORDER BY P.id;

SELECT NG.*
INTO OUTFILE '/tmp/newslettergroup.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.newsletter_groups NG
ORDER BY NG.id;

SELECT NU.*
INTO OUTFILE '/tmp/newsletteruser.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.newsletter_users NU
ORDER BY NU.id;

SELECT NGNU.*, NG.name, NU.email
INTO OUTFILE '/tmp/newslettergroupnewsletteruser.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.newslettergroup_newsletteruser NGNU
LEFT JOIN lopati.newsletter_groups NG ON NG.id = NGNU.newslettergroup_id
LEFT JOIN lopati.newsletter_users NU ON NU.id = NGNU.newsletteruser_id;

SELECT N.*, NG.name
INTO OUTFILE '/tmp/newsletter.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.isolated_newsletter N
LEFT JOIN lopati.newsletter_groups NG ON NG.id = N.newsletter_group_id
ORDER BY N.id;

SELECT NP.*, N.subject
INTO OUTFILE '/tmp/newsletterpost.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\r\n'
FROM lopati.isolated_newsletter_post NP
LEFT JOIN lopati.isolated_newsletter N ON N.id = NP.isolated_newsletter_id
ORDER BY NP.id;
