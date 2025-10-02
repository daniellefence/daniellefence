<?php

namespace App;

use App\Mail\Application;
use App\Mail\ApplicationToUser;
use App\Mail\ChristmasHours;
use App\Mail\Contact;
use App\Mail\ContactToUser;
use App\Mail\FenceQuote;
use App\Mail\FenceQuoteToUser;
use App\Mail\Hurricane;
use App\Mail\OutdoorKitchenQuote;
use App\Mail\OutdoorSpacesQuote;
use App\Mail\PaversQuote;
use App\Mail\QuoteLeadReport;
use App\Mail\TrafficSourceReport;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\Documentationcategory;
use App\Models\QuoteRequest;
use App\Models\Tag;
use App\Models\Traffic;
use App\Services\CacheService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Danielle
{
    /**
     * Returns Header text or Buttons
     *
     * @return mixed|string
     */
    public function pageHeader($part)
    {
        $item = [];
        $buttons = [];
        $route = Route::currentRouteName();
        foreach (adminRoutes() as $r) {
            if ($r['name'] == $route) {
                $item = $r;
                break;
            }
        }
        // Return empty array for buttons if not set, empty string for other parts
        if ($part === 'buttons') {
            return $item[$part] ?? [];
        }

        return $item[$part] ?? '';
    }

    public function serviceCities()
    {
        $return = [
            'Arcadia',
            'Bowling Green',
            'Wauchula',
            'Zolfo Springs',
            'Brooksville',
            'Spring Hill',
            'Weeki Wachee',
            'Avon Park',
            'Lake Placid',
            'Lorida',
            'Sebring',
            'Apollo Beach',
            'Brandon',
            'Dover',
            'Gibsonton',
            'Lithia',
            'Lutz',
            'Mango',
            'Plant City',
            'Riverview',
            'Ruskin',
            'Seffner',
            'Sun City Center',
            'Sydney',
            'Tampa',
            'Temple Terrace',
            'Thonotosassa',
            "Town 'n Country",
            'Valrico',
            'Wimauma',
            'Lithia',
            'Kissimmee',
            'Poinciana',
            'St. Cloud',
            'Bayonet Point',
            'Crystal Springs',
            'Dade City',
            'Elfers',
            'Holiday',
            'Hudson',
            'Lacoochee',
            'Land o’ Lakes',
            'New Port Richey',
            'Odessa',
            'Port Richey',
            'St. Leo',
            'San Antonio',
            'Trinity',
            'esley Chapel',
            'Zephyrhills',
            'Wesley Chapel',
            'Zephyrhills',
            'Bay Pines',
            'Belleair',
            'Belleair Bluffs',
            'Clearwater',
            'Crystal Beach',
            'Dunedin',
            'Gulfport',
            'Largo',
            'Madeira Beach',
            'Oldsmar',
            'Ozona',
            'Palm Harbor',
            'Pinellas Park',
            'Redington Beach',
            'Safety Harbor',
            'St. Pete Beach',
            'St. Petersburg',
            'Seminole',
            'St. Petersburg',
            'Tarpon Springs',
            'Treasure Island',
            'Alturas',
            'Auburndale',
            'Babson Park',
            'Bartow',
            'Bradley Junction',
            'Davenport',
            'Dundee',
            'Eagle Lake',
            'Fort Meade',
            'Frostproof',
            'Haines City',
            'Highland City',
            'Homeland',
            'Indian Lake Estates',
            'Kathleen',
            'Lake Alfred',
            'Lake Hamilton',
            'Lake Wales',
            'Lakeland',
            'Loughman',
            'Mulberry',
            'Nalcrest',
            'Nichols',
            'Polk City',
            'Waverly',
            'Winter Haven',
            'Manasota',
            'Osprey',
            'Sarasota',
            'Webster',
        ];
        asort($return);

        return $return;
    }

    public function categoryImage($id)
    {
        $productCategory = Category::find($id);

        return url($productCategory->photo->path);
    }

    public function categoryTitle($id)
    {
        $productCategory = Category::find($id);

        return $productCategory->title;
    }

    public function carouselShowTitle($key)
    {
        if (in_array($key, [
            'home',
        ])) {
            return true;
        } else {
            return false;
        }
    }

    public function carouselParseTitle($key, $count)
    {
        $return = '';
        switch ($key) {
            case 'home':
                switch ($count) {
                    case 1:
                        $return = '<p>A Company</p><p>You Can Trust<p>Since 1976</p>';
                        break;
                    case 2:
                        $return = '<p>Over 48 Years</p><p>Of Quality</p><p>Installations</p>';
                        break;
                    case 3:
                        $return = '<p>View Our</p><p>Selection Of</p><p>Fence and Gates</p>';
                        break;
                    case 4:
                        $return = '<p>Over 1000</p><p>Outdoor Kitchens</p><p>Installed</p>';
                        break;
                }
                break;
        }

        return $return;
    }

    public function parseKeywords($model)
    {
        $keywords = json_decode($model->keywords);
        if ($keywords) {
            return $keywords;
        }

        return [];
    }

    public function defaultButtonClasses($type)
    {
        $default = ' inline-flex justify-center items-center border rounded-md font-semibold uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 ';
        switch ($type) {
            case 'danger':
                return $default.' bg-danger border-danger text-white hover:bg-danger_alt focus:ring-danger_alt focus-visible:outline-danger_alt ';
                break;
            case 'success':
                return $default.' bg-success border-success text-white hover:bg-success_alt focus:ring-success_alt focus-visible:outline-success_alt ';
                break;
            case 'info':
                return $default.' bg-info border-info text-black hover:bg-info_alt focus:ring-info_alt focus-visible:outline-info_alt ';
                break;
            case 'primary':
                return $default.' bg-primary border-primary text-white hover:bg-primary_alt focus:ring-primary_alt focus-visible:outline-primary_alt ';
                break;
            case 'warning':
                return $default.' bg-warning border-warning text-black hover:bg-warning_alt focus:ring-warning_alt focus-visible:outline-warning_alt ';
                break;
            case 'secondary':
                return $default.' bg-gray-100 border-gray-200 text-black hover:bg-gray-200 focus:ring-gray-200 focus-visible:outline-gray-200 ';
                break;
        }
    }

    public function defaultButtonPadding($size)
    {
        switch ($size) {
            case 'small':
                return ' rounded px-2 py-1 text-xs font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 ';
                break;
            case 'normal':
            default:
                return ' rounded-md px-2 py-2 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 ';
                break;
            case 'large':
                return ' rounded-md px-4 py-5 text-lg font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 ';
                break;
        }
    }

    public function sendMail($type, $model)
    {

        //        Mail::to($model->email)->send(new Hurricane($model));
        //        dump($model);
        //        Mail::to($model->email)->send(new ChristmasHours());
        switch ($type) {
            case 'fence_quote':
                $recipients = setting()->get('fence_quote_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new FenceQuote($model));
                }
                break;
            case 'contact':
                $recipients = setting()->get('contact_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new Contact($model));
                }
                break;
            case 'application':
                $recipients = setting()->get('career_recipient_email');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new Application($model));
                }
                break;
            case 'outdoor_kitchen_quote':
                $recipients = setting()->get('outdoor_kitchen_quote_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new OutdoorKitchenQuote($model));
                }
                break;
            case 'outdoor_spaces_quote':
                $recipients = setting()->get('outdoor_spaces_quote_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new OutdoorSpacesQuote($model));
                }
                break;
            case 'pavers_quote':
                $recipients = setting()->get('pavers_quote_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new PaversQuote($model));
                }
                break;
        }
    }

    public function sendMailBackup($type, $model)
    {
        switch ($type) {

            case 'general':
            case 'fence_quote':
                $recipients = setting()->get('fence_quote_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    //                    Mail::to($recipient)->send(new FenceQuote($model));
                }
                // email user
                Mail::to('sbarron@daniellefence.net')->send(new FenceQuoteToUser($model));
                break;
            case 'contact':
                $recipients = setting()->get('contact_recipient_emails');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    //                    Mail::to($recipient)->send(new Contact($model));
                }
                // email user
                Mail::to('sbarron@daniellefence.net')->send(new ContactToUser($model));
                break;
            case 'application':
                $recipients = setting()->get('career_recipient_email');
                $recipients = explode(',', $recipients);
                foreach ($recipients as $recipient) {
                    //                    Mail::to($recipient)->send(new Application($model));
                }
                // email user
                Mail::to('sbarron@daniellefence.net')->send(new ApplicationToUser($model));
                break;

        }
    }

    public function getListOfSubcategoriesFromSubcategory($subcategory, $return = [], $type = 'admin')
    {
        while ($subcategory->parent_id) {
            $subcategory = Category::findOrFail($subcategory->parent_id);
            $return[] = [
                'label' => $subcategory->title,
                'url' => $type == 'admin' ? $subcategory->getAdminRoute() : $subcategory->getRoute(),
            ];
        }

        return $return;
    }

    public function getCategoryFromSubcategory($subcategory)
    {
        while ($subcategory->parent_id) {
            $subcategory = Category::findOrFail($subcategory->parent_id);
        }

        return $subcategory; // Now returns the root category since categories are self-referential
    }

    public function decode($string)
    {
        $pass1 = str_replace('_', ' ', $string);

        return ucwords($pass1);
    }

    public function getDropdownBlogCategories()
    {
        $return = [];
        foreach (Blogcategory::all() as $blogCategory) {
            $return[$blogCategory->id] = $blogCategory->title;
        }

        return $return;
    }

    public function getDropdownDocumentationCategories()
    {
        $return = [];
        foreach (Documentationcategory::all() as $documentationCategory) {
            $return[$documentationCategory->id] = $documentationCategory->title;
        }

        return $return;
    }


    public function tagsDropdown()
    {
        $tags = Tag::orderBy('title', 'asc')->get();
        $return[0] = 'Choose a keyword to add.';
        foreach ($tags as $tag) {
            $return[$tag->title] = $tag->title;
        }

        return $return;
    }

    public function flashMessage($message, $status = 'success')
    {
        $message = trans('danielle.'.$message);
        flash()->$status($message);
    }

    public function labelize($text)
    {
        if (is_array($text)) {
            return;
        }
        $return = str_replace('_', ' ', $text);

        return ucwords($return);
    }

    public function convertToArray($value)
    {
        if ($value) {
            return explode(',', $value);
        }

        return [];
    }

    public function convertToCommaSeparatedString($value)
    {
        if (! is_array($value)) {
            return $value;
        }

        return implode(',', $value);
    }

    public function arrayToCommaList($array)
    {
        return implode(',', $array);
    }

    public function stripUnderscores($text)
    {
        return ucwords(str_replace('_', ' ', $text));
    }

    public function stripDashes($text)
    {
        return str_replace('-', ' ', $text);
    }

    public function stripDots($text)
    {
        return str_replace('.', ' ', $text);
    }

    public function addToCart($data)
    {
        $cart = Session::get('cart');
        if (! $cart) {
            $cart = [];
        }
        $cart[] = $data;
        Session::put('cart', $cart);
    }

    public function cart()
    {
        return Session::get('cart');
    }

    public function emptyCart()
    {
        Session::forget('cart');
    }

    public function setCart($cart)
    {
        Session::put('cart', $cart);
    }

    public function updateCart($key, $item)
    {
        $cart = Session::get('cart');
        if (isset($cart[$key])) {
            $cart[$key] = $item;
            $this->setCart($cart);
        }
    }

    public function removeFromCartByIndex($index)
    {
        $cart = array_values($this->cart());
        if (isset($cart[$index])) {
            unset($cart[$index]);
        }
        $this->setCart(array_values($cart));
    }

    public function getFromCartByIndex($index)
    {
        $cart = array_values($this->cart());
        if (isset($cart[$index])) {
            return $cart[$index];
        }

        return false;
    }

    public function howDidYouHearAboutUsOptions()
    {
        return [
            'Famous Danielle Logo Around Town!',
            'Repeat Customer',
            'Door Hanger',
            'Recommendation',
            'Online Search',
            'TheHomeMag Mailing',
            'TheHomeMag Email',
        ];
    }

    public function mailWeeklyHowDidYouHearAboutUsReport()
    {
        $contactRequests = \App\Models\Contact::whereBetween('created_at',
            [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
        )->get();
        $quoteRequests = QuoteRequest::whereBetween('created_at',
            [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
        )->get();
        $overallRequests = $contactRequests->merge($quoteRequests);
        $results = [];
        foreach ($overallRequests as $request) {
            if (! isset($results[$request->how_did_you_hear_about_us])) {
                $results[$request->how_did_you_hear_about_us] = 1;
            } else {
                $results[$request->how_did_you_hear_about_us] = $results[$request->how_did_you_hear_about_us] + 1;
            }
        }
        Mail::to([
            'cshanebarron@gmail.com',
            //            'sbarron@daniellefence.net',
            //            'cperez@daniellefence.net',
            //            'marc@daniellefence.net'
        ])->send(new QuoteLeadReport($results));
    }

    public function mailWeeklyTrafficSourcesReport()
    {
        $results = [];
        $traffic = Traffic::whereBetween('created_at',
            [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
        )->get();
        $traffic = Traffic::all();
        foreach ($traffic as $t) {
            // filer out clicks within app
            if (! strpos($t, 'danielle')) {
                if (! isset($results[$t->source])) {
                    $results[$t->source] = 1;
                } else {
                    $results[$t->source] = $results[$t->source] + 1;
                }
            }

        }
        Mail::to([
            //            'sbarron@daniellefence.net',
            //            'cperez@daniellefence.net',
            //            'marc@daniellefence.net'
        ])->send(new TrafficSourceReport($results));
    }

    public function pullGoogleReviews() {}

    /**
     * Returns the default input classes
     *
     * @return string
     */
    public function inputClasses()
    {
        return 'input';
    }

    public function simplify($text)
    {
        return strtolower(str_replace('&', '', str_replace(' ', '', $text)));
    }

    public function unserialize($data)
    {
        return unserialize($data) ?? [];
    }

    public function modifier($product, $modifier)
    {
        $modifiers = danielle()->unserialize($product->modifiers);
        if (isset($modifiers['colorModifier'.$modifier])) {
            return $modifiers['colorModifier'.$modifier];
        }
        if (isset($modifiers['heightModifier'.$modifier])) {
            return $modifiers['heightModifier'.$modifier];
        }
        if (isset($modifiers['spacingModifier'.str_replace('.', '', $modifier)])) {
            return $modifiers['spacingModifier'.str_replace('.', '', $modifier)];
        }
    }


    /**
     * Get cached areas we serve
     */
    public static function getAreasWeServe()
    {
        return CacheService::getAreasWeServe();
    }

    /**
     * Get cached available colors
     */
    public static function getAvailableColors()
    {
        return CacheService::getAvailableColors();
    }

    /**
     * Calculate price with modifiers using cache
     */
    public static function calculatePriceWithModifiers($basePrice, $modifierIds = [])
    {
        return CacheService::calculatePriceWithModifiers($basePrice, $modifierIds);
    }

    /**
     * Validate service area using cache
     */
    public static function isServiceAreaValid($area)
    {
        return CacheService::isServiceAreaValid($area);
    }

    /**
     * Format contact data for email notifications
     */
    public static function formatContactDataForEmail($contactData)
    {
        return [
            'customer_name' => $contactData['name'] ?? '',
            'customer_email' => $contactData['email'] ?? '',
            'customer_phone' => $contactData['phone'] ?? '',
            'service_area' => $contactData['service_area'] ?? '',
            'message' => $contactData['message'] ?? '',
            'formatted_date' => now()->format('F j, Y g:i A'),
        ];
    }
}
