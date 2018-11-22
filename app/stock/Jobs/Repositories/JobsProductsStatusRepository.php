<?php 

namespace Stock\Jobs\Repositories;

use Stock\Jobs\Entities\JobsProductsStatusEntity;


class JobsProductsStatusRepository
{
    private $proccess = null;
  
    public function __construct( JobsProductsStatusEntity $proccess )
    {
        $this->proccess = $proccess;
    }

    public function getList()
    {
        return $this->proccess->get();
    }

    public function find( $identify )
    {
        return $this->proccess->find( $identify );
    }

    public function findBy( $field , $value )
    {
        return $this->proccess->where( $field , $value );
    }
    
    public function create( $file )
    {
        $now = new \DateTime();
        return $this->proccess->create( [
                                            'file_name' => $file ,
                                            'reserved_at' => $now->format('Y-m-d H:i:s') ,
                                            'status_process' => 'pendent',
                                            'status_import' => 'pendent'
                                        ] );
    }

    public function update( $identify , $message , $status )
    {
        $now = new \DateTime();
        $proccessSave = $this->proccess->find($identify);
        return $proccessSave->fill( [
                                        'executed_at' => $now->format('Y-m-d H:i:s') ,
                                        'status_process' => 'success',
                                        'status_import' => $status ,
                                        'return_message' => $message
                                  ] )->save();
    }

}