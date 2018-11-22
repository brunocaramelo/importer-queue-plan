<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Http\UploadedFile;

use Stock\Plan\Services\ImportService;
use Stock\Products\Exceptions\ProductEditException;

class ImportPlanTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testBasicTest()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    public function test_upload_valid_file()
    {
        $file = $this->getPlanTestingFile( 'valid.xlsx' );
        
        $planImport = new ImportService( $file->path() ); 
        
        $this->assertEquals( $planImport->importProduct() , 
                            'Carga de produtos efetuada com sucesso' );
    }

    /**
     * @expectedException         \Stock\Products\Exceptions\ProductEditException
     * @expectedExceptionMessage Preencha o Código do Produto
     */
    public function test_upload_invalid_file()
    {
        $file = $this->getPlanTestingFile( 'invalid.xlsx' );
        
        $planImport = new ImportService( $file->path() ); 
        
        $this->assertEquals( $planImport->importProduct() , 
                            'Carga de produtos efetuada com sucesso' );
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

    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }


}
