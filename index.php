<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//error_reporting( error_reporting() & ~E_NOTICE )
//instantiate the program object

//Class to load classes it finds the file when the program starts to fail for calling a missing class
class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));

//instantiate the program object
$obj = new main();


class main {

    public function __construct()
    {
        //print_r($_REQUEST);
        //set default page request when no parameters are in URL
        $pageRequest = 'uploadform';
        
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }        
        
        //instantiate the class that is being requested
        $page = new $pageRequest;

        //Proper method is called based on get or post method
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if($pageRequest=='uploadform')
                $page->get();
            else
                $page->displayFile($_GET['filename']);
        } else {        
            $page->uploadFile();           
        }
    }
}
?>