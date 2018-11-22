<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan as Artisan;

use Stock\Jobs\Services\ImportJobService;

class ProccessCheckerTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_new_proccess()
    {
        $expected =  [  
                        'id' => 1,
                        'file_name' => 'valid.xlxs',
                        'executed_at' => null,
                        'return_message' => null,
                        'status_process' => 'pendent',
                        'status_import' => 'pendent',
                    ];
        $procService = new ImportJobService();
        $procService->setProccess( 'valid.xlxs' );
        $result = $procService->getById( 1 )->toArray(); 
        unset($result['reserved_at']);
        $this->assertEquals( $result , $expected );
    }

    public function test_update_success()
    {
        $this->test_new_proccess();
        $expected =  [  
                        'id' => 1,
                        'file_name' => 'valid.xlxs',
                        'return_message' => 'Mensagem de sucesso',
                        'status_process' => 'success',
                        'status_import' => 'success',
                    ];
        $procService = new ImportJobService();
        $procService->setSuccess( 1 ,'Mensagem de sucesso' );
        $result = $procService->getById( 1 )->toArray(); 
        unset( $result['reserved_at'] , $result['executed_at'] );
        $this->assertEquals( $result , $expected );
    }
    
    public function test_update_fail()
    {
        $this->test_new_proccess();
        $expected =  [  
                        'id' => 1,
                        'file_name' => 'valid.xlxs',
                        'return_message' => 'Mensagem de erro',
                        'status_process' => 'success',
                        'status_import' => 'fail',
                    ];
        $procService = new ImportJobService();
        $procService->setFail( 1 ,'Mensagem de erro' );
        $result = $procService->getById( 1 )->toArray(); 
        unset( $result['reserved_at'] , $result['executed_at'] );
        $this->assertEquals( $result , $expected );
    }

    public function test_list()
    {
        $this->test_new_proccess();
        $expected =  [ [ 
                        'id' => 1,
                        'file_name' => 'valid.xlxs',
                        'return_message' => 'Mensagem de sucesso',
                        'status_process' => 'success',
                        'status_import' => 'success',
                        ]
                    ];
        $procService = new ImportJobService();
        $procService->setSuccess( 1 ,'Mensagem de sucesso' );
        $result = $procService->all( )->toArray(); 
        unset( $result[0]['reserved_at'] , $result[0]['executed_at'] );
        $this->assertEquals( $result , $expected );
    }

    public function test_item()
    {
        $this->test_new_proccess();
        $expected =  [  
                        'id' => 1,
                        'file_name' => 'valid.xlxs',
                        'return_message' => null,
                        'status_process' => 'pendent',
                        'status_import' => 'pendent',
                    ];
        $procService = new ImportJobService();
        $result = $procService->getById( 1 )->toArray(); 
        unset( $result['reserved_at'] , $result['executed_at'] );
        $this->assertEquals( $result , $expected );
    }
    
    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
