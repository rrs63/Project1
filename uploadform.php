<?php
abstract class page {
    protected $html;

    public function __construct() {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct() {
        $this->html .= '</body></html>';
        //stringFunctions::printThis($this->html);
        echo $this->html;
    }

    public function get() {
        echo 'default get message';
    }

    public function post() {
        print_r($_POST);
    }
}


class uploadform extends page
{
    private $error;
    public function get() {
        $form = '<form action="index.php?page=uploadform" method="post"
    enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload"><br><br>';
        $form .= '<input type="submit" value="Upload" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;

    }

    
    //Validates and uploads csv file
    public function uploadFile() {
        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $csvFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            
        // Check if file already exists
        if (file_exists($target_file)) {            
            $this->error = '<h1>Sorry, file already exists.</h1>';
            $uploadOk = 0;
        }
            
        // Allow certain file formats
        if($csvFileType != "csv") {           
            $this->error .= '<h1>Sorry, only csv files are allowed.</h1>';
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {                    
            $this->html = $this->error;
        // if everything is ok, try to upload file
        } else {
            //Upload file - If successful it will redirect to another page and displays csv file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file)) {                      
                header('Location: index.php?page=htmlTable&filename='.$_FILES["fileToUpload"]["name"]);              
            } else {                 
                $this->html = '<h1>Sorry, there was an error uploading your file.</h1>';
            }
        }
    }   
}
?>