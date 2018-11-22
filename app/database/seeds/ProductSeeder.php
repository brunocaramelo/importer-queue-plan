<?php

use Illuminate\Database\Seeder;
use Stock\Products\Entities\ProductEntity as Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAll();
    }

    private function createAll()
    {
        Product::firstOrCreate([
                                    'id' => '1',
                                    'code' => '301',
                                    'name' => 'Carrinho de metal',
                                    'description' => 'carrinho brinquedo',
                                    'price' => 50.60,
                                ]);
    }
}
