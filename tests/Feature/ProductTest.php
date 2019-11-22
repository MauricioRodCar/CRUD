<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * CREATE-1
     */
    public function test_create()
    {
        // Given
        $productData = [
                        "data"=> ["type"=> "product",
                                  "ID"=>  1,
                                  "attributes"=>[
                                                "name"=> "gato",
                                                "price"=> 12.34,
                                                ]
                                  ],
                        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);
        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'name' => 'gato',
            'price' => 12.34
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'name' => 'gato',
                'price' => 12.34,
                'type'=> "product"
            ]
        );
    }

    /**
     * CREATE-2
     */
    public function test_create_2()
    {
        // Given
        $productData = [
                        "data"=> ["type"=> "product",
                                  "ID"=>  1,
                                  "attributes"=>[
                                                "name"=> "",
                                                "price"=> 12.34,
                                                ]
                                  ]
                        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'ID' => 'ERR_CREATE-1',
            'title' =>  'Unprocessable Entity',
            'code'=>  '422'
        ]);
    }

    /**
     * CREATE-3
     */
    public function test_create_3()
    {
        // Given
        $productData = [
                        "data"=> ["type"=> "product",
                                  "ID"=>  1,
                                  "attributes"=>[
                                                "name"=> "gato",
                                                "price"=> '',
                                                ]
                                  ]
                        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'ID' => 'ERR_CREATE-2',
            'title' =>  'Unprocessable Entity',
            'code'=>  '422'
        ]);
    }

    /**
     * CREATE-4
     */
    public function test_create_4()
    {
        // Given
        $productData = [
                        "data"=> ["type"=> "product",
                                  "ID"=>  1,
                                  "attributes"=>[
                                                "name"=> "gato",
                                                "price"=> 'a',
                                                ]
                                  ]
                        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'ID' => 'ERR_CREATE-3',
            'title' =>  'Unprocessable Entity',
            'code'=>  '422'
        ]);
    }

    /**
     * CREATE-5
     */
    public function test_create_5()
    {
        // Given
        $productData = [
                        "data"=> ["type"=> "product",
                                  "ID"=>  1,
                                  "attributes"=>[
                                                "name"=> "gato",
                                                "price"=> -12.34,
                                                ]
                                  ]
                        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'ID' => 'ERR_CREATE-4',
            'title' =>  'Unprocessable Entity',
            'code'=>  '422'
        ]);
    }

    /**
     * LIST-1
     */
    public function test_show()
    {
        // When
        $response = $this->json('GET', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        // Assert the product was created

        $body = $response->decodeResponseJson();

    }

    /**
     * LIST-2
     */
    public function test_show_2()
    {
        // When
        $response = $this->json('GET', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        // Assert the product was created

        $body = $response->decodeResponseJson();

    }

    /**
    * SHOW-1
    */
    public function test_showAProduct()
    {

      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $response = $this->json('GET', '/api/products/2');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);


        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
          'name' => 'gato',
          'price' => "12.34"
        ]);

        $body = $response->decodeResponseJson();
    }

    /**
    * SHOW-2
    */
    public function test_showAProduct_2()
    {

      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $response = $this->json('GET', '/api/products/30');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(404);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'ID' => 'ERR_SHOW-1',
            'title' =>  'Not Found',
            'code'=>  '404'
        ]);

        $body = $response->decodeResponseJson();
    }

    /**
    * UPDATE-1
    */
    public function test_update()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> 43.21,
                                              ]
                                ]
                      ];


        $response = $this->json('PUT', '/api/products/4', $productData);

        $response->assertStatus(200);

        $response->assertJsonFragment([
          'name' => 'perro',
          'price' => 43.21
        ]);

        $body = $response->decodeResponseJson();

        $this->assertDatabaseHas(
            'products',
            [
                'name' => 'perro',
                'price' => '43.21',
                'type' => 'product'
            ]
        );

    }

    /**
    * UPDATE-2
    */
    public function test_update_2()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> "a",
                                              ]
                                ]
                      ];

        $response = $this->json('PUT', '/api/products/3', $productData);

        $response->assertStatus(422);

        $response->assertJsonFragment([
          "ID"=> "ERR_UPDATE-1",
          "title"=>  "Unprocessable Entity",
          "code"=>  "422"
        ]);

    }

    /**
    * UPDATE-3
    */
    public function test_update_3()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> -43.21,
                                              ]
                                ]
                      ];

        $response = $this->json('PUT', '/api/products/3', $productData);

        $response->assertStatus(422);

        $response->assertJsonFragment([
          "ID"=> "ERR_UPDATE-2",
          "title"=>  "Unprocessable Entity",
          "code"=>  "422"
        ]);

    }

    /**
    * UPDATE-4
    */
    public function test_update_4()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> 43.21,
                                              ]
                                ]
                      ];

        $response = $this->json('PUT', '/api/products/80', $productData);

        $response->assertStatus(404);

        $response->assertJsonFragment([
          "ID"=> "ERR_UPDATE-3",
          "title"=>  "Not Found",
          "code"=>  "404"
        ]);

    }

    /**
    * DELETE-1
    */
    public function test_delete()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> 43.21,
                                              ]
                                ]
                      ];

      $response = $this->json('DELETE', '/api/products/2');

        $response->assertStatus(404);
    }

    /**
    * DELETE-3
    */
    public function test_delete_2()
    {
      // Given
      $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "gato",
                                              "price"=> 12.34,
                                              ]
                                ]
                      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);
      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
          'name' => 'gato',
          'price' => 12.34
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'name' => 'gato',
              'price' => 12.34,
              'type'=> "product"
          ]
      );

        $productData = [
                      "data"=> ["type"=> "product",
                                "ID"=>  1,
                                "attributes"=>[
                                              "name"=> "perro",
                                              "price"=> 43.21,
                                              ]
                                ]
                      ];
      $response = $this->json('DELETE', '/api/products/50');

        $response->assertStatus(404);
    }
}
