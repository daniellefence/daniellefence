<?php

namespace Database\Seeders;

use App\Models\Blog;
use Gaarf\XmlToPhp\Convertor;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $xml = file_get_contents('resources/xml/danielle-fence-wordpress.xml');
        $results = Convertor::covertToArray($xml);
        foreach ($results as $result) {
            if (isset($result['item'])) {
                foreach ($result['item'] as $item) {
                    Blog::create([
                        'title' => $item['title'],
                        'content' => $item['content:encoded'],
                        'user_id' => 1,
                        'blogcategory_id' => 1,
                        'show_date' => 0,
                    ]);
                }
            }
        }
    }
}
