<?php

namespace Stock\Plan\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stock\Plan\Services\ImportService;
use Stock\Products\Exceptions\ProductEditException;
use Stock\Jobs\Jobs\JobImportPlanProducts;
class ImportController extends Controller
{
    public function __construct()
    {
    }
    
    public function importProduct( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        $file = $request->file('file');
        $file->move( base_path('storage/uploads' ),
                     $file->getClientOriginalName() );
        $fileName = base_path( 'storage/uploads/'.$file->getClientOriginalName() );

        $this->dispatch( new JobImportPlanProducts( 
                                                new ImportService(
                                                                    $fileName 
                                                                  )
                                                ) 
                        );
        $return['message'] = 'Envio efetuado com sucesso, aguarde o processamento';
        return response()->json( $return );
    }

}