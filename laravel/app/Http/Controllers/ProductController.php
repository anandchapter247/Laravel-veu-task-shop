<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product,Category};

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $allProduct = Product::select(
                    'id',
                    'name',
                    'price',
                    'description',
                    'category_id',
                    'available'
                    )->with('category');
            // Filter with Price Min
            if( $request->has('min') && $request['min'] != '' ){
                $request['min'] = $request['min'] - 1;
                $allProduct = $allProduct->where('price','>=',$request['min']);
            }
            // Filter with Price Max
            if( $request->has('max') && $request['max'] != '' ){
                $request['max'] = $request['max'] + 1;
                $allProduct = $allProduct->where('price','<=',$request['max']);
            }
            // Filter with Category ID
            if( $request->has('category') && $request['category'] != '' && $request['category'] != 'undefined' ){
                $allProduct = $allProduct->where('category_id',$request['category']);
            }
            if( $request->has('availability') && $request['availability'] != '' ){
                $allProduct = $allProduct->where('available',$request['availability']);
            } 
            $allProduct = $allProduct->paginate($request['limit'] ?? 20)->toArray();
        return response()->json([ 
                'status'=>'200',
                'data' => $allProduct['data'],
                'totalRecord'=>$allProduct['total']
            ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request)
    {
        $allCategory = Category::select('id','name')->get();
        return response()->json([ 'status'=>'200','allCategory' => $allCategory ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
