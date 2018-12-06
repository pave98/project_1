<?php
$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.
$uploadOk = 1;
$textCounter = 0;
// Count # of uploaded files in array
$total = count($_FILES['upload']['name']);

// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {

//Get the temp file path
$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
$filename = $_FILES['upload']['name'][$i];
$fileEnd = explode('.', $filename);
 
if(!preg_match("/\.(jpeg|png|jpg)$/", $filename)){
    echo "Sorry, only JPG, JPEG & PNG files are allowed. ";
    $uploadOk = 0;
}
if($uploadOk){
//Make sure we have a file path
    if($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = "C:\wamp64\www\project_1\app\images\uploads\ " . $_FILES['upload']['name'][$i];

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            if($textCounter === 0){
                header('Refresh: 3; url = http://localhost/project_1/app/galleria/');
                echo "Image(s) uploaded! Redirecting...";
                $textCounter = 1;
            }
        }
    }
  }else{
      header('Refresh: 3; url = http://localhost/project_1/app/galleria/');
      echo"Upload unsuccessful. Redirecting...";
  }
}
?>