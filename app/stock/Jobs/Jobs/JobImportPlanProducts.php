<?php

namespace Stock\Jobs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Stock\Plan\Services\ImportService;
use Stock\Products\Exceptions\ProductEditException;
use Stock\Jobs\Services\ImportJobService;

class JobImportPlanProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $importer = null;
    private $proccessStatus = null;
    private $idProc = null;
    
    public function __construct( ImportService $importer )
    {
        $this->importer = $importer;
        $this->proccessStatus = new ImportJobService();
        $retIns =  $this->proccessStatus->setProccess( basename( $this->importer->getFileName() ) );
        $this->idProc = $retIns->id;
    }

    public function handle()
    {
        try{        
            \DB::beginTransaction();
            $return = $this->importer->importProduct();
            \DB::commit();
            $this->proccessStatus->setSuccess( $this->idProc , $return );
            return true;
        }catch( ProductEditException $error ){
            \DB::rollback();
            $this->proccessStatus->setFail( $this->idProc , $error->getMessage() );
            return false;
        }
        
    }

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }
}
