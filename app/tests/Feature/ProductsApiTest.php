<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;


class ProductsApiTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_fail_update_item()
    {   
        $this->put('/api/v1/products/1',[     
                                            "name" => "Carrinho de novo",
                                            "description" => "carrinho brinquedo novo",
                                            "price" => "66",
                                            "code" => null,
                                            ])
                ->assertStatus(400)
                ->assertJson([
                                'message' => "Preencha o Código do Produto" 
                            ]);
    }
    public function test_update_item()
    {   
        $this->put('/api/v1/products/1',[     
                                                "id" => "1",
                                                "name" => "Carrinho de novo",
                                                "description" => "carrinho brinquedo novo",
                                                "price" => "66",
                                                "code" => '669',
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Produto editado com sucesso' 
                            ]);
    }

    public function test_remove_item()
    {   
        $this->delete('/api/v1/products/1',[     
                                                "id" => "1",
                                                "name" => "Carrinho de novo",
                                                "description" => "carrinho brinquedo novo",
                                                "price" => "66",
                                                "code" =>   '46465',
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Produto excluido com sucesso' 
                            ]);
    }

    public function test_edit_item()
    {   
        $this->get('/api/v1/products/1',[     
                                                "id" => "1",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                "name" => "Carrinho de metal",
                                "description" => "carrinho brinquedo",
                                "price" => "50.6",
                                "code" => "301",
                            ]);
    }
    public function test_list_two_items()
    {   
        $this->get('/api/v1/products/1',[     
                                                "id" => "1",
                                            ])
                ->assertStatus(200)
                ->assertSeeText('carrinho brinquedo')
                ->assertSeeText('Carrinho de metal')
                ->assertSeeText('50.6');
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
