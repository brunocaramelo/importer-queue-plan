<?php

namespace Stock\Jobs\Services;

use Stock\Jobs\Entities\JobsProductsStatusEntity;
use Stock\Jobs\Repositories\JobsProductsStatusRepository;

class ImportJobService
{   
    private $rep;
    public function __construct()
    {
        $this->rep = new JobsProductsStatusRepository( new JobsProductsStatusEntity() );
    }

    public function all()
    {
       return $this->rep->getList();
    }
    
    public function getById( $idProcess )
    {
       return $this->rep->find( $idProcess );
    }
        
    private function setNew(  $file )
    {
       return $this->rep->create( $file );
    }

    private function setStatus( $idProc , $message , $status )
    {
       return $this->rep->update( $idProc , $message , $status );
    }
    
    public function setFail( $idProc , $message )
    {
       return $this->setStatus( $idProc , $message  , 'fail' );
    }
    
    public function setProccess( $file )
    {
       return $this->setNew( $file  , 'pendent' );
    }
    
    public function setSuccess( $idProc , $message )
    { 
        return $this->setStatus( $idProc , $message , 'success' );
    }


}