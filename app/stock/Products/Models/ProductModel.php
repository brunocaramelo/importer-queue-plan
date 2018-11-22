<?php

namespace Stock\Products\Models;

use Stock\Products\Validators\ProductValidator;
use Stock\Products\Exceptions\ProductEditException;
use Stock\Products\Entities\ProductEntity;
use Stock\Products\Repositories\ProductRepository;

class ProductModel
{
    private $prodRepo = null;
    
    public function __construct()
    {
        $this->prodRepo = new ProductRepository( new ProductEntity() );
    }

    public function getList()
    {
        return $this->prodRepo->getList( )->get();
    }

    public function remove( $identify )
    {
        return $this->prodRepo->remove( $identify );
    }

    public function create( array $data )
    {
        $validate = new ProductValidator();
        $validation = $validate->validateCreate( $data );
        if( $validation->fails() )
            throw new ProductEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->prodRepo->create( $data );
    }

    public function update( $identify , array $data )
    {
        $validate = new ProductValidator();
        $validation = $validate->validateUpdate( $data );
        if( $validation->fails() )
            throw new ProductEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->prodRepo->update( $identify , $data );
    }

    public function edit( $identify )
    {
        $edit = $this->find( $identify );
        unset( $edit['created_at'], $edit['updated_at'] );
        return $edit;
    }

    public function find( $identify )
    {
        return $this->prodRepo->find( $identify );
    }

    public function findByCode( $value )
    {
        return $this->findBy( 'code' , $value );
    }

    public function findBy( $field , $value )
    {
        return $this->prodRepo->findBy( $field , $value )->first();
    }

}