<?php 

namespace Stock\Products\Repositories;
use Stock\Products\Entities\ProductEntity;

class ProductRepository
{
    private $car = null;

    public function __construct( ProductEntity $prod )
    {
        $this->prod = $prod;
    }

    public function getList()
    {
        $query = $this->prod->select(
                                'po.id as prod_id',
                                'po.name as prod_name',
                                'po.description as prod_description',
                                'po.code as prod_code',
                                'po.price as prod_price'
                                )
                            ->from('products AS po')
                            ->where( 'po.excluded' , '=' , '0' );
        return $query;
    }

    public function find( $identify )
    {
        return $this->prod->find( $identify );
    }

    public function findBy( $field , $value )
    {
        return $this->prod->where( $field , $value );
    }
    
    public function remove( $identify )
    {
        $carSave = $this->prod->find($identify);
        return $carSave->fill( [ 'excluded' => '1' ] )->save();
    }
    
    public function create( $data )
    {
        return $this->prod->create( $data );
    }

    public function update( $identify , $data )
    {
        $carSave = $this->prod->find($identify);
        return $carSave->fill( $data )->save();
    }

}