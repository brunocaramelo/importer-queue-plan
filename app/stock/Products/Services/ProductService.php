<?php

namespace Stock\Products\Services;
use Stock\Products\Models\ProductModel;

class ProductService
{
    private $prodModel = null;
    
    public function __construct()
    {
        $this->prodModel = new ProductModel();
    }

    public function getList()
    {
        return $this->prodModel->getList();
    }

    public function remove( $identify )
    {
        return $this->prodModel->remove( $identify );
    }

    public function create( array $data )
    {
        return $this->prodModel->create( $data );
    }

    public function update( $identify , array $data )
    {
        return $this->prodModel->update( $identify , $data );
    }

    public function edit( $identify )
    {
        return $this->prodModel->edit( $identify );
    }

    public function find( $identify )
    {
        return $this->prodModel->find( $identify );
    }

    public function findByCode( $value )
    {
        return $this->findByCode( $value );
    }

}