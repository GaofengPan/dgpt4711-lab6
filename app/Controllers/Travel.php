<?php
namespace App\Controllers;
class Travel extends BaseController {
public function index() { 
    
    // connect to the model
    $places = new \App\Models\Places(); // retrieve all the records 
    $records = $places->findAll();
    // get a template parser
    $parser = \Config\Services::parser(); // tell it about the substitions
    //step1
    $table = new \CodeIgniter\View\Table(); 
    $headings = $places->fields; 
    $displayHeadings = array_slice($headings, 1, 2); 
    $table->setHeading(array_map('ucfirst', $displayHeadings));
    foreach ($records as $record) { 
        //$table->addRow($record->name,$record->description); 
        $nameLink = anchor("travel/showme/$record->id",$record->name); 
        $table->addRow($nameLink,$record->description); 
    } 
    //step2
    $template = [ 'table_open' => '<table cellpadding="2px">',
        'cell_start' => '<td style="border: 1px solid #dddddd;">',
        'row_alt_start' => '<tr style="background-color:#dddddd">', ]; 
    $table->setTemplate($template);
    $fields = [           
        'title' => 'Travel Destinations',     
        'heading' => 'Travel Destinations',         
        'footer' => 'Copyright GaofengPan'         ];
    return $parser->setData($fields)               
                    ->render('templates\top') .      
            $table->generate() .          
            $parser->setData($fields)
                    ->render('templates\bottom');
    
    
    /*return $parser->setData(['records' => $records])  
// and have it render the template with those  
        ->render('placeslist');*/
    }
public function showme($id)
{ 
    // connect to the model
    $places = new \App\Models\Places(); 
    // retrieve all the records 
    $record = $places->find($id);
    // get a template parser
    $parser = \Config\Services::parser();
    // tell it about the substitions
    
    //step1
    $table = new \CodeIgniter\View\Table(); 
    $headings = $places->fields;
    $headings=array_map('ucfirst', $headings);
    $table->addRow($headings[0],$record["id"]);
    $table->addRow($headings[1],$record["name"]);
    $table->addRow($headings[2],$record["description"]);
    $table->addRow($headings[3],$record["link"]);
    $table->addRow($headings[4],"<img src='/image/".$record['image'].'\'/>');
    
     //step2
    $template = [ 'table_open' => '<table cellpadding="2px">',
        'cell_start' => '<td style="border: 1px solid #dddddd;">',
        'row_alt_start' => '<tr style="background-color:#dddddd">', ]; 
    $table->setTemplate($template);
    $fields = [           
        'title' => 'Travel Destinations',     
        'heading' => 'Travel Destinations',         
        'footer' => 'Copyright GaofengPan'         
        ];
    return $parser->setData($fields)               
                    ->render('templates\top') .      
            $table->generate() .          
            $parser->setData($fields)
                    ->render('templates\bottom');
    
    
    /*return $parser->setData($fields)
// and have it render the template with those  
        ->render('oneplace');*/
}
  
}
