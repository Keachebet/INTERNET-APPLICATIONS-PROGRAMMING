<?php
class  UploaderFile{
    private static $target_directory = "uploads/";
    private static $size_limit = 500000;
    private $file_original_name;
    private $file_type;
    private $file_size;
    private $final_file_name;
    private $target_file;

    /**getters and setters */
    public function setOriginalName($name){
        $this->file_original_name = $name;
    
    }
    public function getOriginalName(){
        return $this->file_original_name;
    }
    public function setFileType($type){
        $this->file_type = $type;
    }
    public function getFileType(){
        return $this->file_type;
    }
    public function setFileSize($size){
        $this->file_size = $size;
    }
    public function getFileSize(){
        return $this->file_size;
    }
    public function setFinalFileName($final_name){
        $this->final_file_name = $final_name;
    }
    public function getFinalFileName(){
        return $this->final_file_name;
    }
    /**methods */
    public function uploadFile(){
        if($this->fileWasSelected()){
        $this->target_file = self::$target_directory . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
            if($this->fileTypeIsCorrect()){
                if($this->fileSizeIsCorrect()){
                    if(!$this->fileAlreadyExists()){
                        return $this->saveFilePathTo();
                    }
                }
            }
        }
        else{ return false;}
    }
    public function fileAlreadyExists(){
        if (file_exists($this->target_file)) {
            echo "Sorry, file already exists.";
            return true;
          }else{ return false; }
    }
    public function saveFilePathTo(){
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->target_file)){
            echo" your file was uploaded successfully";
            return true;
        }else{ echo" Sorry :( your file was not uploaded check it and try again ";return false; }
    }
    public function moveFile(){}
    public function fileTypeIsCorrect(){
        // Check if image file is what you want to upload
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            return true;
        } else {
            echo "File is not an image.";
            return false;
        }
    }
    public function fileSizeIsCorrect(){
        $this->file_size = $_FILES["fileToUpload"]["size"];
        if ($this->getFileSize() > self::$size_limit) {
            echo "Sorry, your file is too large.";
            return false;
          }else{ return true; }

    }
    public function fileWasSelected(){
    if(empty($_FILES["fileToUpload"])){
        echo "please select a file first!";
        return false;
    }else{ return true; }
    }
}



?>