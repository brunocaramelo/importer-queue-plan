<?php

namespace Stock\Products\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stock\Products\Services\ProductService;
use Stock\Products\Exceptions\ProductEditException;

class ProductController extends Controller
{
    public function __construct()
    {
    }
  
    public function listAll()
    {
        $service = new ProductService();
        return response()->json( $service->getList() );
    }
    
    public function findById( Request $request )
    {
        $service = new ProductService();
        return response()->json( $service->edit( $request->id ) );
    }

    public function update( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new ProductService();
            $service->update( $request->id , $request->all() );
            \DB::commit();
            $return['message'] = 'Produto editado com sucesso';
            return response()->json( $return );
        }catch( ProductEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }
    
    public function remove( Request $request )
    {
        $return = ['status' => '200','message'=> null,'data'=> null];
        try{        
            \DB::beginTransaction();
            $service = new ProductService();
            $service->remove( $request->id );
            \DB::commit();
            $return['message'] = 'Produto excluido com sucesso';
            return response()->json( $return );
        }catch( ProductEditException $error ){
            \DB::rollback();
            $return['status'] = 400;
            $return['message'] = $error->getMessage();
            return response()->json( $return , $return['status'] );
        }
    }

    // public function create( Request $request )
    // {
    //     $return = ['status' => '200','message'=> null,'data'=> null];
    //     try{        
    //         \DB::beginTransaction();
    //         $service = new ProductService();
    //         $service->create( $request->all() );
    //         $return['message'] = 'Produto criado com sucesso';
    //         \DB::commit();
    //         return response()->json( $return );
    //     }catch( ProductEditException $error ){
    //         \DB::rollback();
    //         $return['status'] = 400;
    //         $return['message'] = $error->getMessage();
    //         return response()->json( $return , $return['status'] );
    //     }
    // }
}
