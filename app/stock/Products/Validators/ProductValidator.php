<?php

namespace Stock\Products\Validators;
use Validator;

class ProductValidator{
    
    private $redirect = false;
    private $messages = false;
    
    public function __construct( $redirect = false )
    {
        $this->redirect = $redirect;
        $this->setMessages();
    }

    public function validateCreate( $fields )
    {
      return $this->make( $fields , [
                                        'code' => 'required|unique:products,code',
                                        'name' => 'required',
                                        'description' => 'required',
                                        'price' => 'required|numeric',
                                    ]);
    }

    public function validateUpdate( $fields )
    {
       return $this->make( $fields , [
                                        'code' => 'required',
                                        'name' => 'required',
                                        'description' => 'required',
                                        'price' => 'required|numeric',
                                    ]);
    }

    public function make( $fields , $rules )
    {
        $validate =  Validator::make( $fields , $rules , $this->messages );
        if($this->redirect === true)
            return $validate->validate();
        return $validate;
    }

    private function setMessages()
    {
        $this->messages = [
                            'code.required'=>'Preencha o Código do Produto',
                            'code.unique'=>'Código do produto já esta em uso',
                            'name.required'=>'Preencha o Nome do Produto',
                            'price.required'=>'Preencha o Preço do Produto',
                            'price.numeric'=>'Preço do Produto deve ser numérico',
                            ];
    }


}