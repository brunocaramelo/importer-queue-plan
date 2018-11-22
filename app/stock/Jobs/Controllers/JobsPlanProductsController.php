<?php

namespace Stock\Jobs\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stock\Jobs\Services\ImportJobService;

class JobsPlanProductsController extends Controller
{
    public function __construct()
    {
    }
    
    public function listAll()
    {
        $service = new ImportJobService();
        return response()->json( $service->all() );
    }
    
    public function findById( Request $request )
    {
        $service = new ImportJobService();
        return response()->json( $service->getById( $request->id ) );
    }

}