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

//Displays csv file in table format
class htmlTable extends page {
    public function displayfile($filename) { 
        $this->html .= '<table style="border: 1px solid black;border-collapse: collapse;">';
        //echo "file uploaded ".$filename." successfuly";
        $file = fopen("./uploads/".$filename,"r");
        $index = 0;
        while(! feof($file)) { 
            $line = fgetcsv($file);  
            if(! empty($line)) {     
              if($index==0)  {            
                $this->displayHeader($line);             
                $index++;
              }
              else {                  
                $this->displayRow($line);             
              } 
            }      
        }        
        $this->html .= '</table>';
        fclose($file);
    }
    
    //Displays header of the table
    public function displayHeader($header) {
        $this->html .= '<tr style="border: 1px solid black;border-collapse: collapse;">';
        foreach($header as $key => $value) {         
           $this->html .='<th style="border: 1px solid black;border-collapse: collapse;">'.$value.'</th>';
        }  
        $this->html .= '</tr>';                  
    }

    //Displays all rows except header in table
    public function displayRow($row) {
        $this->html .= '<tr style="border: 1px solid black;border-collapse: collapse;">';
        foreach($row as $key => $value) {
            $this->html .='<td style="border: 1px solid black;border-collapse: collapse;">'.$value.'</td>';
        }  
        $this->html .= '</tr>';  
    }
}

?>