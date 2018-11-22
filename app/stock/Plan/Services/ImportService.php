<?php

namespace Stock\Plan\Services;

use Stock\Plan\Builders\PlanProductImportBuilder;
use Stock\Products\Services\ProductService;
use Stock\Products\Exceptions\ProductEditException;

class ImportService
{
    private $plan;

    public function __construct( $filePath )
    {
        $this->plan = $filePath;
    }

    public function getFileName()
    {
        return $this->plan;
    }

    public function importProduct()
    {
        $planBuilder = new PlanProductImportBuilder( $this->plan );
        $productService = new ProductService();
        $planBuilder->build();

        foreach( $planBuilder->getLines() as $lines ){
            $productService->create( $lines );
        }
        return 'Carga de produtos efetuada com sucesso';
    }
}