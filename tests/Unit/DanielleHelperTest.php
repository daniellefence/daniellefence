<?php

namespace Tests\Unit;

use App\Danielle;
use App\Models\AreasWeServe;
use App\Models\AvailableColor;
use App\Models\DiyProduct;
use App\Models\DiyProductCategory;
use App\Models\Modifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DanielleHelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_areas_we_serve_functionality()
    {
        AreasWeServe::factory()->create([
            'title' => 'Tampa',
            'hidden' => false
        ]);

        AreasWeServe::factory()->create([
            'title' => 'Orlando',
            'hidden' => false
        ]);

        AreasWeServe::factory()->create([
            'title' => 'Hidden Area',
            'hidden' => true
        ]);

        $areas = Danielle::getAreasWeServe();

        $this->assertCount(2, $areas);
        $this->assertTrue($areas->pluck('title')->contains('Tampa'));
        $this->assertTrue($areas->pluck('title')->contains('Orlando'));
        $this->assertFalse($areas->pluck('title')->contains('Hidden Area'));
    }

    public function test_price_calculation_with_modifiers()
    {
        $product = DiyProduct::factory()->create([
            'base_price' => 100.00
        ]);

        $modifier = Modifier::factory()->create([
            'name' => 'Premium Finish',
            'price_adjustment' => 25.00,
            'adjustment_type' => 'add'
        ]);

        $totalPrice = Danielle::calculatePriceWithModifiers($product->base_price, [$modifier->id]);

        $this->assertEquals(125.00, $totalPrice);
    }

    public function test_available_colors_retrieval()
    {
        AvailableColor::factory()->create([
            'name' => 'White',
            'hex_code' => '#FFFFFF',
            'is_active' => true
        ]);

        AvailableColor::factory()->create([
            'name' => 'Black',
            'hex_code' => '#000000',
            'is_active' => true
        ]);

        AvailableColor::factory()->create([
            'name' => 'Inactive Color',
            'hex_code' => '#FF0000',
            'is_active' => false
        ]);

        $colors = Danielle::getAvailableColors();

        $this->assertCount(2, $colors);
        $this->assertTrue($colors->pluck('name')->contains('White'));
        $this->assertTrue($colors->pluck('name')->contains('Black'));
        $this->assertFalse($colors->pluck('name')->contains('Inactive Color'));
    }

    public function test_email_notification_data_formatting()
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '555-1234',
            'message' => 'Test message'
        ];

        $formattedData = Danielle::formatContactDataForEmail($contactData);

        $this->assertArrayHasKey('customer_name', $formattedData);
        $this->assertEquals('John Doe', $formattedData['customer_name']);
        $this->assertArrayHasKey('customer_email', $formattedData);
        $this->assertEquals('john@example.com', $formattedData['customer_email']);
    }

    public function test_service_area_validation()
    {
        AreasWeServe::factory()->create([
            'title' => 'Tampa',
            'hidden' => false
        ]);

        $this->assertTrue(Danielle::isServiceAreaValid('Tampa'));
        $this->assertFalse(Danielle::isServiceAreaValid('New York'));
        $this->assertFalse(Danielle::isServiceAreaValid(''));
    }
}