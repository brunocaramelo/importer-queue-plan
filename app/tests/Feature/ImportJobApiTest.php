<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Http\UploadedFile;


class ImportJobApiTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_edit_item()
    {   
        $this->test_upload_file();
        
        $this->get('/api/v1/upload/check-proccess/1',[     
                                                        "id" => "1",
                                                    ])
                ->assertStatus(200)
                ->assertJson( [
                                "id"=> 1,
                                "file_name"=> "valid_api.xlsx",
                                "return_message"=> null,
                                "status_process"=> "pendent",
                                "status_import"=> "pendent"
                              ]);
    }
    
    public function test_list_items()
    {   
        $this->test_upload_file();
        $this->get('/api/v1/upload/check-proccess/',[ ])
                ->assertStatus(200)
                ->assertJson([ 0 =>[
                                    "id"=> 1,
                                    "file_name"=> "valid_api.xlsx",
                                    "return_message"=> null,
                                    "status_process"=> "pendent",
                                    "status_import"=> "pendent"
                                ]
                            ]);
    }

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    public function test_upload_file()
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


}
