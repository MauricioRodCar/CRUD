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
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Super Product',
                'price' => '23.30'
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
            'name' => '',
            'price' => '23.30'
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
            'name' => 'Tostadas',
            'price' => ''
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
            'name' => 'Tostadas',
            'price' => 'a'
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
            'name' => 'Tostadas',
            'price' => '-42.34'
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

        $productData = [
            'name' => 'Codzitos con más frijol',
            'price' => '11.00'
        ];

        $response = $this->json('POST', '/api/products', $productData);

        $productData = [
            'name' => 'Codzitos con sin frijol',
            'price' => '12.00'
        ];

        $response = $this->json('POST', '/api/products', $productData);



        // When
        $response = $this->json('GET', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        // Assert the product was created

        $body = $response->decodeResponseJson();

        $response->assertJsonFragment([
          'name' => 'Codzitos con más frijol',
          'price' => '11.00',
          'name' => 'Codzitos con sin frijol',
          'price' => '12.00'
        ]);

    }

    /**
     * LIST-2
     */
    public function test_show_2()
    {
        $productData = '{"baseResponse":{"headers":{},"original":[],"exception":null}}';
        // When
        $response = $this->json('GET', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        $valor = json_encode($response);
        $this->assertEquals($productData, $valor);

    }

    /**
    * SHOW-1
    */
    public function test_showAProduct()
    {

        $productData = [
            'name' => 'Codzitos con más frijol',
            'price' => '11.00'
        ];

        $response = $this->json('POST', '/api/products', $productData);

        $response = $this->json('GET', '/api/products/4');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'id' => 4,
            'name' => 'Codzitos con más frijol',
            'price' => '11.00'
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
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);

      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
        'name' => 'Codzitos con frijol',
        'price' => '11.00'
      ]);

      $body = $response->decodeResponseJson();

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'id' => $body['id'],
              'name' => 'Codzitos con frijol',
              'price' => '11.00'
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
            'name' => 'Codzitos con frijol',
            'price' => '11.00'
        ];

        $response = $this->json('POST', '/api/products', $productData);

        $productData = [
            'name' => 'Tostadas chidas',
            'price' => '12.34'
        ];

        $response = $this->json('PUT', '/api/products/6', $productData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        $response->assertJsonFragment([
          'name' => 'Tostadas chidas',
          'price' => '12.34'
        ]);

        $body = $response->decodeResponseJson();

        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Tostadas chidas',
                'price' => '12.34'
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
            'name' => 'Codzitos con frijol',
            'price' => '11.00'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Codzitos con frijol',
                'price' => '11.00'
            ]
        );

        $productData = [
            'name' => 'Tostadas chidas',
            'price' => 'a'
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
            'name' => 'Codzitos con frijol',
            'price' => '11.00'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Codzitos con frijol',
                'price' => '11.00'
            ]
        );

        $productData = [
            'name' => 'Tostadas chidas',
            'price' => '-40'
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
            'name' => 'Codzitos con frijol',
            'price' => '11.00'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);

        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
        ]);

        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Codzitos con frijol',
                'price' => '11.00'
            ]
        );

        $productData = [
            'name' => 'Tostadas chidas',
            'price' => '40'
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
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      // Then
      // Assert it sends the correct HTTP Status
      $response->assertStatus(201);

      // Assert the response has the correct structure
      $response->assertJsonStructure([
          'id',
          'name',
          'price'
      ]);

      // Assert the product was created
      // with the correct data
      $response->assertJsonFragment([
        'name' => 'Codzitos con frijol',
        'price' => '11.00'
      ]);

      $body = $response->decodeResponseJson();
      $id = $body['id'];

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'id' => $body['id'],
              'name' => 'Codzitos con frijol',
              'price' => '11.00'
          ]
      );
      $response = $this->json('DELETE', '/api/products/'.$id);

        $response->assertStatus(200);
    }

    /**
    * DELETE-3
    */
    public function test_delete_2()
    {
      // Given
      $productData = [
          'name' => 'Codzitos con frijol',
          'price' => '11.00'
      ];

      // When
      $response = $this->json('POST', '/api/products', $productData);

      $response = $this->json('DELETE', '/api/products/50');
      $response->assertJsonStructure([
            'errors'
        ]);

      $response->assertStatus(404);
    }
}
