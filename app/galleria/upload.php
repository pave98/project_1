<?php
$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.
$uploadOk = 1;
$textCounter = 0;
// Count # of uploaded files in array
$total = count($_FILES['upload']['name']);

//Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {

//Get the temp file path
$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
$filename = $_FILES['upload']['name'][$i];
$fileEnd = explode('.', $filename);
 
if(!preg_match("/\.(jpeg|png|jpg)$/", $filename)){
    echo "Sorry, only JPG, JPEG & PNG files are allowed. ";
    $uploadOk = 0;
}
if($uploadOk == 1){
//Make sure we have a file path
    if($tmpFilePath != ""){
        //Setup our new file path   
        $directory2 = $_SERVER['DOCUMENT_ROOT']."/project_1/app/images/uploads/ ";
        //$directory2 = str_replace(' ','_',$directory1);
        $newFilePath = $directory2 . $_FILES['upload']['name'][$i];
        echo $newFilePath."<br>";

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            if($textCounter === 0){
                header('Refresh: 3; url = /project_1/app/galleria/');
                echo "Image(s) uploaded! Redirecting...";
                $textCounter = 1;
            }
        }
    }
  }else{
      header('Refresh: 5; url = /project_1/app/galleria/');
      echo"Upload unsuccessful. Redirecting...";
  }
}
?>