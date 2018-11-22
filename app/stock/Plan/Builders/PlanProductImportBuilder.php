<?php 

namespace Stock\Plan\Builders;
use Stock\Plan\Builders\PlanBuilder;

class PlanProductImportBuilder
{
    private $numberCollumns = 8;
    private $numberLineContent = 4;
    private $plan = null;

    public function __construct( $fileName )
    {
        $loader = new PlanBuilder();
        $this->plan = $loader->loadFile( $fileName )->getContent();
    }
    
    private function extractFromExcel()
    {
        
        $activeSheet = $this->plan->getActiveSheet();
        $highestRow  = $activeSheet->getHighestRow();
        
        $content = [];
        for( $row = $this->numberLineContent; $row <= $highestRow; ++ $row ){
            if( $this->checkLineEmpty( $activeSheet , $row ) === true ) break;
            for ( $col = 0; $col < $this->numberCollumns; ++ $col ) {
                $content[$row][] = $activeSheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $content;
    }

    private function addLines( $linesExcel )
    {
        $lines = [];
        $count = 0;
        foreach( $linesExcel as $originalLine ){
            $lines[$count] = [
                            'code'=> $originalLine[0],
                            'name'=> $originalLine[1],
                            'description' => $originalLine[3],
                            'price'=> $originalLine[4],
                        ];
            $count++;
        }
        $this->lines = $lines;
    }

    private function checkLineEmpty( $activeSheet ,$row )
    {
        for ( $col = 0; $col < $this->numberCollumns; ++ $col ) {
           if( $activeSheet->getCellByColumnAndRow( $col , $row )->getValue() != null)
                return false;   
        }
        return true;
    }

    public function getLines()
    {
        return $this->lines;
    }

    private function prepare()
    {
        $this->addLines( $this->extractFromExcel() );
    }

    public function build()
    {
        return $this->prepare();
    }
}