<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

     public function store(Request $request)
     {
       $type = $request->data["type"];
       $name = $request->data["attributes"]["name"];
       $price = $request->data["attributes"]["price"];

      if (is_null($name)) {
          return response()->json([
               "errors"=> ["ID"=> "ERR_CREATE-1",
               "title"=>  "Unprocessable Entity",
               "code"=>  "422",
               ]]  , 422);
          }elseif (is_null($price)) {
            return response()->json([
                 "errors"=> ["ID"=> "ERR_CREATE-2",
                 "title"=>  "Unprocessable Entity",
                 "code"=>  "422",
                 ]]  , 422);
        }elseif (!(is_numeric($price))) {
              return response()->json([
                   "errors"=> ["ID"=> "ERR_CREATE-3",
                   "title"=>  "Unprocessable Entity",
                   "code"=>  "422",
                   ]]  , 422);
              }elseif (($price)<=0) {
                      return response()->json([
                           "errors"=> ["ID"=> "ERR_CREATE-4",
                           "title"=>  "Unprocessable Entity",
                           "code"=>  "422",
                           ]]  , 422);
                }else {

                  $product = Product::create([
                                              'type'=> $type,
                                              'name'=> $name,
                                              'price'=> $price
                                            ]);
                  $response = [
                              "data"=> ["type"=> $type,
                                        "ID"=>  $product->id,
                                        "attributes"=>[
                                                      "name"=> $name,
                                                      "price"=> $price,
                                                      ]
                                        ],
                                'links' => [
                                            'self' => 'http://localhost:8000/api/products/'.$product->id
                                           ]
                              ];
                  // Return a response with a product json
                  // representation and a 201 status code
                  return response()->json($response,201);
                }

     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showAProduct(Product $product, $id)
    {

      if (!(Product::find($id))) {
        return response()->json([
             "errors"=> ["ID"=> "ERR_SHOW-1",
             "title"=>  "Not Found",
             "code"=>  "404",
             ]]  , 404);
        } else {

          $found = $product->find($id);

          $type = $found->type;
          $name = $found->name;
          $price = $found->price;

          $response = [
                      "data"=> ["type"=> $type,
                                "ID"=>  $found->id,
                                "attributes"=>[
                                              "name"=> $name,
                                              "price"=> $price,
                                              ]
                                ],
                      'links' => [
                                 'self' => 'http://localhost:8000/api/products/'.$product->id
                                 ]
                      ];

          return response()->json($response,200);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = $request->data["type"];
        $name = $request->data["attributes"]["name"];
        $price = $request->data["attributes"]["price"];

        if (!(is_numeric($price))) {
          return response()->json([
               "errors"=> ["ID"=> "ERR_UPDATE-1",
               "title"=>  "Unprocessable Entity",
               "code"=>  "422",
               ]]  , 422);
          }elseif (($price)<=0) {
            return response()->json([
                 "errors"=> ["ID"=> "ERR_UPDATE-2",
                 "title"=>  "Unprocessable Entity",
                 "code"=>  "422",
                 ]]  , 422);
              }elseif (!(Product::find($id))) {
                return response()->json([
                     "errors"=> ["ID"=> "ERR_UPDATE-3",
                     "title"=>  "Not Found",
                     "code"=>  "404",
                     ]]  , 404);
                } else {
                  $product = Product::find($id);
                  $product->name = $name;
                  $product->price = $price;
                  $product->type = $type;
                  $product->save();

                  $response = [
                              "data"=> ["type"=> $type,
                                        "ID"=>  $product->id,
                                        "attributes"=>[
                                                      "name"=> $name,
                                                      "price"=> $price,
                                                      ]
                                        ],
                              'links' => [
                                          'self' => 'http://localhost:8000/api/products/'.$product->id
                                        ]
                              ];

                  return response()->json($response,200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      if (!(Product::find($id))) {
        return response()->json([
             "errors"=> ["ID"=> "ERR_DELETE-1",
             "title"=>  "Unprocessable Entity",
             "code"=>  "404",
             ]]  , 404);
        } else {
            $product = Product::destroy($id);
            return response()->json(204);
      }
    }
}
