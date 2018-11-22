<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;

use Stock\Jobs\Jobs\JobImportPlanProducts;
use Stock\Plan\Services\ImportService;

class ImportPlanJobTest extends TestCase
{
    
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_import_success()
    {
        $file = $this->getPlanTestingFile( 'valid.xlsx' );
        $importPlan = new ImportService(
                                        $file->path()
                                    ); 
            
        Queue::fake();
        
        Queue::pushed( JobImportPlanProducts::class , function ( $job ) use ( $importPlan ) {
            return  $job;
        });
        
    }

    public function getPlanTestingFile( $fileName )
    {
        $file =  __DIR__ . '/../Stub/Files/' . $fileName;
        return new UploadedFile( $file, 
                                $fileName, 
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                                filesize( $file ) , 
                                $error = null, 
                                $testMode = true );
    }
}
