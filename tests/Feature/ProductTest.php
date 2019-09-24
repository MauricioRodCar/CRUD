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

    public function test_showAProduct()
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



        $response = $this->json('GET', '/api/products/2');

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
            'id' => 2,
            'name' => 'Codzitos con frijol',
            'price' => '11.00'
        ]);

        $body = $response->decodeResponseJson();
    }

    public function test_update()
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
            'price' => '12.34'
        ];

        $response = $this->json('PUT', '/api/products/3', $productData);

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

      // Assert product is on the database
      $this->assertDatabaseHas(
          'products',
          [
              'id' => $body['id'],
              'name' => 'Codzitos con frijol',
              'price' => '11.00'
          ]
      );
      $response = $this->json('DELETE', '/api/products/2');

        $response->assertStatus(405);
    }
}
