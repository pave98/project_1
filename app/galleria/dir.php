<?php 
function createArray(){
    $dir_path = 'C:/wamp64/www/project_1/app/images/uploads/';
    $array = array("");
    $index = 0;
        if(is_dir($dir_path)){
            $files = opendir($dir_path);
                if($files){
                    while(($file_name = readdir($files)) !== FALSE){
                        if(preg_match("/\.(jpeg|png|jpg)$/", $file_name)){
                            $array[$index] = $file_name;
                            $index++;
                            //json_encode($out)
                        }  
                    }
                }
        }
    return array_reverse($array);
}
?>