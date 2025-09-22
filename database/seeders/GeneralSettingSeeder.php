<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    public $defaults = [
        'default_site_title' => [
            'label' => 'Default Site Title',
            'input_type' => 'text',
            'value' => 'Danielle Fence and Outdoor Living',
        ],
        'default_site_description' => [
            'label' => 'Default Site Description',
            'input_type' => 'textarea',
            'value' => 'At Danielle Fence, we supply and install residential and commercial fencing and outdoor living spaces throughout communities across the state of Florida.',
        ],
        'default_site_keywords' => [
            'label' => 'Default Keywords',
            'input_type' => 'textarea',
            'value' => 'fencing supply, fencing material, fence building companies, fence company, fence supply, fencing contractors nearby, vinyl fence, pvc fence panels, privacy fencing, home fence, fence repair, fencing equipment, fencing material near me, pvc fence cost, fence link, wood fence, buy vinyl fence, fence installation, aluminum fence panel, wooden fencing, discount fence',
        ],
        'google_recaptcha_site_key' => [
            'label' => 'Google Recaptcha Site Key',
            'input_type' => 'text',
            'value' => '6LdLJK8pAAAAAC2gmYq32R2FOTqmzPOB8sOj4dfy',
        ],
        'google_recaptcha_secret_key' => [
            'label' => 'Google Recaptcha Secret Key',
            'input_type' => 'text',
            'value' => '6LdLJK8pAAAAAGYrCPMAUFh5EwDq3zdsPxIL3DAV',
        ],
        'fence_quote_recipient_emails' => [
            'label' => 'Fence Quote Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'outdoor_kitchen_quote_recipient_emails' => [
            'label' => 'Outdoor Kitchen Quote Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'outdoor_spaces_quote_recipient_emails' => [
            'label' => 'Outdoor Spaces Quote Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'pavers_quote_recipient_emails' => [
            'label' => 'Pavers Quote Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'contact_recipient_emails' => [
            'label' => 'Contact Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'career_recipient_email' => [
            'label' => 'Career Application Recipient Email(s) (seperated by comma)',
            'input_type' => 'textarea',
            'value' => 'cshanebarron@gmail.com',
        ],
        'from_email' => [
            'label' => 'From Email Address',
            'input_type' => 'text',
            'value' => 'noreply@daniellehub.com',
        ],
        'app_title' => [
            'label' => 'App Title',
            'input_type' => 'text',
            'value' => 'Danielle Fence & Outdoor Living',
        ],
        'analytics' => [
            'label' => 'Google Analytics Code',
            'input_type' => 'textarea',
            'value' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-NPZ232T5XF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'G-NPZ232T5XF\');
</script>
     <script type="text/javascript">
        !function(){function t(){var t=r("utm_content");if(t){var e=new Date;e.setDate(e.getDate()+30),document.cookie=t+";expires="+e.toGMTString()+";path=/"}else if(document.cookie)for(var o=document.cookie.split(/; */),n=0;n<o.length;n++)if(0===o[n].toLowerCase().trim().indexOf("utm_content=")){t=o[n];break}return t}function e(t){try{console.log(t)}catch(e){alert(t)}}function r(t){var e=top.location.search?top.location.search.substring(1):null;if(e)for(var r=e.split("&"),o=0;o<r.length;o++)if(0===r[o].toLowerCase().trim().indexOf(t+"="))return r[o];return null}var o="",n=r("mctest");if(n)e("dnr tag version: 20160125"),o="http://localhost:8080/rip/library/dnr/mcDnrTag.debug.js";else{var a=t(),c="";a&&(c=top.location.search?0<=top.location.search.indexOf("utm_content")?top.location.search:top.location.search+"&"+a:"?"+a,o="https://script.advertiserreports.com/redirector/dnr"+c)}if(o){var i=document.createElement("script");i.src=o,i.type="text/javascript",scriptTag=document.getElementsByTagName("script")[0],scriptTag.parentNode.appendChild(i)}}();
    </script>',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->defaults as $key => $data) {
            setting()->set($key, $data['value'], $data['input_type']);
        }
    }
}
