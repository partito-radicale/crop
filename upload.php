<?php
session_start();

//
//  Crop&Merge by Vincent40 -using Jcrop and others- 
//

$max_image=200000; // grandezza massima immagine
if ($_POST["label"]) {
    $label = $_POST["label"];
}
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < $max_image)
&& in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
        $filename = $label.$_FILES["file"]["name"];
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

        $filename_part=rand(1,32000);	//genera un numero casuale tra 1 e 32000, tipo 12345	
        $filename="".$filename_part.".".$extension;//assegna un nome al file, del tipo 12345.jpg
        $_SESSION['namez'] = "".$filename_part;
        $_SESSION['extensionz'] = $extension;
        if (file_exists("temporanei/" . $filename)) {
            echo $filename . " already exists. ";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"],
            "temporanei/" . $filename);
            echo "Stored in: " . "temporanei/" . $filename;
        }
    }
} else {
    echo "Invalid file";
}

?>