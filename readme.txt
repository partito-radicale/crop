//
//  Crop&Merge by Vincent40 -using Jcrop and others- 
////

18 marzo 2017

:: web app minimale per la copia di files sovrapposti ed il cropping ::
:: scritto per il mio amico Adriano ::

Scaricare la cartella 'crop' nella Home, 
aviare la web app dal browser, all'indirizzo:
http://www.tuoserver.com/crop/crop.php
(per funzionare serve solo PHP 5)

L'applicazione permette di selezionare un file locale (di tipo jpg, gif o png e lo scrive in temporanei/),
di selezionare successivamente l'area interessata e di copiare sull'area un'altra immagine (upper.png)
per ricavarne un file finale di tipo png (scritto in radicaliimages/).
Durante l'elaborazione crea e cancella alcuni files sul server.
La grandezza massima dell'immagine da caricare è impostata nella variabile $max_image del file 'upload.php',
impostata di default a 200000 (200kb).

Durante il processo di upload e prima del cropping avremo sul server:

-home
12345new-image.jpg
12345prova.png 
	-temporanei/
		12345.jpg
	-radicaliimages/
		12345.png


Alla fine del processo di cropping avremo sul server:

-home
	-temporanei/
	-radicaliimages/
		12345.png