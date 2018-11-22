<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Http\UploadedFile;

use Stock\Plan\Services\ImportService;

class ImportPlanJobApiTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_import_item()
    {   
        $this->post('/api/v1/upload/',[     
                                         'file' => $this->getPlanTestingFile( 'valid_api.xlsx' )
                                         ])
                 ->assertStatus(200)
                 ->assertJson(["status" => "200",
                                "message" => "Envio efetuado com sucesso, aguarde o processamento",
                                "data" => null
                            ]);
    }

    public function getPlanTestingFile( $fileName )
    {
        $fileValid =  __DIR__ . '/../Stub/Files/valid.xlsx' ;
        $file =  __DIR__ . '/../Stub/Files/' . $fileName;
        copy( $fileValid , $file );
        return new UploadedFile( $file, 
                                $fileName, 
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                                filesize( $file ) , 
                                $error = null, 
                                $testMode = true );
    }

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }


}
