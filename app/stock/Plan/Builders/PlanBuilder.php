<?php

namespace Stock\Plan\Builders;

use PHPExcel;
use PHPExcel_IOFactory; 
use PHPExcel_Writer_Excel2007; 
use PHPExcel_Cell_DataValidation; 
use PHPExcel_Style_Protection; 

class PlanBuilder{

    private $plan = null;
    private $output = 'php://output';
    private $fileType = null;
    private $activePlan = 1;

    public function __construct()
    {
        $this->plan = new PHPExcel();
    }

    public function loadFile( $filename )
    {
        $this->inputFileType = PHPExcel_IOFactory::identify($filename);
        $load = PHPExcel_IOFactory::createReader($this->inputFileType);
        $this->plan =  $load->load( $filename );
        return $this;
    }

    public function getContent(){
        return $this->plan;
    }

    public function setPlan( $numberPage )
    {
        return $this->plan->setActiveSheetIndex( $numberPage );
    }

    public function setCell()
    {
        return $this->plan->getActiveSheet();
    }

    public function setCellKeyValue( $cellName, $cellValue )
    {
        return $this->plan->getActiveSheet()
                          ->setCellValue( $cellName, $cellValue );
    }

    public function PHPExcelStyleProtection(){

       return PHPExcel_Style_Protection::PROTECTION_PROTECTED;
            
    }
    
    public function getDataValidationTypeList(){

       return PHPExcel_Cell_DataValidation::TYPE_LIST;
            
    }
    public function getDataValidationStyleInfo(){

       return PHPExcel_Cell_DataValidation::STYLE_STOP;
            
    }

    public function generate()
    {
      $objWriter = PHPExcel_IOFactory::createWriter( $this->plan, $this->inputFileType );
      $objWriter = new PHPExcel_Writer_Excel2007($this->plan);
      return  $objWriter->save($this->output);        
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput( $output )
    {
        $this->output = $output;
    }

    public function build()
    {   
        return $this->generate();    
    }


}