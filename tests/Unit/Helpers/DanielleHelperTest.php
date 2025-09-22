<?php

namespace Tests\Unit\Helpers;

use App\Danielle;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\Documentationcategory;
use App\Models\Diyproduct;
use App\Models\Photo;
use App\Models\Tag;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class DanielleHelperTest extends TestCase
{
    use RefreshDatabase;

    private Danielle $danielle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->danielle = new Danielle();
    }

    /** @test */
    public function page_header_returns_empty_string_for_unknown_part()
    {
        $result = $this->danielle->pageHeader('unknown_part');

        $this->assertEquals('', $result);
    }

    /** @test */
    public function page_header_returns_empty_array_for_buttons_when_not_set()
    {
        $result = $this->danielle->pageHeader('buttons');

        $this->assertEquals([], $result);
    }

    /** @test */
    public function service_cities_returns_sorted_array()
    {
        $cities = $this->danielle->serviceCities();

        $this->assertIsArray($cities);
        $this->assertContains('Tampa', $cities);
        $this->assertContains('Clearwater', $cities);
        $this->assertContains('St. Petersburg', $cities);

        // Check if array is sorted
        $sortedCities = $cities;
        asort($sortedCities);
        $this->assertEquals($sortedCities, $cities);
    }

    /** @test */
    public function service_cities_contains_expected_cities()
    {
        $cities = $this->danielle->serviceCities();

        $expectedCities = [
            'Tampa',
            'Clearwater',
            'St. Petersburg',
            'Lakeland',
            'Sarasota',
            'Brandon'
        ];

        foreach ($expectedCities as $city) {
            $this->assertContains($city, $cities);
        }
    }

    /** @test */
    public function category_image_returns_url_when_category_has_photo()
    {
        $photo = Photo::factory()->create(['path' => '/images/test.jpg']);
        $category = Category::factory()->create();
        $photo->update(['category_id' => $category->id]);

        $result = $this->danielle->categoryImage($category->id);

        $this->assertStringContains('/images/test.jpg', $result);
    }

    /** @test */
    public function category_title_returns_category_title()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);

        $result = $this->danielle->categoryTitle($category->id);

        $this->assertEquals('Test Category', $result);
    }

    /** @test */
    public function carousel_show_title_returns_true_for_home()
    {
        $result = $this->danielle->carouselShowTitle('home');

        $this->assertTrue($result);
    }

    /** @test */
    public function carousel_show_title_returns_false_for_other_keys()
    {
        $result = $this->danielle->carouselShowTitle('about');

        $this->assertFalse($result);
    }

    public static function carousel_title_data_provider()
    {
        return [
            ['home', 1, '<p>A Company</p><p>You Can Trust<p>Since 1976</p>'],
            ['home', 2, '<p>Over 48 Years</p><p>Of Quality</p><p>Installations</p>'],
            ['home', 3, '<p>View Our</p><p>Selection Of</p><p>Fence and Gates</p>'],
            ['home', 4, '<p>Over 1000</p><p>Outdoor Kitchens</p><p>Installed</p>'],
            ['home', 5, ''],
            ['other', 1, ''],
        ];
    }

    /**
     * @test
     * @dataProvider carousel_title_data_provider
     */
    public function carousel_parse_title_returns_correct_content($key, $count, $expected)
    {
        $result = $this->danielle->carouselParseTitle($key, $count);

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function parse_keywords_returns_decoded_array_when_valid_json()
    {
        $model = (object) ['keywords' => '["keyword1", "keyword2", "keyword3"]'];

        $result = $this->danielle->parseKeywords($model);

        $this->assertEquals(['keyword1', 'keyword2', 'keyword3'], $result);
    }

    /** @test */
    public function parse_keywords_returns_empty_array_when_invalid_json()
    {
        $model = (object) ['keywords' => 'invalid json'];

        $result = $this->danielle->parseKeywords($model);

        $this->assertEquals([], $result);
    }

    /** @test */
    public function parse_keywords_returns_empty_array_when_null()
    {
        $model = (object) ['keywords' => null];

        $result = $this->danielle->parseKeywords($model);

        $this->assertEquals([], $result);
    }

    public static function button_type_data_provider()
    {
        return [
            ['danger', 'bg-danger border-danger text-white'],
            ['success', 'bg-success border-success text-white'],
            ['info', 'bg-info border-info text-black'],
            ['primary', 'bg-gray-800 border-transparent text-white'],
            ['warning', 'bg-warning border-warning text-black'],
            ['secondary', 'bg-gray-100 border-gray-200 text-black'],
        ];
    }

    /**
     * @test
     * @dataProvider button_type_data_provider
     */
    public function default_button_classes_returns_correct_classes_for_type($type, $expectedPartial)
    {
        $result = $this->danielle->defaultButtonClasses($type);

        $this->assertStringContains($expectedPartial, $result);
        $this->assertStringContains('inline-flex justify-center items-center', $result);
        $this->assertStringContains('border rounded-md font-semibold', $result);
    }

    public static function button_size_data_provider()
    {
        return [
            ['small', 'rounded px-2 py-1 text-xs'],
            ['normal', 'rounded-md px-2 py-2 text-sm'],
            ['large', 'rounded-md px-4 py-5 text-lg'],
        ];
    }

    /**
     * @test
     * @dataProvider button_size_data_provider
     */
    public function default_button_padding_returns_correct_padding_for_size($size, $expectedPartial)
    {
        $result = $this->danielle->defaultButtonPadding($size);

        $this->assertStringContains($expectedPartial, $result);
        $this->assertStringContains('font-semibold shadow-sm focus-visible:outline', $result);
    }

    /** @test */
    public function default_button_padding_returns_normal_for_default()
    {
        $result = $this->danielle->defaultButtonPadding('default');

        $this->assertStringContains('rounded-md px-2 py-2 text-sm', $result);
    }

    /** @test */
    public function decode_replaces_underscores_and_capitalizes()
    {
        $result = $this->danielle->decode('test_string_here');

        $this->assertEquals('Test String Here', $result);
    }

    /** @test */
    public function get_dropdown_blog_categories_returns_id_title_array()
    {
        $category1 = Blogcategory::factory()->create(['title' => 'Category 1']);
        $category2 = Blogcategory::factory()->create(['title' => 'Category 2']);

        $result = $this->danielle->getDropdownBlogCategories();

        $this->assertIsArray($result);
        $this->assertEquals('Category 1', $result[$category1->id]);
        $this->assertEquals('Category 2', $result[$category2->id]);
    }

    /** @test */
    public function get_dropdown_documentation_categories_returns_id_title_array()
    {
        $category1 = Documentationcategory::factory()->create(['title' => 'Doc Category 1']);
        $category2 = Documentationcategory::factory()->create(['title' => 'Doc Category 2']);

        $result = $this->danielle->getDropdownDocumentationCategories();

        $this->assertIsArray($result);
        $this->assertEquals('Doc Category 1', $result[$category1->id]);
        $this->assertEquals('Doc Category 2', $result[$category2->id]);
    }

    /** @test */
    public function tags_dropdown_returns_array_with_default_option()
    {
        $tag1 = Tag::factory()->create(['title' => 'Tag A']);
        $tag2 = Tag::factory()->create(['title' => 'Tag B']);

        $result = $this->danielle->tagsDropdown();

        $this->assertIsArray($result);
        $this->assertEquals('Choose a keyword to add.', $result[0]);
        $this->assertEquals('Tag A', $result['Tag A']);
        $this->assertEquals('Tag B', $result['Tag B']);
    }

    /** @test */
    public function labelize_replaces_underscores_and_capitalizes()
    {
        $result = $this->danielle->labelize('test_label_text');

        $this->assertEquals('Test Label Text', $result);
    }

    /** @test */
    public function labelize_returns_nothing_for_array_input()
    {
        $result = $this->danielle->labelize(['test', 'array']);

        $this->assertNull($result);
    }

    /** @test */
    public function convert_to_array_splits_comma_separated_string()
    {
        $result = $this->danielle->convertToArray('one,two,three');

        $this->assertEquals(['one', 'two', 'three'], $result);
    }

    /** @test */
    public function convert_to_array_returns_empty_array_for_null()
    {
        $result = $this->danielle->convertToArray(null);

        $this->assertEquals([], $result);
    }

    /** @test */
    public function convert_to_comma_separated_string_joins_array()
    {
        $result = $this->danielle->convertToCommaSeparatedString(['one', 'two', 'three']);

        $this->assertEquals('one,two,three', $result);
    }

    /** @test */
    public function convert_to_comma_separated_string_returns_string_as_is()
    {
        $result = $this->danielle->convertToCommaSeparatedString('already_a_string');

        $this->assertEquals('already_a_string', $result);
    }

    /** @test */
    public function array_to_comma_list_joins_array_with_commas()
    {
        $result = $this->danielle->arrayToCommaList(['apple', 'banana', 'cherry']);

        $this->assertEquals('apple,banana,cherry', $result);
    }

    /** @test */
    public function strip_underscores_replaces_and_capitalizes()
    {
        $result = $this->danielle->stripUnderscores('test_text_here');

        $this->assertEquals('Test Text Here', $result);
    }

    /** @test */
    public function strip_dashes_removes_dashes()
    {
        $result = $this->danielle->stripDashes('test-text-here');

        $this->assertEquals('test text here', $result);
    }

    /** @test */
    public function strip_dots_removes_dots()
    {
        $result = $this->danielle->stripDots('test.text.here');

        $this->assertEquals('test text here', $result);
    }

    /** @test */
    public function add_to_cart_adds_item_to_session()
    {
        $data = ['product_id' => 1, 'quantity' => 2];

        $this->danielle->addToCart($data);

        $cart = Session::get('cart');
        $this->assertIsArray($cart);
        $this->assertContains($data, $cart);
    }

    /** @test */
    public function add_to_cart_creates_new_cart_if_none_exists()
    {
        Session::forget('cart');
        $data = ['product_id' => 1, 'quantity' => 2];

        $this->danielle->addToCart($data);

        $cart = Session::get('cart');
        $this->assertIsArray($cart);
        $this->assertEquals(1, count($cart));
        $this->assertEquals($data, $cart[0]);
    }

    /** @test */
    public function cart_returns_session_cart()
    {
        $cartData = [['product_id' => 1], ['product_id' => 2]];
        Session::put('cart', $cartData);

        $result = $this->danielle->cart();

        $this->assertEquals($cartData, $result);
    }

    /** @test */
    public function empty_cart_removes_cart_from_session()
    {
        Session::put('cart', [['product_id' => 1]]);

        $this->danielle->emptyCart();

        $this->assertNull(Session::get('cart'));
    }

    /** @test */
    public function set_cart_updates_session_cart()
    {
        $newCart = [['product_id' => 3], ['product_id' => 4]];

        $this->danielle->setCart($newCart);

        $this->assertEquals($newCart, Session::get('cart'));
    }

    /** @test */
    public function update_cart_modifies_existing_item()
    {
        $cart = [['product_id' => 1], ['product_id' => 2]];
        Session::put('cart', $cart);

        $updatedItem = ['product_id' => 1, 'updated' => true];
        $this->danielle->updateCart(0, $updatedItem);

        $cart = Session::get('cart');
        $this->assertEquals($updatedItem, $cart[0]);
        $this->assertEquals(['product_id' => 2], $cart[1]);
    }

    /** @test */
    public function remove_from_cart_by_index_removes_correct_item()
    {
        $cart = [['product_id' => 1], ['product_id' => 2], ['product_id' => 3]];
        Session::put('cart', $cart);

        $this->danielle->removeFromCartByIndex(1);

        $cart = Session::get('cart');
        $this->assertEquals(2, count($cart));
        $this->assertEquals(['product_id' => 1], $cart[0]);
        $this->assertEquals(['product_id' => 3], $cart[1]);
    }

    /** @test */
    public function get_from_cart_by_index_returns_correct_item()
    {
        $cart = [['product_id' => 1], ['product_id' => 2]];
        Session::put('cart', $cart);

        $result = $this->danielle->getFromCartByIndex(1);

        $this->assertEquals(['product_id' => 2], $result);
    }

    /** @test */
    public function get_from_cart_by_index_returns_false_for_invalid_index()
    {
        $cart = [['product_id' => 1]];
        Session::put('cart', $cart);

        $result = $this->danielle->getFromCartByIndex(5);

        $this->assertFalse($result);
    }

    /** @test */
    public function how_did_you_hear_about_us_options_returns_expected_options()
    {
        $options = $this->danielle->howDidYouHearAboutUsOptions();

        $this->assertIsArray($options);
        $this->assertContains('Famous Danielle Logo Around Town!', $options);
        $this->assertContains('Repeat Customer', $options);
        $this->assertContains('Online Search', $options);
        $this->assertContains('Recommendation', $options);
    }

    /** @test */
    public function input_classes_returns_input_string()
    {
        $result = $this->danielle->inputClasses();

        $this->assertEquals('input', $result);
    }

    /** @test */
    public function simplify_removes_spaces_ampersands_and_lowercases()
    {
        $result = $this->danielle->simplify('Test & String Here');

        $this->assertEquals('teststringhere', $result);
    }

    /** @test */
    public function unserialize_returns_unserialized_data()
    {
        $serialized = serialize(['key' => 'value', 'number' => 123]);

        $result = $this->danielle->unserialize($serialized);

        $this->assertEquals(['key' => 'value', 'number' => 123], $result);
    }

    /** @test */
    public function unserialize_returns_empty_array_for_invalid_data()
    {
        $result = $this->danielle->unserialize('invalid_serialized_data');

        $this->assertEquals([], $result);
    }

    /** @test */
    public function other_color_options_returns_true_when_hidden_modifier_exists()
    {
        $modifiers = serialize(['colorModifier1' => 'hidden']);
        $product = Diyproduct::factory()->create(['modifiers' => $modifiers]);

        $result = $this->danielle->otherColorOptions($product->id);

        $this->assertTrue($result);
    }

    /** @test */
    public function other_color_options_returns_false_when_no_hidden_modifiers()
    {
        $modifiers = serialize(['colorModifier1' => 'visible']);
        $product = Diyproduct::factory()->create(['modifiers' => $modifiers]);

        $result = $this->danielle->otherColorOptions($product->id);

        $this->assertFalse($result);
    }

    /** @test */
    public function with_modifier_total_calculates_price_with_height_modifier()
    {
        $modifiers = serialize(['heightModifier6ft' => 50]);
        $product = Diyproduct::factory()->create(['price' => 100, 'modifiers' => $modifiers]);

        $cartItem = ['product' => $product->id, 'height' => '6ft'];
        $result = $this->danielle->withModifierTotal($cartItem);

        $this->assertEquals(150, $result);
    }

    /** @test */
    public function with_modifier_total_calculates_price_with_color_modifier_percentage()
    {
        $modifiers = serialize(['colorModifierRed' => 10]); // 10% increase
        $product = Diyproduct::factory()->create(['price' => 100, 'modifiers' => $modifiers]);

        $cartItem = ['product' => $product->id, 'color' => 'Red'];
        $result = $this->danielle->withModifierTotal($cartItem);

        $this->assertEquals(110, $result);
    }

    /** @test */
    public function calculate_subtotal_from_cart_sums_all_items()
    {
        $modifiers = serialize([]);
        $product = Diyproduct::factory()->create(['price' => 100, 'modifiers' => $modifiers]);

        $cart = [
            ['product' => $product->id, 'qty' => 2],
            ['product' => $product->id, 'qty' => 1],
        ];

        $result = $this->danielle->calculateSubtotalFromCart($cart);

        $this->assertEquals(300, $result); // (100 * 2) + (100 * 1)
    }

    /** @test */
    public function calculate_subtotal_from_cart_returns_zero_for_empty_cart()
    {
        $result = $this->danielle->calculateSubtotalFromCart([]);

        $this->assertEquals(0, $result);
    }

    /** @test */
    public function calculate_subtotal_from_cart_returns_zero_for_null_cart()
    {
        $result = $this->danielle->calculateSubtotalFromCart(null);

        $this->assertEquals(0, $result);
    }

    /** @test */
    public function format_contact_data_for_email_formats_correctly()
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '555-1234',
            'service_area' => 'Tampa',
            'message' => 'Test message'
        ];

        $result = Danielle::formatContactDataForEmail($contactData);

        $this->assertEquals('John Doe', $result['customer_name']);
        $this->assertEquals('john@example.com', $result['customer_email']);
        $this->assertEquals('555-1234', $result['customer_phone']);
        $this->assertEquals('Tampa', $result['service_area']);
        $this->assertEquals('Test message', $result['message']);
        $this->assertArrayHasKey('formatted_date', $result);
    }

    /** @test */
    public function format_contact_data_for_email_handles_missing_fields()
    {
        $contactData = ['name' => 'John Doe'];

        $result = Danielle::formatContactDataForEmail($contactData);

        $this->assertEquals('John Doe', $result['customer_name']);
        $this->assertEquals('', $result['customer_email']);
        $this->assertEquals('', $result['customer_phone']);
        $this->assertEquals('', $result['service_area']);
        $this->assertEquals('', $result['message']);
    }
}