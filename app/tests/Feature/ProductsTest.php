<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan as Artisan;

use Stock\Products\Services\ProductService;

class ProductTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_list_prod_default()
    {
        $expected = [  [  
                            'prod_id' => '1',
                            'prod_name' => 'Carrinho de metal',
                            'prod_description' => 'carrinho brinquedo',
                            'prod_code' => '301',
                            'prod_price' => '50.6',
                            ]
                    ];
        $productService = new ProductService();
       
        $this->assertEquals( $productService->getList()->toArray() , $expected );
    }

    public function test_update_prod()
    {
        $expected = [   "id" => 1,
                        "name" => "Carrinho de metal Mudei",
                        "description" => "carrinho brinquedo mudei",
                        "price" => "12.11",
                        "code" => "301",
                        "excluded" => "0",
                    ];
        $params =  [   "id" => 1,
                        "name" => "Carrinho de metal Mudei",
                        "description" => "carrinho brinquedo mudei",
                        "price" => "12.11",
                        "code" => "301",
                    ];
        $ProductService = new ProductService();
        $ProductService->update( '1' , $params );
        $final = $ProductService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }
    
    /**
     * @expectedException         \Stock\Products\Exceptions\ProductEditException
     * @expectedExceptionMessage Preço do Produto deve ser numérico
     */
    
    public function test_update_fail_price_not_number_prod()
    {
        $params = [    "name" => "Carrinho de metal Mudei",
                        "description" => "carrinho brinquedo mudei",
                        "price" => "NAO NUMERO",
                        "code" => "301", ];
        $ProductService = new ProductService();
        $ProductService->update( '1' , $params );
        $ProductService->edit( 1 )->toArray();
    }

    public function test_exclude_prod()
    {
        $expected = [   "name" => "Carrinho de metal",
                        "description" => "carrinho brinquedo",
                        "price" => "50.6",
                        "code" => "301",
                        'excluded' => '1',
                        'id' => '1'
                    ];
        $ProductService = new ProductService();
        $ProductService->remove( 1 );
        $final = $ProductService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }

    /**
     * @expectedException         \Stock\Products\Exceptions\ProductEditException
     * @expectedExceptionMessage Preencha o Nome do Produto
     */
    public function test_fail_create_null_name_prod()
    {
        $expected = [   "name" => null,
                        "description" => "produto novo para o estoque",
                        "price" => "2005",
                        "excluded" => "0",
                    ];
        $ProductService = new ProductService();
        $ProductService->create( $expected );
        $ProductService->edit( 2 )->toArray();
    }

    public function test_create_prod()
    {
        $expected = [   "name" => "produto novo",
                        "description" => "produto novo para o estoque",
                        "price" => "2005",
                        "code" => "302",
                        "excluded" => "0",
                    ];
        $prodService = new ProductService();
        $prodService->create( $expected );
        $final = $prodService->edit( 2 )->toArray();
        $expected['id'] = 2;
        $this->assertEquals( $final , $expected );
    }


    public function test_list_prod_filter_after_create()
    {
        $expected = [
                        '0' => [  
                                'prod_id' => '1',
                                'prod_name' => 'Carrinho de metal',
                                'prod_description' => 'carrinho brinquedo',
                                'prod_code' => '301',
                                'prod_price' => '50.6',
                            ],
                        '1' => [   
                                'prod_id' => '2',
                                "prod_name" => "produto novo",
                                "prod_description" => "produto novo para o estoque",
                                "prod_price" => "2005",
                                "prod_code" => "302",
                        ]
                    ];
        $this->test_create_prod();

        $productService = new ProductService();
        $this->assertEquals( $productService->getList()->toArray() , $expected );
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
