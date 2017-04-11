<?php

//
//  Crop&Merge by Vincent40 -using Jcrop and others- 
//

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$sorgente= "/crop/temporanei/".$_SESSION['namez'].".".$_SESSION['extensionz'];
	$destinazione= $_SESSION['namez'].'new-image.jpg'; 
	$targ_w = $targ_h = 1200;//650;
	$jpeg_quality = 90;
	$src = $sorgente;

	$extensionI = pathinfo($src, PATHINFO_EXTENSION); 
	switch ($extensionI) {
		case 'jpg':
		case 'jpeg':
			$img_r = imagecreatefromjpeg($src);
		break;
		case 'gif':
			$img_r = imagecreatefromgif($src);
		break;
		case 'png':
			$img_r = imagecreatefrompng($src);
		break;
	}

	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	imagejpeg($dst_r, $destinazione, 100);
   
	$extension = pathinfo($destinazione, PATHINFO_EXTENSION); 
	switch ($extension) {
		case 'jpg':
		case 'jpeg':
			$image = imagecreatefromjpeg($destinazione);
		break;
		case 'gif':
			$image = imagecreatefromgif($destinazione);
		break;
		case 'png':
			$image = imagecreatefrompng($destinazione);
		break;
	}

	$myprova=$_SESSION['namez'].'prova.png';
	imagepng($image, $myprova);
	imagedestroy($image);

	$mypathprova="/crop/".$myprova;
	$stars=imagecreatefrompng($mypathprova);

	$gradient=imagecreatefrompng("/crop/upper.png");

	imagecopy($stars, $gradient, 0, 0, 0, 0, 1200, 1200);
   
	$nomeradicali='radicaliimages/'.$_SESSION['namez'].'.png';

	imagepng($stars, $nomeradicali);
  
	imagedestroy($stars);
	imagedestroy($gradient);

	$_SESSION['myimage']="/crop/".$nomeradicali;
	$_SESSION["radicale"] = true;
	
	unlink($destinazione);
	$sorgente2=$_SERVER['DOCUMENT_ROOT']."crop/temporanei/".$_SESSION['namez'].".".$_SESSION['extensionz'];
	unlink($sorgente2);
	unlink($myprova);
}


?><!DOCTYPE html>
<html lang="en">
<head>
  <title>CropAndMerge</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="main.css" type="text/css" />
  <link rel="stylesheet" href="demos.css" type="text/css" />
  <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />

  <script src="js/load-image.js"></script>
  
  <script type="text/javascript">
		var mysetfile="";

		$(function(){

			$('#cropbox').Jcrop({
				aspectRatio: 1,
				onSelect: updateCoords
			});

		});

		function updateCoords(c)
		{
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
		};

		function checkCoords()
		{
			if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
			return false;
		};

		function loadImage(){
			document.getElementById('file-input').onchange = function (e) {
				loadImage(
					e.target.files[0],
					function (img) {
						$("#cropbox").attr('src', img);
					},
					{maxWidth: 600} // Options
				);
			};
        }
</script>

<script type="text/javascript">
        function submitForm() {
            console.log("submit event");
            var fd = new FormData(document.getElementById("fileinfo"));
            fd.append("label", "RADICALI");
            $.ajax({
              url: "upload.php",
              type: "POST",
              data: fd,
              processData: false,  // tell jQuery not to process the data
              contentType: false,   // tell jQuery not to set contentType
			  
			  success: function(data, textStatus) {
			  
			  		mysetfile="gix6.png";
		
			        var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
           
                                    }
                    };
					var filename = $('input[type=file]').val().split('\\').pop();
         
					xmlhttp.open("GET", "/crop/session_write.php?session_name=" + filename, true);// + str
                    xmlhttp.send();					
			        window.location.href =  "/crop/crop.php";
               }
			  
            }).done(function( data ) {
                console.log("PHP Output:");
                console.log( data );
            });
	
            return false;
        }
    </script>
	
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>



</head>
<body>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">

<div class="page-header">
<ul class="breadcrumb first">
 
  <li><a href="http://www.radicalparty.org/it">Radicalparty</a> <span class="divider">/</span></li>
  <li class="active">Tesseramento</li>
</ul>
<h1>Partito Radicale - tessera digitale</h1>
</div>
		
<?php		

	if ($_SESSION["myimage"] == "") {
		echo '<img src="gigi.png" id="cropbox" />';
	} else {
		if($_SESSION["radicale"] == true){//vuol dire che è stato fatto il crop ed imagecopy
			echo '<img src="'.$_SESSION["myimage"].'" alt="" width="500" height="500"/>';  
			$_SESSION["radicale"] == false;
		}else{
			echo '<img src="/crop/temporanei/'.$_SESSION['namez'].'.'.$_SESSION['extensionz'].'" id="cropbox" />';
		}
	}

	if($_SESSION["radicale"] == true){//vuol dire che è stato fatto il crop ed imagecopy
	}else{
		echo '<form action="crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>';		
	}
?>
		

		<p>
			<b>.: Crea la tua tessera digitale:. </b> Seleziona da <i>Scegli file</i>
			la tua immagine e caricala con  <i>Upload</i>, successivamente ritaglia la parte della foto che intendi utilizzare e premi il pulsante <i>Ritaglia</i>
		</p>


	</div>
	</div>
	</div>
	
	    <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
        <label>Seleziona una immagine:</label><br>
        <input type="file" name="file" class="btn btn-large btn-inverse" required />
        <input type="submit" value="Upload"  class="btn btn-large btn-inverse"/>
    </form>
    <div id="output"></div>
	</div>
	</body>
</html>
