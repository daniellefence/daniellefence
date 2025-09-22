<?php

namespace App;

use Illuminate\Support\Facades\Hash;

class Seeds
{
    public function users()
    {
        return [
            [
                'name' => 'Shane Barron',
                'email' => 'sbarron@daniellefence.net',
                'password' => Hash::make('DFMGN@dm!n$'),
                'title' => 'Marketing',
            ],
            [
                'name' => 'Marc Glowgower',
                'email' => 'marc@daniellefence.net',
                'password' => Hash::make('password'),
                'title' => 'President',
            ],
            [
                'name' => 'Chris Perez',
                'email' => 'cperez@daniellefence.net',
                'password' => Hash::make('password'),
                'title' => 'C.F.O.',
            ],
            [
                'name' => 'Pepe Berrios',
                'email' => 'pepe@daniellefence.net',
                'password' => Hash::make('password'),
                'title' => 'C.P.O',
            ],
            [
                'name' => 'Paul Glowgower',
                'email' => 'paul@daniellefence.net',
                'password' => Hash::make('password'),
                'title' => 'Vice President',
            ],
            [
                'name' => 'David Acevedo',
                'email' => 'david@screenbuilders.com',
                'password' => Hash::make('password'),
                'title' => 'Owner',
            ],
            [
                'name' => 'Alvaro Acevedo',
                'email' => 'alvaro@screenbuilders.com',
                'password' => Hash::make('password'),
                'title' => 'General Manager',
            ],
            [
                'name' => 'Corey Dahlman',
                'email' => 'cdahlman@daniellefence.net',
                'password' => Hash::make('password'),
                'title' => 'Webmaster',
            ],
        ];
    }

    public function routes()
    {
        return [
            'acceptable-use' => 'Acceptable Use Policy',
            'about-us' => 'About Us',
            'apply' => 'Apply',
            'blog' => 'Blog',
            'careers' => 'Careers',
            'commercial' => 'Commercial',
            'contact' => 'Contact',
            'cookie-policy' => 'Cookie Policy',
            'discounts-deals' => 'Discounts & Deals',
            'diy' => 'DIY',
            'easy-fixes' => 'Easy Fixes',
            'faq' => 'FAQ',
            'disclaimer' => 'Disclaimer',
            'financing' => 'Financing',
            'fire-feature-catalogs' => 'Fire Feature Catalogs',
            'home' => 'Home',
            'mascots' => 'Mascots',
            'privacy' => 'Privacy',
            'product-warranties' => 'Product Warranties',
            'request-a-quote' => 'Request a Quote',
            'reviews' => 'Reviews',
            'search' => 'Search',
            'showroom' => 'Showroom',
            'specials' => 'Specials',
            'videos' => 'Videos',
            'why-danielle-fence' => 'Why Danielle Fence',
            'terms' => 'Terms',
            'returns' => 'Returns',
        ];
    }

    public function createKey($text)
    {
        $numbers = [
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            0 => 'zero',
        ];
        $pass1 = str_replace(' ', '-', $text);
        $pass2 = strtolower($pass1);
        $pass3 = str_replace('&', 'and', $pass2);
        $pass3 = str_replace('.', '', $pass3);
        $pass3 = str_replace(',', '', $pass3);
        $pass3 = str_replace('/', '', $pass3);
        $pass3 = str_replace("'", '', $pass3);
        foreach ($numbers as $number => $word) {
            $pass3 = str_replace($number, $word, $pass3);
        }

        return $pass3;
    }

    public function products(): array
    {
        return [
            [
                'title' => 'Fence & Gates',
                'description' => '<h3>SELECTING YOUR FENCE STYLE</h3><p>At Danielle Fence &  Outdoor Living, we offer a variety of vinyl (PVC) fence styles. Depending on the amount of privacy you need or the type of look you would like to achieve, we know you will find the perfect solution for your outdoor space with us. </p>',
                'subcategories' => [
                    [
                        'title' => 'Vinyl Fence',
                        'description' => 'Vinyl Fence',
                        'subcategories' => [
                            [
                                'title' => 'Privacy Fence',
                                'products' => [
                                    [
                                        'title' => 'Lakeland Vinyl Fence',
                                        'description' => "The Lakeland Vinyl Fence is one of Danielle Fence & Outdoor Living's most popular full privacy PVC/vinyl tongue and groove fence styles and can be used for various residential and commercial applications. It is one of the most versatile and easily customized PVC/vinyl fence styles. Whether around a pool, garden, patio, or to enclose a pool pump, there is a style and color as well as a new natural wood grain texture for you. Add a convex or concave top or combine with a PVC/vinyl picket style fence. You can even combine almond posts, post caps and rails with white pickets. The possibilities are endless.",
                                        'pip' => 'BGM-LAKELAND-RESIDENTIAL_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Lakeland Horizontal Vinyl Fence',
                                        'description' => "The Lakeland Horizontal Vinyl Fence is a style option within the Lakeland Fence line. The horizontal layout of the pickets gives this fence a unique look that can make your yard stand out amongst the rest. The Lakeland Vinyl Fence is one of Danielle Fence & Outdoor Living's most popular full privacy PVC/vinyl tongue and groove fence styles. It can be used for various residential and commercial applications, such as around a pool, lawn, garden, patio, or to enclose a pool pump. Versatile and easily customizable, there is a style and color as well as a natural wood grain texture for you.",
                                        'pip' => 'BGM-LAKELAND-HORIZONTAL_04162021.pdf',
                                    ],
                                    [
                                        'title' => 'Lakeland Convex Vinyl Fence',
                                        'description' => 'The Lakeland Convex Vinyl Fence is a style option within the Lakeland Fence line. The convex top adds a beautiful custom look. Like the original Lakeland Vinyl Fence, the convex option provides full privacy and can be used for various residential and commercial applications. It is one of the most versatile and easily customized PVC/vinyl fence styles. Whether around a pool, garden, patio, or to enclose a pool pump, there is a style and color as well as a new natural wood grain texture for you.',
                                        'pip' => 'BGM-LAKELAND-CONVEX_04062021.pdf',
                                    ],
                                    //                                        [
                                    //                                            "title" => "Lakeland 2A HVHZ PVC Fence",
                                    //                                            "description"=>"The Lakeland 2A HVHZ PVC Fence is a hurricane-grade fence that provides a solid privacy wall featuring tongue and groove verticals for greater fence strength. Danielle Fence & Outdoor Living offers a complete line of Notice of Acceptance (NOA) Hurricane Approved Hurricane Zone vinyl privacy and semi-privacy fencing approved for use by the Miami-Dade County Building Code Compliance Office (BCCO) in designated High Velocity Hurricane Zones (HVHZ) and High Velocity Wind Zones (HVWZ). The Miami-Dade County BCCO approval system requires manufacturers of building products to receive written approval through the issuance of a NOA through the Product Control Division. Manufacturers must submit for each product: full technical documentation including - test reports, engineering analysis, and installation procedures for detailed review. Only products that pass this stringent testing and review process receive a NOA.",
                                    //                                            "pip"=>"BGM-LAKELAND-RESIDENTIAL_NPC_01282021.pdf"
                                    //                                        ],
                                    [
                                        'title' => 'Lakeland Concave Vinyl Fence',
                                        'description' => 'The Lakeland Concave Vinyl Fence is a style option within the Lakeland Fence line. The concave top adds a beautiful custom look. Like the original Lakeland Vinyl Fence, the concave option provides full privacy and can be used for various residential and commercial applications. It is one of the most versatile and easily customized PVC/vinyl fence styles. Whether around a pool, garden, patio, or to enclose a pool pump, there is a style and color as well as a new natural wood grain texture for you.',
                                        'pip' => 'BGM-LAKELAND-CONCAVE_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Maxwell Vinyl Fence',
                                        'description' => 'The Maxwell Decorative Top Rail Vinyl Fence is available exclusively at Danielle Fence & Outdoor Living. This signature and distinctive 4in. x 6in. vinyl top rail fence is exceptional in both style and utility.',
                                        'pip' => 'BGM-MAXWELL_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Horizontal Maxwell Vinyl Fence',
                                        'description' => 'The Maxwell Decorative Top Rail Vinyl Fence is available exclusively at Danielle Fence & Outdoor Living. This new signature 4in. x 6in. vinyl top rail is the perfect addition to turn any fence into something exceptional.',
                                        'pip' => 'BGM-MAXWELL-HORIZONTAL_04072021.pdf',
                                    ],
                                    [
                                        'title' => 'Windsor Vinyl Fence',
                                        'description' => 'The Windsor Vinyl Fence offers a unique "basket weave"
        design and provides a great look for any style home. The Windsor Vinyl Fence is sure to give your backyard the charm and elegance it deserves.',
                                        'pip' => 'CEF-WINDSOR_07292020.pdf',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Semi-Privacy Fence',
                                'description' => 'Semi-Privacy Fence',
                                'products' => [
                                    [
                                        'title' => 'Hollingsworth Vinyl Fence',
                                        'description' => 'The Hollingsworth Vinyl Fence provides a strong, secure and attractive semi-privacy wall for homes and businesses alike. The clean lines of the Hollingsworth Vinyl Fence are complemented with a decorative layer of lattice along the top of the fence, making this option great for sprucing up curb appeal.',
                                        'pip' => 'BGM-HOLLINGSWORTH_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Montauk Vinyl Fence',
                                        'description' => 'The Montauk Vinyl Fence is a classic choice for both privacy and security. The Montauk Vinyl Fence series boasts multiple color combinations, including white, almond, grey and adobe. Styles include a choice of straight, concave, convex, flat, scalloped or step tops.',
                                        'pip' => 'BGM-MONTAUK_04052021.pdf',
                                    ],
                                    [
                                        'title' => 'Heather Vinyl Fence',
                                        'description' => 'The Heather Vinyl Fence is the perfect addition to any outdoor living space. Complete with clean lines that are complimented with eye-level decorative cross rails, the Heather Vinyl Fence offers privacy and style.',
                                        'pip' => 'CEF-HEATHER_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Lakeview Vinyl Fence',
                                        'description' => 'The Lakeview Vinyl Fence offers a sleek look and is complimentary to many modern home styles. With carefully spaced verticals, it allows for fresh air to flow through without sacrificing the privacy you desire.',
                                        'pip' => 'BGM-LAKEVIEW_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Oceanside Vinyl Fence',
                                        'description' => 'The Oceanside Vinyl Fence is a beautiful semi-private addition to any home. The style combines alternating vertical widths that create a pleasing backdrop to display your home and garden.',
                                        'pip' => 'BGM-OCEANSIDE_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Melbourne 2 Vinyl Fence',
                                        'description' => 'The Melbourne 2 Vinyl Fence provides the security and privacy you desire for your home. The beautiful style is great for surrounding patios or pools, while allowing air to pass between the offset verticals.',
                                        'pip' => 'CEF-MELBOURNE_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Melbourne Lattice Vinyl Fence',
                                        'description' => 'The Melbourne Lattice Vinyl Fence provides the security and privacy you desire for your home. The beautiful style is great for surrounding patios or pools, while allowing air to pass between the offset verticals.',
                                        'pip' => 'CEF-MELBOURNE_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Highland Vinyl Fence',
                                        'description' => 'The Highland Vinyl Fence is an ideal choice for homeowners who like their privacy with a touch of style. The tongue and groove verticals provide strength, while the decorative top allows ventilation.',
                                        'pip' => 'CEF-HIGHLAND_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Spirit Lake Vinyl Fence',
                                        'description' => 'The Spirit Lake Vinyl Fence provides a distinctive style that complements a variety of home designs. With its alternating spears and full height pickets, this fence is sure to add charm to your home and yard.',
                                        'pip' => 'Spirit-Lake-Vinyl-Fence_PIP_oldversion.pdf',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Picket Fence',
                                'products' => [
                                    [
                                        'title' => 'Sacramento Vinyl Fence',
                                        'description' => 'The Sacramento Vinyl Fence combines the look of a traditional picket fence with a contemporary style. The 1-1/2in. square pickets give the Sacramento Vinyl Fence a very clean and attractive look. You can also customize this fence with a convex or concave top, providing an elegant flair to make your outdoor space look even more beautiful. View our portfolio of projects to see the different style options available.',
                                        'pip' => 'BGM-SACRAMENTO_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Sundance Vinyl Fence',
                                        'description' => 'The Sundance Vinyl Fence boasts the simplicity of a traditional picket fence, without all the maintenance. You can also customize your Sundance Vinyl Fence with a concave top and gothic post cap, providing an elegant flair to make your outdoor space even more beautiful. Other style options include the traditional point straight look, and flat top with a middle rail. View our portfolio of projects to see the different style options available.',
                                        'pip' => 'BGM-SUNDANCE_NPC_01282021.pdf',
                                    ],
                                    [
                                        'title' => 'Dawson Vinyl Fence',
                                        'description' => 'The Dawson Vinyl Fence is the perfect fence for your backyard. It has tighter picket spacing to add privacy, and is great for enclosing pets or defining an area. Available in 48in., 60in. and 72in. heights.',
                                        'pip' => 'BGM-DAWSON_04062021.pdf',
                                    ],
                                    [
                                        'title' => 'Dartmouth Vinyl Fence',
                                        'description' => 'The Dartmouth Vinyl Fence adds a touch of Victorian tradition to any home. A great way to add value, the Dartmouth Vinyl Fence is the perfect choice for your home if you are looking for more privacy than your traditional picket fence. Available in 48in., 60in. and 72in. heights.',
                                        'pip' => 'CEF-DARTMOUTH_04062021.pdf',
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Post & Rail Fence',
                                'products' => [
                                    [
                                        'title' => '2-Rail Post & Rail Vinyl Fence',
                                        'description' => "The 2-Rail Post & Rail Vinyl Fence is a traditional pasture fence in a 2-rail option. Also available are 3-rail, 4-rail and Crossbuck options. Danielle Fence & Outdoor Living's 2-Rail Post & Rail Fence is made from 100% virgin vinyl ribbed rails with UV protection. This fence will prevent you from ever having to paint again.",
                                        'pip' => 'BGM-POST-N-RAIL_02172021.pdf',
                                    ],
                                    [
                                        'title' => '3-Rail Post & Rail Vinyl Fence',
                                        'description' => "The 3-Rail Post & Rail Vinyl Fence is a traditional pasture fence in a 3-rail option. Also available are 2-rail, 4-rail and Crossbuck options. Danielle Fence & Outdoor Living's 3-Rail Post & Rail Fence is made from 100% virgin vinyl ribbed rails with UV protection. This fence will prevent you from ever having to paint again.",
                                        'pip' => 'BGM-POST-N-RAIL_02172021.pdf',
                                    ],
                                    [
                                        'title' => '4-Rail Post & Rail Vinyl Fence',
                                        'description' => "The 4-Rail Post & Rail Vinyl Fence is a traditional pasture fence in a 4-rail option. Also available are 2-rail, 3-rail and Crossbuck options. Danielle Fence & Outdoor Living's 4-Rail Post & Rail Fence is made from 100% virgin vinyl ribbed rails with UV protection. This fence will prevent you from ever having to paint again.",
                                        'pip' => 'BGM-POST-N-RAIL_02172021.pdf',
                                    ],
                                    [
                                        'title' => 'Crossbuck Post & Rail Vinyl Fence',
                                        'description' => 'The Crossbuck Post & Rail Vinyl Fence is a traditional post & rail vinyl fence that has been taken to the next level! This fence is made from 100% virgin UV protected vinyl, which will prevent you from ever having to paint again. The Crossbuck Post & Rail Vinyl Fence is offered in several color and height patterns.',
                                        'pip' => 'BGM-CROSSBUCK_04062021.pdf',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'title' => 'Wood Fence',
                        'products' => [
                            [
                                'title' => 'Stockade Wood Fence',
                                'description' => 'The water-sealed Stockade Wood Fence adds elegance and privacy to your yard or garden. The classic beauty of natural wood will provide years of satisfaction. The pressure-treated and water-sealed wood is protected from fungal decay and termite attacks with the environmentally advanced non-arsenic and non-chromium ASO preservative system. This fence can be painted or stained to match any outdoor color scheme. Left uncoated, water-sealed wood will weather to gray following exposure to the elements.',
                                'pip' => 'Water-Sealed-Wood-Fence.pdf',
                            ],
                            [
                                'title' => 'Wood Board on Board Fence',
                                'description' => 'The water-sealed Wood Board on Board Fence adds beauty and privacy to your yard or garden. The classic beauty of natural wood will provide years of satisfaction. The water-sealed and pressure-treated wood is protected from fungal decay and termite attacks with the environmentally advanced non-arsenic and non-chromium ASO preservative system. Your water-sealed Wood Board on Board Fence can be painted or stained to match any outdoor color scheme. Left uncoated, water-sealed wood will weather to gray following exposure to the elements.',
                                'pip' => 'Water-Sealed-Wood-Fence.pdf',
                            ],
                            [
                                'title' => 'Picket Wood Fence',
                                'description' => 'The water-sealed Picket Wood Fence adds beauty and privacy to your yard or garden. The classic beauty of natural wood will provide years of satisfaction. The water-sealed and pressure-treated wood is protected from fungal decay and termite attacks with the environmentally advanced non-arsenic and non-chromium ASO preservative system. Your water-sealed Picket Wood Fence can be painted or stained to match any outdoor color scheme. Left uncoated, water-sealed wood will weather to gray following exposure to the elements.',
                                'pip' => 'Water-Sealed-Wood-Fence.pdf',
                            ],
                            [
                                'title' => 'Shadowbox Wood Fence',
                                'description' => 'The water-sealed Shadowbox Wood Fence adds beauty and privacy to your yard or garden. The classic beauty of natural wood will provide years of satisfaction. The water-sealed and pressure-treated wood is protected from fungal decay and termite attacks with the environmentally advanced non-arsenic and non-chromium ASO preservative system. Your water-sealed Shadowbox Wood Fence can be painted or stained to match any outdoor color scheme. Left uncoated, water-sealed wood will weather to gray following exposure to the elements.',
                                'pip' => 'Water-Sealed-Wood-Fence.pdf',
                            ],
                            [
                                'title' => 'Custom Wood Fence',
                                'description' => '',
                                'pip' => 'Water-Sealed-Wood-Fence.pdf',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Aluminum Fence',
                        'products' => [
                            [
                                'title' => 'Avalon Aluminum Fence',
                                'description' => 'Our elegant Avalon Aluminum Fence has sleek designs and clean lines that will add the perfect finishing touch to any outdoor space. With its flat top design, this aluminum fencing style is available in five grades and optional Royale and Puppy Picket styles. The Avalon Aluminum Fence is also available in commercial and industrial grades.',
                                'pip' => 'AVALON-RESIDENTIAL_07082020.pdf',
                            ],
                            [
                                'title' => 'Viera Aluminum Fence',
                                'description' => "The Viera Aluminum Fence has exposed picket points on the top, giving it a classic wrought iron design without the costly and time-consuming maintenance required of other fencing materials. This aluminum fence will enhance your home's outdoor living space while also providing boundary definition. The Viera Aluminum Fence is also available in commercial and industrial grades.",
                                'pip' => 'Hawthorne-Residential_05032021-1.pdf',
                            ],
                            [
                                'title' => 'Capeview Aluminum Fence',
                                'description' => "The Capeview Aluminum Fence is functional, simple and strong. Perfect for enhancing your home's decorative style. The flat top of the Capeview Aluminum Fence with its ornate beauty has an alternating pattern of spears followed by one full length picket. The Capeview Aluminum Fence is also available in commercial and industrial grades.",
                                'pip' => 'Capeview-Residential_05032021.pdf',
                            ],
                            [
                                'title' => 'Bentley Aluminum Fence',
                                'description' => "The Bentley Aluminum Fence has pressed spear pickets, giving it a classic wrought iron design without the costly and time-consuming maintenance required of other fencing materials. This aluminum fence will enhance your home's outdoor living space while also providing boundary definition. Available with both Double and Puppy Picket options. The Bentley Aluminum Fence is also available in commercial and industrial grades.",
                                'pip' => 'Bentley-Municipal_03252021.pdf',
                            ],
                            [
                                'title' => 'Hawthorne Aluminum Fence',
                                'description' => 'The Hawthorne Aluminum Fence creates aesthetic security while decoratively enhancing your landscaped area. With its alternating spear length design, this fence is ideal for keeping pets contained and children protected, while providing boundaries to unwanted visitors. The Hawthorne Aluminum Fence is also available in commercial and industrial grades.',
                                'pip' => 'Hawthorne-Residential_05032021.pdf',
                            ],
                            [
                                'title' => 'Fairmont Aluminum Fence',
                                'description' => 'The Fairmont Aluminum Fences functional, clean, and classic design is perfect for enhancing your home. The flat top of the Fairmont Aluminum Fence paired with its alternating picket pattern is sure to catch the eye of anyone that passes. The Fairmont Aluminum Fence is also available in commercial and industrial grades.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Allegheny & Sherwood Fence',
                        'products' => [
                            [
                                'title' => 'Allegheny Bufftech Molded Fence',
                                'description' => 'Perfect for any setting, the simulated stone Allegheny Bufftech Molded Fence is a great vinyl fence alternative. Its strength and durability help it to stand up against abuse, including repeated hits from a baseball hurled at over 90 mph. The Allegheny Bufftech Molded decorative backyard fence features the look and feel of natural granite stone, but it doesn’t carry the high price tag typically associated with traditional rock and stone walls. Allegheny is a quality product proudly manufactured by Bufftech.',
                            ],
                            [
                                'title' => 'Sherwood Bufftech Molded Fence',
                                'description' => 'The Sherwood Bufftech Molded Fence panels are made from a proprietary blend of polyethylene and contain up to 25% recycled material. No trees are cut down for the purpose of manufacturing this fence. Sherwood is a quality product proudly manufactured by BuffTech. The Sherwood Bufftech Molded Fence contains UV-12 inhibitors for a lifetime of vibrant colors. This fence will not warp, fade or crack, and will never need to be stained. It withstands temperatures from -40º F to +140º F and is not affected by water or salt spray, and is resistant to any negative organic processes.',
                            ],
                            [
                                'title' => 'Allegheny Bufftech Molded Gates',
                                'description' => 'The Allegheny Bufftech Molded Fence has engineered gates that come with internal galvanized steel reinforced frames, fully adjustable spring loaded hinges and matching latches. Allegheny is a quality product proudly manufactured by Bufftech.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Gates',
                        'products' => [
                            [
                                'title' => 'Vinyl Gates',
                                'description' => 'Our Vinyl Gates are versatile, easily customizable and can be made as walk, swing and double swing gates in varying sizes. We offer a collection of designs to choose from and can be accommodated to build the perfect gate(s) for your property.',
                                'pip' => 'VINYL-GATES_07202017.pdf',
                            ],
                            [
                                'title' => 'Aluminum Gates',
                                'description' => 'Our elegant Aluminum Fence has sleek designs and clean lines that will add the perfect finishing touch to any outdoor space. They can be made as walk, swing and double swing gates in varying sizes. We offer a collection of designs to choose from and can be accommodated to build the perfect gate(s) for your property.',
                            ],
                            [
                                'title' => 'Wood Gates',
                                'description' => 'Our Wood Gates are water-sealed and can be made as walk, swing and double swing gates in varying sizes. The pressure-treated and water-sealed wood is protected from fungal decay and termite attacks with the environmentally advanced non-arsenic and non-chromium ASO preservative system.',
                                'pip' => 'Wood-Gate-Swings-In_PIP_07282020.pdf',
                            ],
                            [
                                'title' => 'Allegheny Bufftech Molded Gates',
                                'description' => 'The Allegheny Bufftech Molded Fence has engineered gates that come with internal galvanized steel reinforced frames, fully adjustable spring loaded hinges and matching latches. Allegheny is a quality product proudly manufactured by Bufftech.',
                            ],
                            [
                                'title' => 'Estate Gates',
                                'description' => 'We custom fabricate a selection of estate, driveway, entry and ranch gates using the finest materials including vinyl (PVC), aluminum, and wood. Our designs can be made as single swing, double swing, slide or cantilever gates. We offer a collection of designs to choose from and we can help create a custom estate gate with your design ideas and input.',
                            ],
                            [
                                'title' => 'Security Aluminum Gates',
                                'description' => 'Security mesh can be added to your aluminum gate to restrict access. The security mesh is welded to the aluminum gate, and is complete with a powder coated finish.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Textured Vinyl Fence',
                        'products' => [
                            [
                                'title' => 'Bufftech Chesterfield Certagrain Texture',
                                'description' => 'Add a unique, decorative style in one the four rich blend colors with Bufftech Chesterfield CertaGrain Texture in concave or convex to make your fence stand out from the rest.',
                            ],
                            [
                                'title' => 'Bufftech Post & Rail Certagrain Texture',
                                'description' => 'Bufftech Post & Rail CertaGrain Texture offers the authentic look of painted wood fencing with the low maintenance and proven performance of vinyl.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Metal Privacy Fence',
                        'products' => [
                            [
                                'title' => 'Metal Privacy Fence',
                                'description' => '',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Chain Link Fence',
                        'products' => [
                            [
                                'title' => 'Chain Link Fence',
                                'description' => '',
                            ],
                        ],
                    ],

                ],

            ],
            [
                'title' => 'Kitchens & Grills',
                'description' => 'Longing to show off those superior grill skills? Of course you are! Nothing compares to a meal prepared and enjoyed outdoors, and no outdoor kitchen can compare to the kitchens created by Danielle Fence & Outdoor Living. Simply looking to accessorize your current outdoor kitchen? We can help with everything from providing grilling utensils to outdoor ovens. Looking to build your outdoor dream kitchen from the ground up? We can help there, too. Our expert design team will work with you to create a backyard culinary masterpiece – an exterior kitchen that will give you every excuse in the world to never cook indoors again. Spend some time looking over our portfolio of products or browse our blogs for design ideas; soon you’ll be out back, grilling to your heart’s content.',
                'subcategories' => [
                    [
                        'title' => 'Kitchen Styles',
                        'products' => [
                            [
                                'title' => 'Aluminum Frame Outdoor Kitchens',
                                'description' => 'Our Aluminum Frame Outdoor Kitchens are made custom and never pre-built. We measure and design each outdoor kitchen specific to your needs. Our Aluminum Frame Outdoor Kitchens are constructed with T6061 tube aluminum. The outside of the aluminum islands are covered with Hardibacker cement board and secured to the frame with stainless steel screws. The combination of T6061 tube aluminum and Hardibacker cement board gives you a strong, lightweight cabinet that will withstand outdoor elements and resist moisture for decades. Our aluminum frame islands also include leveling feet, floor pans and ventilation to allow air for moisture evaporation and heat release.',
                            ],
                            [
                                'title' => 'NatureKast Outdoor Kitchen',
                                'description' => 'Discover the rich look of real wood outdoor cabinets without the constant maintenance. NatureKast has revolutionized the outdoor kitchen industry by offering the first 100% weatherproof cabinet using a technologically advanced hi-density resin system that perfectly replicates the natural color and texture of real wood.',
                            ],
                            [
                                'title' => 'Premium Polymer Outdoor Kitchen Cabinets',
                                'description' => 'Premium Polymer Outdoor Kitchen Cabinets are the strongest, most proven outdoor cabinetry for outdoor kitchens. This unique weatherproof cabinetry is designed to last a lifetime. At Danielle Fence & Outdoor Living, we work with you on your custom outdoor kitchen project so that your design will be unique and fit your dream outdoor living space.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Doors and Drawers',
                        'products' => [
                            [
                                'title' => 'Vertical Door',
                                'description' => 'Add necessary and convenient storage to your outdoor kitchen with Summerset doors. Offering easy access to your barbecue island, storage solutions for cooking tools and utensils, and durable construction for the outdoors, the Summerset doors will make your outdoor kitchen efficient and functional. For a wonderfully sleek built-in look, all doors offer easy flush mounting and a handy magnetic latch to keep doors closed, secure, and orderly. Summerset doors offer all #304 stainless steel construction, reversible door mounting, curved handle, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Horizontal Door',
                                'description' => 'Add necessary and convenient storage to your outdoor kitchen with Summerset doors. Offering easy access to your barbecue island, storage solutions for cooking tools and utensils, and durable construction for the outdoors, the Summerset doors will make your outdoor kitchen efficient and functional. For a wonderfully sleek built-in look, all doors offer easy flush mounting and a handy magnetic latch to keep doors closed, secure, and orderly. Summerset doors offer all #304 stainless steel construction, reversible door mounting, curved handle, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Double Doors',
                                'description' => 'Available in 30in. and 42in. Add necessary and convenient storage to
        your outdoor kitchen with Summerset doors. Offering easy access to your barbecue island, storage solutions for cooking tools and utensils, and durable construction for the outdoors, our doors will make your outdoor kitchen efficient and functional. For a wonderfully sleek built-in look, all doors offer easy flush mounting and a handy magnetic latch to keep doors closed, secure, and orderly. Summerset doors offer all #304 stainless steel construction, reversible door mounting, curved handle, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Single Drawer & Trash Drawer',
                                'description' => 'Bring efficiency and function to your outdoor kitchen with Summerset drawers. With multiple configurations, use our drawers to maximize the space and design of your outdoor space. Built to last, all drawers are manufactured fully enclosed with durable construction for maximum protection from the outdoors. Summerset drawers offer all #304 stainless steel construction, stainless steel mounting brackets, smooth gliding on heavy duty racks, handle, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Door & Two Drawer Combo',
                                'description' => 'Bring efficiency and function to your outdoor kitchen with Summerset door & drawer combos. With multiple configurations, use our door & drawer combos to maximize the space and design of your outdoor space. Built to last, all drawers are manufactured fully enclosed with durable construction for maximum protection from the outdoors. Summerset door & drawer combos offer all #304 stainless steel construction, stainless steel mounting brackets, smooth gliding on heavy duty racks, matching handles, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Door & Three Drawer Combo',
                                'description' => 'Bring efficiency and function to your outdoor kitchen with Summerset door & drawer combos. With multiple configurations, use our door & drawer combos to maximize the space and design of your outdoor space. Built to last, all drawers are manufactured fully enclosed with durable construction for maximum protection from the outdoors. Summerset door & drawer combos offer all #304 stainless steel construction, stainless steel mounting brackets, smooth gliding on heavy duty racks, matching Summerset handles, and limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Two Drawer',
                                'description' => 'Bring efficiency and function to your outdoor kitchen with Summerset drawers. With multiple configurations, use our drawers to maximize the space and design of your outdoor space. Built to last, all drawers are manufactured fully enclosed with durable construction for maximum protection from the outdoors. Summerset drawers offer all #304 stainless steel construction, stainless steel mounting brackets, smooth gliding on heavy duty racks, handle, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'Three Drawer',
                                'description' => 'Bring efficiency and function to your outdoor kitchen with Summerset door & drawer combos. With multiple configurations, use our door & drawer combos to maximize the space and design of your outdoor space. Built to last, all drawers are manufactured fully enclosed with durable construction for maximum protection from the outdoors. Summerset door & drawer combos offer all #304 stainless steel construction, stainless steel mounting brackets, smooth gliding on heavy duty racks, matching handles, and a limited lifetime warranty.',
                            ],
                            [
                                'title' => 'FireMagic Select Single Access Door',
                                'description' => 'Also available with Tank Tray. The Select Single Access Door features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch. Available in 24 1/2in. x 17in. and 14 1/2in. x 20in.',
                            ],
                            [
                                'title' => 'FireMagic Select Double Access Door',
                                'description' => 'Also available with Dual Drawer & Trash Tray or two Dual Drawers. The Select Double Door Access features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Single Door with Dual Drawers',
                                'description' => 'The Single Door with Dual Drawers features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Select Masonry Drawer',
                                'description' => 'The Select Masonry Drawer features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Select Single Drawer',
                                'description' => 'The Select Single Drawers feature outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Select Double Drawer',
                                'description' => 'The Select Double Drawer features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Select Triple Drawer',
                                'description' => 'The Select Triple Drawer features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'FireMagic Select Electric Warming Drawer',
                                'description' => 'The Select Electric Warming Drawer features outside mounting, double wall and square edge contraction, a slim tubular stainless steel handle, and a heavy-duty magnetic latch.',
                            ],
                            [
                                'title' => 'Memphis Lower Drawers',
                                'description' => 'Available in Pro and Elite Models. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; large storage drawer; and same width as a Memphis Pro built-in.',
                            ],
                            [
                                'title' => 'Memphis Lower Doors',
                                'description' => 'Available in Pro and Elite Models. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, this line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers.',
                            ],
                            [
                                'title' => 'Two Drawer Stack',
                                'description' => 'Available in 15in. and 21in. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; and two storage drawers.',
                            ],
                            [
                                'title' => 'Three Drawer Stack',
                                'description' => 'Available in 15in. and 21in. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; and three storage drawers.',
                            ],
                            [
                                'title' => 'Controller Drawer - Trash 15in.',
                                'description' => 'Available in Single Drawer, Two Stack, and Three Stack. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; built-in Memphis Grill controller; and two storage drawers.',
                            ],
                            [
                                'title' => 'Single Drawer and Trash Drawer 15in.',
                                'description' => 'Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; built-in Memphis Grill controller; one storage drawer; and one 10-gallon trash drawer.',
                            ],
                            [
                                'title' => 'Four Drawer Stack',
                                'description' => 'Available in 15in. and 21in. Memphis Grills doors and drawers are built with 304 stainless steel and durable, high-quality slides. Made in the United States, the heavy-duty drawer slides provide a smooth opening and easy touch self-closing operation. This line of Memphis accessories provides beauty, durability, and convenience in your outdoor meal preparation and entertainment space. Drawers hold up to 100 lbs. and included is a built-in Memphis Grill controller and trash drawer. Your outdoor kitchen will be an entertainment venue as well as a functional workspace with Memphis Grills doors and drawers. Quick facts: Drawers hold up to 100 lbs.; 304 stainless steel; durable stainless steel slides; easy touch self-closing; and four storage drawers.',
                            ],
                            [
                                'title' => 'Trash Drawer',
                                'description' => 'Your kitchen, the way you want it. Summerset offers plenty of miscellaneous conveniences, upgrades, and appliances to customize your outdoor space to your liking. From stainless steel ice chests to stainless steel paper towel drawers, Summerset has matching pieces to take your outdoor kitchen to the next level, while maintaining the same elegant quality and design. All products feature #304 stainless steel construction for durability and performance, matching handles and hardware, and various options.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Grills and Burners',
                        'products' => [
                            [
                                'title' => 'The All New Gas Griddle',
                                'description' => 'Explore new flavors with the all-new, premium 30in. Gas Griddle by Summerset. Constructed of #304 stainless steel, this heavy-duty flat top grill is the perfect addition to your outdoor kitchen, diversifying your menu, and adding a host of new flavors. The expansive, 495-square-inch cooking surface is made of half-inch thick steel, powered by two 18,000 BTU U-Tube burners below. The combined 36,000 BTUs of power guaranty searing heat, perfect for steaks, burgers, carne asada, eggs, pancakes, and more. Blue LEDs illuminate the front panel, while the full-size #304 stainless steel cover ensures your griddle plate is protected from the elements and always ready for the next meal. Fire up the Gas Griddle by Summerset and take your culinary experiences to new heights.
                                                    <br/>Features:<ul>
                                                    <li>#304 Stainless Steel Construction</li>
                                                    <li>1/2in. thick Stainless Steel Cooking Surface</li>
                                                    <li>495 Sq. Inches of Cooking Surface</li>
                                                    <li>18,000 BTU Stainless Steel U-Tube Burners</li>
                                                    <li>36,000 Total BTU Output</li>
                                                    <li>Included #304 Stainless Steel, Removable Lid</li>
                                                    <li>Large Capacity Drip Tray</li>
                                                    <li>Blue Exterior LED Lighting</li>
                                                    <li>High-Power, Reliable Flame-Thrower Ignition</li>
                                                    <li>Built-In/Freestanding Available</li>
                                                    <li>Overall Dimensions: 30in. W x 28in. D x 12in. H</li>
                                                    <li>Weight: 120 LB.</li>
                                                    <li>CSA Certified</li>
                                                    <li>AMD Direct GOLD Standard Warranty</li>
                                                    </ul>
                                                    OPTIONAL ITEMS:<ul>
                                                    <li>Weather Cover</li>
                                                    </ul>
',
                            ],
                            [
                                'title' => '36in. American Muscle Grill',
                                'description' => '<ul><li>Available in 36in. (1,105 sq. in. cooking surface)</li>
                                                    <li>304 Stainless Steel</li>
                                                    <li>22,000 BTU Burners</li>
                                                    <li>Exterior LED Lighting</li>
                                                    <li>Interior Cooking Lights</li>
                                                    <li>Easy Clean Drip Tray</li>
                                                    <li>Built-in Rotisserie Spit Storage</li>
                                                    <li>Dimensions: 33 1/8in. x 33 1/4in. x 36in.</li></ul>',
                            ],
                            [
                                'title' => 'Echelon Diamond E790i Built-in Grill',
                                'description' => '<ul>
                                                        <li>36in. X 22in. Cooking surface (792 sq. in.) & 288 sq. in. Warming Rack</li>
                                                        <li>96,000 main burner BTUs; 13,000 back burner BTUs</li>
                                                        <li>All 304 stainless steel</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Echelon Drip Tray</li>
                                                        <li>Back-lit safety knobs</li>
                                                        <li>Heat zone separators; four zone illuminated chromed digital thermometer with meat probe</li>
                                                        <li>Halogen lamps for evening grilling</li>
                                                        <li>Optional magic view window</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'FireMagic Echelon Diamond E660i Built-in Grill',
                                'description' => '<ul>
                                                        <li>30in. X 22in. Cooking Surface (660 sq. in.) & 288 sq. in. Warming Rack</li>
                                                        <li>75,000 main burner BTUs; 11,000 back burner BTUs</li>
                                                        <li>All 304 stainless steel</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Echelon Drip Tray</li>
                                                        <li>Back-lit safety knobs</li>
                                                        <li>Heat zone separators; four zone illuminated chromed digital thermometer with meat probe</li>
                                                        <li>Halogen lamps for evening grilling</li>
                                                        <li>Optional magic view window</li>
                                                        </ul>',
                            ],
                            [
                                'title' => 'Summerset TRL Built-in Grill',
                                'description' => '<ul>
                                                        <li>Available in 32in. (855 sq. in.) and 38in. (1,076 sq. in.)</li>
                                                        <li>18,000 BTUs on each main burner; 15,000 back burner BTUs</li>
                                                        <li>304 Stainless Steel</li>
                                                        <li>8mm Cooking Grates</li>
                                                        <li>Interior and exterior LED lighting</li>
                                                        <li>Heavy-duty Rotisserie Kit</li>
                                                        <li>Plug-and-play infrared sear zone</li>
                                                        <li>Easy-clean briquette system</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Summerset Sizzler Built-in Grill',
                                'description' => '<ul>
                                                        <li>Available in 26in. (560 sq. in.) and 32in. (795 sq. in.)</li>
                                                        <li>26in.: 12,000 BTUs on each burner</li>
                                                        <li>32in.: 14,000 BTUs on each burner; 15,000 BTU infrared back burner</li>
                                                        <li>All 443 Stainless Steel</li>
                                                        <li>8mm Cooking Grates</li>
                                                        <li>Easy-clean Briquette System</li>
                                                        <li>3-inch built-in temperature gauge</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'FireMagic Echelon Diamond Double Side Burner',
                                'description' => '<ul>
                                                        <li>Precise flame control on each burner to prepare sauces and side dishes</li>
                                                        <li>Two 15,000 BTU Burners</li>
                                                        <li>Available with porcelain cast or stainless steel</li>
                                                        <li>Cutout: 11 1/2in. “w x 22 3/4in. d x 11 1/2″ h</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'FireMagic Echelon Diamond Power Burner',
                                'description' => '<ul>
                                                        <li>The largest, most powerful side cooker available</li>
                                                        <li>Available in natural gas or propane</li>
                                                        <li>Up to 60,000 BTUs of cooking power</li>
                                                        <li>Back-lit control knobs</li>
                                                        <li>304 Stainless Steel</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Summerset TRL Double Side Burner',
                                'description' => '<ul>
                                                        <li>Combine the comfort of an indoor kitchen range with all the benefits of cooking outside.</li>
                                                        <li>Specially designed for performance and function, the Double Side Burner TRL is the perfect addition to your outdoor kitchen.</li>
                                                        <li>30,000 BTUs of cooking power</li>
                                                        <li>All 304 stainless steel including: cooking grates and burner lid</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Summerset Sizzler Side Burners',
                                'description' => '<ul>
                                                        <li>Combine the comfort of an indoor kitchen range with all the benefits of cooking outside. Side burners that offer the convenience of range top cooking and grilling simultaneously</li>
                                                        <li>Available in Single and Double Burners</li>
                                                        <li>Single Side Burner: 15,000 BTUs</li>
                                                        <li>Double Side Burner: 24,000 BTUs</li>
                                                        <li>All 304 stainless steel including: cooking grates and burner lid</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'AOG NBL Built-in Grill',
                                'description' => '<ul>
                                                        <li>24in.: 432 sq. in. cooking surface, 32,000 primary burner BTUs, 10,000 back burner BTUs</li>
                                                        <li>30in.: 540 sq. in. cooking surface, 45,000 primary BTUs, 12,000 back burner BTUs</li>
                                                        <li>304 Stainless steel construction</li>
                                                        <li>Warming rack &amp; rotisserie kit</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Solid brass valves for precise temperature control</li>
                                                        <li>Electronic push button ignition system</li>
                                                        <li>Interior halogen lights for evening grilling</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'FireMagic Aurora Built-in Grill',
                                'description' => '<ul>
                                                        <li>Superior design and engineering power the Aurora’s unparalleled performance.</li>
                                                        <li>Available Models: A430i, A540i, A660i, A790i</li>
                                                        <li>A430i: 432 sq. in. cooking area; 192 sq. in. warming rack; 50,000 main burner BTUs; 13,000 back burner BTUs</li>
                                                        <li>A540i: 540 sq. in. cooking area; 240 sq. in. warming rack; 63,000 main burner BTUs; 18,000 back burner BTUs</li>
                                                        <li>A660i: 660 sq. in. cooking area; 240 sq. in. warming rack; 75,000 main burner BTUs; 18,000 back burner BTUs; optional magic view window</li>
                                                        <li>A790i: 792 sq. in. cooking area; 288 sq. in. warming rack; 90,000 main burner BTUs; 20,000 back burner BTUs; optional magic view window</li>
                                                        <li>304 Stainless Steel</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Interior halogen lights for evening grilling</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Elite Built-in 304 SS Alloy',
                                'description' => '<ul>
                                                        <li>Big and bold, this wood pellet grill is the ultimate addition to any outdoor kitchen.</li>
                                                        <li>862 sq. in. cooking surface (1274 sq. in. with optional grill grates)</li>
                                                        <li>24lb. pellet hopper</li>
                                                        <li>Dual metal 4in. convection fans</li>
                                                        <li>Intelligent Temperature control with Wi-Fi ranging from 180 to 700 degrees,</li>
                                                        <li>Oven-grade gasket</li>
                                                        <li>304 stainless steel, double walled, sealed</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Pro Built-in Grill',
                                'description' => '<ul>
                                                        <li>Combines the very best parts of a kitchen oven, a real wood fire, a BBQ gas grill, and a smoker.</li>
                                                        <li>574 sq. in. cooking surface (848 sq. in. with optional grill grates)</li>
                                                        <li>18lb. Pellet hopper</li>
                                                        <li>Intelligent Temperature Control with Wi-Fi ranging from 180 to 650 degrees</li>
                                                        <li>Dual Metal 4in. Convection fans</li>
                                                        <li>Oven grade gasket</li>
                                                        <li>304 stainless steel, double walled, sealed</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'FireMagic Echelon Diamond Stand Alone Grill',
                                'description' => '<ul>
                                                        <li>The Fire Magic Echelon Diamond grill combines the ultimate in performance, beauty and innovation.</li>
                                                        <li>Available Models: E660s &amp; E1060s</li>
                                                        <li>E660s: 660 sq. in. cooking surface; 240 sq. in. warming rack; 78,000 main burner BTUs; 11,000 back burner BTUs; 2 internal halogen lights</li>
                                                        <li>E1060s: 1056 sq. in. cooking surface; 384 sq. in. warming rack; 112,000 main burner BTUs; 22,000 back burner BTUs; 60,000 power burner BTUs; 3 internal halogen lights</li>
                                                        <li>304 stainless steel</li>
                                                        <li>Recessed Infrared Quantum Back Burner</li>
                                                        <li>Blue back-lit knobs</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Optional Magic View Window</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Aurora Stand Alone Grill Cart',
                                'description' => '<ul>
                                                        <li>Aurora Series grill delivers cooking versatility, durability and longevity in a beautifully crafted machine.</li>
                                                        <li>Available Models: A430s, A540s, A660s</li>
                                                        <li>A430s: 432 sq. in. cooking surface; 192 sq. in. warming rack; 50,000 main burner BTUs; 15,000 side burner BTUs; 13,000 optional back burner BTUs</li>
                                                        <li>A540s: 540 sq. in. cooking surface; 240 sq. in. warming rack; 63,000 main burner BTUs; 15,000 side burner BTUs; 18,000 backburner BTUs</li>
                                                        <li>A660s: 660 sq. in. cooking surface; 240 sq. in. warming rack; 75,000 main burner BTUs; 18,000 back burner BTUs</li>
                                                        <li>304 stainless steel</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Interior halogen lights for evening grilling</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Summerset Sizzler Grill Cart',
                                'description' => '<ul>
                                                        <li>This grill gives its higher-priced competitors a run for their money in both durability and grilling performance.</li>
                                                        <li>Available Sizes: 26in. and 32in.</li>
                                                        <li>26in.: 560 sq. in. cooking surface; 12,000 main burner BTUs each</li>
                                                        <li>32in.: 740 sq. in. cooking surface; 12,000 main burner BTUs each; 15,000 back burner BTUs</li>
                                                        <li>443 Stainless steel</li>
                                                        <li>3in. built-in temperature gauge</li>
                                                        <li>8mm cooking grates</li>
                                                        <li>Easy-Clean Briquette System</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Beale Street Grill Cart',
                                'description' => '<ul>
                                                        <li>The Beale Street brings the precision and confidence to the art of wood fire grilling.</li>
                                                        <li>558 sq. in. cooking surface (817 sq. in. with optional grill grate)</li>
                                                        <li>Intelligent Temperature Control ranging from 180 to 550 degrees</li>
                                                        <li>12lb pellet hopper capacity</li>
                                                        <li>Cloud based Wi-Fi</li>
                                                        <li>4in. convection fans</li>
                                                        <li>430 Stainless Steel Construction</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Evo Professional Wheeled Cart Grill',
                                'description' => '<ul>
                                                        <li>The perfect solution for cooking virtually any food from the most delicate to the most demanding</li>
                                                        <li>48,000 BTUs</li>
                                                        <li>30in. circular black steel cooking surface</li>
                                                        <li>2 temperature zones</li>
                                                        <li>Temperature range from 225 to 550 degrees</li>
                                                        <li>Stainless Steel construction</li>
                                                        <li>Push button ignition</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Affinity 30G Classic Cooktop',
                                'description' => '<ul>
                                                        <li>An ideal solution for creating a social cooking space with any outdoor kitchen.</li>
                                                        <li>30in. circular steel cooking surface</li>
                                                        <li>2 temperature zones</li>
                                                        <li>Variable temperature ranges from 225 to 550</li>
                                                        <li>Up to 38,000 BTUs</li>
                                                        <li>Stainless steel construction</li>
                                                        <li>Electronic Push button ignition</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Evo Professional Tabletop',
                                'description' => '<ul>
                                                        <li>The perfect solution for demanding to delicate food preparation.</li>
                                                        <li>30in. circular steel cooking surface</li>
                                                        <li>Two temperature zones</li>
                                                        <li>Temperatures ranging from 225 to 550 degrees</li>
                                                        <li>48,000 BTUs</li>
                                                        <li>Push button ignition</li>
                                                        <li>Stainless steel construction</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Advantage Plus Grill Cart with WiFi',
                                'description' => '<ul>
                                                        <li>Circulating metal convection fan</li>
                                                        <li>a 180&deg; to 600&deg; temperature range</li>
                                                        <li>12 lb. pellet hopper.</li>
                                                        <li>Utilizes 100% natural and renewable wood pellets</li>
                                                        <li>Intelligent temperature control with WiFi</li>
                                                        <li>Double wall, 430 stainless steel construction</li>
                                                        <li>Indirect and direct flame modes.</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Pro Cart - 430 SS Alloy',
                                'description' => '<ul>
                                                        <li>Combines the very best parts of a kitchen oven, a real wood fire, a BBQ gas grill, and a smoker.</li>
                                                        <li>574 sq. in. cooking surface (848 sq. in. with optional grates)</li>
                                                        <li>Intelligent temperature control ranging from 180 to 650 degrees</li>
                                                        <li>18 lb. pellet hopper</li>
                                                        <li>Dual 4in. metal convection fans</li>
                                                        <li>Intelligent Temperature Control ranging from 180 to 650</li>
                                                        <li>Oven-grade gasket</li>
                                                        <li>304 stainless steel, double walled, sealed</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'Memphis Elite Cart - 304 SS Alloy',
                                'description' => '<ul>
                                                        <li>Big and bold, this wood pellet is the ultimate addition to any outdoor kitchen.</li>
                                                        <li>862 sq. in. cooking surface (1274 sq. in. with optional grates)</li>
                                                        <li>24 lb pellet hopper</li>
                                                        <li>Dual 4in. metal convection fans</li>
                                                        <li>Intelligent Temperature control ranging from 180 to 700</li>
                                                        <li>Oven-grade gasket</li>
                                                        <li>304 stainless steel, double walled, sealed</li>
                                                    </ul>',
                            ],
                            [
                                'title' => 'AOG PCL Grill Cart',
                                'description' => '<ul>
                                                        <li>Available Models: 24PCL and 36PCL</li>
                                                        <li>24PCL: 432 sq. in. cooking surface; 32,000 primary BTUs; 10,000 back burner BTUs; 12,000 side burner BTUs</li>
                                                        <li>36PCL: 648 sq. in. cooking surface; 50,000 primary BTUs, 12,000 back burner BTUs; 12,000 side burner BTUs</li>
                                                        <li>Stainless steel construction</li>
                                                        <li>Diamond Sear Cooking Grids</li>
                                                        <li>Warming rack and rotisserie kit</li>
                                                        <li>Interior halogen lights and electronic push button ignition</li>
                                                    </ul>',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Grill Accessories',
                        'products' => [
                            [
                                'title' => 'EVO Roasting Racks',
                                'description' => 'Evo circular stainless steel racks offer enhanced cooking on the Evo cook surface. Use to roast, bake, and smoke foods by allowing heat to circulate freely around the item. Racks can also be utilized to decelerate cooking and used as a holding station.',
                            ],
                            [
                                'title' => 'EVO Seasoned Cook Surface Cleaning Kit',
                                'description' => 'Basic maintenance kit for Evo cook surface includes 3M-brand pusher (plastic handle with ribbed metal base), two cleaning pads (#46), and two cleaning screens (can be aggressive, so consult the cook surface cleaning guide in the Evo cook book before using with ceramic surfaces). Comes with a two-inch waste container ninth pan.',
                            ],
                            [
                                'title' => 'EVO Stainless Steel Covers',
                                'description' => 'Evo Stainless Steel Covers offer enhanced cooking on the Evo cook surface through additional techniques and compartmentalized cooking. Use to steam, roast, bake, and smoke foods on a portion of the cook surface while preparing other foods around it.',
                            ],
                            [
                                'title' => 'Beverage Center with Sink',
                                'description' => 'As our grills heat things up, we also have just the thing to keep you cool. Take your outdoor kitchen to the next level with the Summerset Beverage Center. Complete with a 40 lb. ice compartment, sink, towel holder, and speed rail with condiment tray and built-in bottle opener. The Summerset Beverage Center will make you the best host in the neighborhood!',
                            ],
                            [
                                'title' => 'Large Ice Chest',
                                'description' => 'Your kitchen, the way you want it…Summerset offers plenty of miscellaneous conveniences, upgrades, and appliances to customize your outdoor space to your liking. From stainless steel ice chests to stainless steel paper towel drawers, Summerset has matching pieces to take your outdoor kitchen to the next level, while maintaining the same elegant quality and design. All products feature 304 stainless steel construction for durability and performance, matching handles and hardware, and various options.',
                            ],
                            [
                                'title' => 'Stainless Steel Drop-in Sink with Faucet',
                                'description' => 'Keep your outdoor kitchen clean with the useful Summerset Stainless Steel Sink and Faucet. With built-in design and easy drop-in installation, this sink is a simple upgrade to any outdoor cooking area. Featuring a large 15in.x 15in.x 6in. basin, conveniently keep cooking utensils and dishes clean without having to go inside. The stainless steel construction outlasts inferior brand designs, and it includes a double handle valve and a stopper/strainer for added versatility.',
                            ],
                            [
                                'title' => 'Summerset Refrigerator',
                                'description' => "Do you get tired of making multiple trips indoors while grilling and enjoying your outdoor space? Bring the comfort of cold storage to your outdoor kitchen with the Summerset Refrigerator (4.5 ft. 3'' capacity & locking door) with 304 stainless steel door construction, reversible door capability, and rear venting. Featuring the same pristine form and function of 304 stainless steel door construction, maintain a matching design with your existing Summerset components. Use the space and adjustable wire shelves to protect raw ingredients, keep condiments chilled, or store refreshments. The locking stainless steel door keeps your cold storage safe and energy efficient, and it is reversible to best adjust to your workflow and use. Offering durable construction for the outdoors, sealed back for energy efficiency, temperature control, adjustable legs for leveling, rear venting, and limited lifetime warranty, the Summerset Refrigerator brings sleek design for function and beauty.",
                            ],
                            [
                                'title' => 'Refrigerator Door Sleeve Upgrade',
                                'description' => 'The Refrigerator Stainless Steel Door Sleeve Upgrade fits the Summerset under-counter refrigerator. Refrigerator is not included.',
                            ],
                            [
                                'title' => 'Island Vent',
                                'description' => 'Prevent gas from building up in your outdoor kitchen island by properly ventilating it with the stainless steel Island Vent. The stainless steel Island Vent also helps with moisture that may get inside your island. Cut-out dimensions: 12 1/2in.W x 3 1/4in.H; overall dimensions: 14in.W x 4 1/2in.H.',
                            ],
                            [
                                'title' => 'Trash Chute',
                                'description' => 'Keep your outdoor kitchen counter top clean and mess free with the Trash Chute. The Summerset Trash Chute is made of 304 stainless steel construction. Includes cutting board, chute and removable top. Cut-out dimensions: 6-1/4in. x 8-1/4in.',
                            ],
                            [
                                'title' => 'Buffet Warming Accessory',
                                'description' => 'The Buffet Warming Accessory includes four stainless steel containers with lids to keep food warm; two rectangular containers measuring: 9-1/2in. W x 5-1/2in. D x 6in. H; one large rectangular container measuring: 11-3/4in. W x 9-1/2in. D x 4in. H; and one medium container measuring: 6in. W x 5-1/2in. D x 6in. H. Meant for use with the Fire Magic Warming Drawers.',
                            ],
                            [
                                'title' => 'Automatic Three-hour Timer Shut Off Valve',
                                'description' => '',
                            ],
                            [
                                'title' => 'Automatic One-hour Timer Shut Off Valve',
                                'description' => 'Fire Magic’s 3-hour timer offers additional safety and automatically shuts off gas flow at preset times. Easy to install, and great for apartment and condominium use.',
                            ],
                            [
                                'title' => 'Fire Magic Side Burner Cover',
                                'description' => 'Keep your investment protected from the elements with Fire Magic grill covers.
',
                            ],
                            [
                                'title' => '15in. Wok & Stainless Steel Cover',
                                'description' => 'The 15in. Wok has a hard stainless steel anodized cover and has a stick-resistant lined interior surface.',
                            ],
                            [
                                'title' => 'Turkey Pot Frying Kit',
                                'description' => 'You’ll be amazed at how tender a deep-fried turkey can be. Kit includes pot, inner basket with sturdy handle and thermometer probe. The Turkey Pot is also a great option as a crab or corn pot.',
                            ],
                            [
                                'title' => 'Five-piece Grilling Tool Set',
                                'description' => 'The Five-piece Grilling Tool Set includes stainless steel tongs, meat fork, silicone-tipped basting brush, slotted flat spatula with serrated edges and a built-in bottle opener and a two-sided grill brush.
',
                            ],
                            [
                                'title' => 'Roasting Turkey Holder',
                                'description' => 'This sturdy holder is also perfect for beef, pork and lamb roasts.',
                            ],
                            [
                                'title' => 'Roasting Chicken Holder',
                                'description' => 'Enjoy a golden, succulent chicken the quick and easy way.',
                            ],
                            [
                                'title' => 'Fire Magic Power Burner Cover',
                                'description' => 'Keep your investment protected from the elements with Fire Magic grill covers.',
                            ],
                            [
                                'title' => 'Fire Magic Built-in Grill Cover',
                                'description' => 'The Fire Magic Built-in Grill Cover is manufactured with a PVC exterior and polyester breathable interior. These covers protect the investment of any Fire Magic Grill. Custom fit for Fire Magic Grills and accessories, the black PVC material has also been tested and proven for color-fastness.',
                            ],
                            [
                                'title' => 'Griddle',
                                'description' => 'Griddle is available for the Fire Magic double side burner as well as Echelon and Aurora grills. Cook eggs, bacon, and fluffy pancakes. Enjoy breakfast in the great outdoors! Also great for fajitas!',
                            ],
                            [
                                'title' => "Fire Magic's Power Vent Hood",
                                'description' => 'Fire Magic’s Power Vent Hood is designed specifically for the outdoor grilling environment to exhaust excess smoke and heat from covered patios. The 1,200 CFM dual fan design may be configured to vent either vertically or horizontally to suit the application. Powerful under-mount halogen lamps illuminate the space for evening grilling.',
                            ],
                            [
                                'title' => 'Summerset Stainless Steel Outdoor Refrigerator - 5.5 CFT',
                                'description' => 'Enjoy chilled refreshments and keep ingredients cool with a Summerset Stainless Steel Outdoor Refrigerator. With up to 5.5 cubic feet of storage and wire shelving, this appliance will facilitate food preparation and storage needs for your outdoor kitchen. All Summerset Refrigerators offer durable construction for the outdoors, a sealed back for energy efficiency, temperature control, crisping drawers, adjustable legs for leveling, and sleek design for function and beauty.',
                            ],
                            [
                                'title' => 'Summerset Sizzler Rotisserie Kit',
                                'description' => 'This Summerset Sizzler Rotisserie Kit is designed for use with Summerset Sizzler grills. Includes: stainless steel rod, forks, handle, bracket and motor.',
                            ],
                            [
                                'title' => 'Summerset Stainless Steel Outdoor Refrigerator - 4.5 CFT',
                                'description' => 'Bring the comfort of cold storage to your outdoor kitchen with the Summerset Outdoor Refrigerator. Do you get tired of making multiple trips indoors while grilling and enjoying your outdoor space? Bring the comfort of ice-cold beverages and cold storage to your outdoor kitchen. Featuring the same pristine form and function of 304 stainless steel door construction, maintain a matching design with your existing Summerset components. Use the 4.5 cubic feet of space and adjustable wire shelves to protect raw ingredients, keep condiments chilled, or store refreshments. The locking stainless steel door keeps your cold storage safe and energy efficient, and it is reversible to best adjust to your workflow and use. Offering durable construction for the outdoors, sealed back for energy efficiency, temperature control, adjustable legs for leveling, rear venting, and limited lifetime warranty, the Summerset Outdoor Refrigerator brings sleek design for function and beauty.',
                            ],
                            [
                                'title' => 'Built-in Bar Caddy',
                                'description' => 'The Built-in Bar Caddy comes equipped with a towel bar, bottle opener, sliding storage drawer, two stainless steel bottle sleeves and an installation hanger. Available with the optional steam warming accessory. Cut out dimensions: 14-1/4in. W x 22-3/4in.D x 12in.H.',
                            ],
                            [
                                'title' => 'Aurora Style Built-in Beverage Center',
                                'description' => 'The Aurora Style Built-in Beverage Center features a top storage shelf rail, faucet with sink and chain, removable bamboo cutting board, storage drawer, wine glass holder, halogen lights, covered heavy-duty blender, insulated ice drawer, and two condiment holders. Cut out dimensions: 36-3/4in.W x 23-1/2in.D x 12in. H.
    ',
                            ],
                            [
                                'title' => 'Fire Magic Outdoor Refrigerator',
                                'description' => 'The Fire Magic Outdoor Refrigerator offers 4.2 cubic feet of storage space. Custom-designed door is fabricated with a heavy-duty handle and radial corners for an exclusive look. Handy lock keeps contents safe. When used outdoors, it must be installed in an enclosure. Cut out dimensions: 20in. W x 21-3/4in. D x 34-1/8in. H.',
                            ],
                            [
                                'title' => 'Fire Magic Outdoor Kegerator',
                                'description' => "Fire Magic Outdoor Kegerator is crafted to give you a high quality tap in the convenience of your own back yard. Built with corrosion resistance, stainless steel and rated for outdoor use, the kegerator will complete your outdoor entertainment center. Cut out dimensions: 24in. W x 27in. D x 35in. H. Includes: double tap; digital internal thermometer; lock & key; shelves for additional storage; right or left hinge; Fire Magic style handle; uses two 'D' style low-profile keg couplers.",
                            ],
                            [
                                'title' => 'Large Capacity Automatic Ice Maker',
                                'description' => 'The Large Capacity Automatic Ice Maker produces 63 pounds of ice in a 24-hour period. Features: capable of storing up to 27 pounds of individual clear ice cubes; UL listed for outdoor use; continuously produces ice on demand as ice is used; suitable for outdoor or indoor applications; reversible door features horizontal handle that doubles as a towel bar.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Fire Features',
                'description' => <<<'HTML'
According to an old saying, fire is man’s oldest flame. Why? Probably because there are few experiences in life more relaxing than sitting by a fire. It must be something in our genes. So, wouldn’t it make sense to give yourself that opportunity?  Right at home and anytime you wanted?  At Danielle Fence & Outdoor Living, we offer a large selection of fire features that allow you to do just that. Choose from outdoor fireplaces and fire pits from top brands such as Breeo, Firetainment, The Outdoor Plus Company, and American Fire Design. Look over our portfolio of products or browse our blog for design ideas. Now, can’t you already feel the stresses of the day melting away?
HTML,

                'subcategories' => [
                    [
                        'title' => 'Outdoor Fireplaces',
                        'products' => [
                            [
                                'title' => 'Etruscan Fire Urn',
                                'description' => <<<'HTML'
This gas-burning Etruscan Fire Urn is reminiscent of the Roman urns of old but features bursts of fire out the top. This piece has a finger-like pattern and raised circular detailing around the top. Several of these can be displayed down a path or placed near a fireplace or other outdoor feature to add sophisticated elegance to your outdoor area. Made from glass fiber reinforced concrete, these urns come in a variety of different colors and textures. Fuel options include natural gas or self-contained propane tank (urn is made with a removable door to house and easily access a propane tank inside).

HTML],
                            [
                                'title' => 'Cordova Fireplace-Vented',
                                'description' => <<<'HTML'
Create an enticing outdoor setting with one of our most popular gas-burning outdoor fireplaces. This Cordova fireplace features clean, straight lines and is handcrafted from glass fiber reinforced concrete. A variety of different colors and textures are available. Fuel options include natural gas or propane.
HTML
                            ],
                            [
                                'title' => 'Chica Fireplace-Vented',
                                'description' => <<<'HTML'
The Chica is our smallest gas-burning fireplace model and was designed specifically for those with limited space or small outdoor areas. The Chica features a beautiful, subtle arch above the firebox opening and an elegant chimney. Handcrafted from glass fiber reinforced concrete, this fireplace comes in a variety of different colors and textures. Fuel options include natural gas or propane.
HTML
                            ],
                            [
                                'title' => 'Amphora Fire Urn',
                                'description' => <<<'HTML'
One of our most popular gas-burning pieces, the Amphora Fire Urn is reminiscent of the Grecian urns of old but features bursts of fire out the top. Several of these can be displayed down a path or placed near a fireplace or other outdoor feature to add sophisticated elegance to your outdoor area. Made from glass fiber reinforced concrete, these urns come in a variety of different colors and textures. Fuel options include natural gas or self-contained propane tank (urn is made with a removable door to house and easily access a propane tank inside).
HTML
                            ],
                            [
                                'title' => 'Mariposa Fireplace-Vented',
                                'description' => <<<'HTML'
The Mariposa is our best seller with a beautiful arch above the firebox and a low profile chimney with stunning curves. Handcrafted from glass fiber reinforced concrete, this gas-burning fireplace comes in a variety of different colors and textures. Fuel options include natural gas or propane.
HTML
                            ],
                            [
                                'title' => 'Large Firefall with Finished Back',
                                'description' => <<<'HTML'
The Firefall offers a twist on the typical, featuring cascading water down the backdrop, dancing flames in the front, and LED lighting set into the inner arch to spotlight the water even from afar. Available in both a large and a small size; the large features an arched upper mantle and recessed side panels while the small has a flat top. This gas-burning piece is handcrafted from glass fiber reinforced concrete and comes in a variety of different colors and textures. Fuel options include natural gas or propane.
HTML
                            ],
                            [
                                'title' => 'Brighton Collection',
                                'description' => <<<'HTML'
The Brighton wood-burning Fireplace Series addresses the need and request for a lower-priced fireplace set. Featuring the same 36" firebox as the other series and a built-in hearth. It is a beautiful option for those on a budget.
HTML
                            ],
                            [
                                'title' => 'Contempo Rectangle Fireplace',
                                'description' => <<<'HTML'
The smaller, rectangular firetable was designed for those with a balcony or small patio in mind. The compact design allows for a wide versatility of locations and uses. The new and enhanced burner pan prevents heat cracking, eliminates discoloration, and allows for ease of assembly and maintenance. Giving you many more years of enjoyment. Our gas-burning firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete.
HTML
                            ],
                            [
                                'title' => 'Phoenix Fireplace-Vented',
                                'description' => <<<'HTML'
The Phoenix features a gently arched firebox opening and prominent, slanting chimney to create regal elegance in any outdoor setting. This gas-burning piece is handcrafted from glass fiber reinforced concrete and comes in a variety of different colors and textures. Fuel options include natural gas or propane.
HTML
                            ],
                            [
                                'title' => 'Paige Fire Urn and Pedestal',
                                'description' => <<<'HTML'
The grandiosity of the Piage Fire Urn & Pedestal has the ability to transform even the ordinary outdoor area into an elegant display of fire and design. Either by itself or in a series, the gas-burning Piage Fire Urn & Pedestal not only adds style but warmth to the outdoors. Made from glass fiber reinforced concrete, the urn and pedestal come in a variety of different colors and textures. Fuel options include natural gas or self-contained propane tank (pedestal is made with a removable door to house and easily access a propane tank inside).
HTML
                            ],
                            [
                                'title' => 'Bristol Collection',
                                'description' => <<<'HTML'
The wood-burning Bristol Series is a beautiful combination of tumbled block, and features Arbel&reg; and Urbana&reg;
accents. The Bristol's rustic look blends well with virtually any landscape.
HTML
                            ],
                            [
                                'title' => 'Small Firewall with Finished Back',
                                'description' => <<<'HTML'
The FireFall offers a twist on the typical, featuring cascading water down the backdrop, dancing flames in the front, and LED lighting set into the inner arch to spotlight the water even from afar. Available in both a large and small size, the large features an arched upper mantle and recessed side panels while the small has a flat top. This gas-burning piece is handcrafted from glass fiber reinforced concrete and comes in a variety of different colors and textures. Fuel options include natural gas or propane.
HTML
                            ],
                        ],
                    ],
                    [
                        'title' => 'Fire Pits & Fire Tables',
                        'products' => [
                            [
                                'title' => 'Fire Pit and Fire Place Screens',
                                'description' => <<<'HTML'
We offer Fire Pit / Place Screens that are custom made to fit your individual Fire Pit or Fire Place. Made with Decorative iron.
HTML
                            ],
                            [
                                'title' => 'Madrid 48in. Square Pit Fire Table',
                                'description' => <<<'HTML'
Modern edges and traditional features make the Madrid a fire pit table that blends design styles to match any outdoor space. The 48" Madrid fire table seats 4 - 8 people comfortably depending on the seating style. There is ample space from the edge of the table top to the burner pan allowing for space to dine. The distance from the edge of the table to the center of the cooking elements make it easy for everyone around the table to easily cook their own food. The 24" height allows one to get their knees underneath with room to spare. The height also allows you to see over the flame or cooking elements so eye contact with those around is not obstructed, creating the perfect dining and entertainment experience!
HTML
                            ],
                            [
                                'title' => 'Naples 54in. Round Fire Pit Table',
                                'description' => <<<'HTML'
Our largest and most family-friendly fire pit table, the Naples upholds the beauty of the Firetainment Fire Pit Table Collection with room to accommodate even the largest of parties. The 54" Naples fire table seats 6-10 people comfortably depending on the seating style. There is ample space from the edge of the table top to the burner pan allowing for space to dine. The distance from the edge of the table to the center of the cooking elements make it easy for everyone around the table to easily cook their own food. The 24" height allows one to get their knees underneath with room to spare. The height also allows you to see over the flame or cooking elements so eye contact with those around is not obstructed, creating the perfect dining and entertainment experience!
HTML
                            ],
                            [
                                'title' => 'Venice 42in. Square Fire Pit Table',
                                'description' => <<<'HTML'
Romanticized beauty and traditional features make the petite-sized Venice fire pit table an exquisite attraction to graciously enhance the value of any outdoor living space. The 42" Venice fire table seats 4-6 people comfortably depending on the seating style. There is ample space from the edge of the Venice tabletop to the burner pan allowing for space to dine. The distance from the edge of the table to the center of the cooking elements make it easy for everyone around the table to easily cook their own food. The 24" dining height allows one to get their knees underneath with room to spare. The height also allows you to see over the flame or cooking elements so eye contact with those around is not obstructed, creating the perfect dining and entertainment experience!
HTML
                            ],
                            [
                                'title' => 'Rivera 48in. Round Fire Pit Table',
                                'description' => <<<'HTML'
With its smooth and round design, our most popular mid-size fire pit table melds perfectly as the center of any patio furniture layout. The 48" Riviera fire table seats 4 - 8 people comfortably depending on the seating style. There is ample space from the edge of the table top to the burner pan allowing for space to dine. The distance from the edge of the table to the center of the cooking elements make it easy for everyone around the table to easily cook their own food. The 24" height allows one to get their knees underneath with room to spare. The height also allows you to see over the flame or cooking elements so eye contact with those around is not obstructed, creating the perfect dining and entertainment experience!
HTML
                            ],
                            [
                                'title' => 'Cosmopolitan Square Firetable',
                                'description' => <<<'HTML'
The Cosmopolitan, or "Cosmo". Square Firetable features a tapered, square base and spacious, square top. The chat height of this piece makes it the perfect setting for a relaxed and intimate meal or cocktail hour around the warming flames. The new and enhanced burner pan prevents heat cracking, eliminates discoloration, and allows for ease of assembly and maintenance. Giving you many more years of enjoyment. Our firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete.

HTML
                            ],
                            [
                                'title' => 'Munich Wall Fire Pit',
                                'description' => <<<'HTML'
The Munich Wall Fire Pit is a raised unit built from the Munich Wall Block. This is a gas fire pit with a decorative log set and lava rock added to accent it.
HTML
                            ],
                            [
                                'title' => 'Linear Outdoor Fire Pit',
                                'description' => <<<'HTML'
There is nothing more enjoyable than spending time outdoors with your family and friends. The Napoleon Linear Patioflame outdoor fire pit features a slim, sleek, modern design adding excitement to your outdoor living space. The Linear Patioflame comes complete with a Hammertone Pewter powder coated cabinet. The burner, burner chassis, and convenient cover plate, complete with handle, are made from weather resistant stainless steel. The Linear Outdoor Fire Pit Includes the following features: Electronic Ignition Stainless Steel Cover & Handles Topaz Crystaline Ember Bed Rust Resistant Surround Stainless Steel Burner Chassis Up to 60,000 BTU's
HTML
                            ],
                            [
                                'title' => 'Amphora Firetable with Concrete Top',
                                'description' => <<<'HTML'
The Amphora Firetable features a round, Grecian-style base with a wide circular top at the perfect height for a relaxed evening around the warming flames. The firetable inspires family conversations. Our firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Table available with either a granite inset top or a concrete top. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete.
HTML
                            ],
                            [
                                'title' => 'Chat Height Octagon Firetable w/ Concrete Top',
                                'description' => <<<'HTML'
The Chat Height Octagon Firetable features an octagonal base with beautiful lower detailing and a wide round top. The chat height of this piece makes it the perfect setting for a relaxed and intimate meal or cocktail hour around the warming flames. Our firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Table available with either a granite inset top or a concrete top. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete.
HTML
                            ],
                            [
                                'title' => 'Inverted Firetable w/ Concrete Top',
                                'description' => <<<'HTML'
The Inverted Firetable features a multi-faceted base with a wide circular top set at the perfect height for a relaxed and intimate meal around the warming flames. Our firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Table available with either a granite inset top or a concrete top. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete.
HTML
                            ],
                            [
                                'title' => 'Fiesta Firetable',
                                'description' => <<<'HTML'
The Fiesta Firetable features a powder-coated wrought iron stripped base and spacious circular, cast-concrete top. The chat height of this piece makes it the perfect setting for a relaxed and intimate meal or cocktail hour around the warming flames. Our firetables create the perfect ambiance for enjoying an outdoor meal or cocktail while also keeping you warm from the evening chill. Fuel options include natural gas or self-contained propane tank (base is made with a removable door to house and easily access a propane tank inside). Handcrafted from glass fiber reinforced concrete (top) and powder-coated iron (base). Handcrafted from glass fiber reinforced concrete.
HTML
                            ],
                        ],
                    ],
                    [
                        'title' => 'Tempest Torch',
                        'products' => [
                            [
                                'title' => 'Tempest Pillar Mount, Black',
                                'description' => <<<'HTML'
3" x 5" - Allows installation on raised pillar or pedestal
HTML],
                            [
                                'title' => 'Tempest Wall Mount, Black',
                                'description' => <<<'HTML'
Includes 1/2in. flex

HTML
                            ],
                            [
                                'title' => 'Tempest In-Ground Post - 3in. x 93in.',
                                'description' => <<<'HTML'
Created as a decorative outdoor furnishing for a wide array of exterior settings and applications, the Tempest Torch is designed to create the ultimate in lighting enhancement. The display possibilities are nearly endless; outdoor living spaces, retail or business store fronts, walkway pillars, pool areas, mounted onto movable bases or featured on an exterior wall or entry. The Tempest Torch comes in two version: A very easy manual light system or an electronic ignition version that allows multiple units to be turned on/off by the flip of a light switch or can be tied into your homes automated lighting system.
HTML
                            ],
                            [
                                'title' => 'Tempest Deck Post - 3in. x 69in.',
                                'description' => <<<'HTML'
Created as a decorative outdoor furnishing for a wide array of exterior settings and applications, the Tempest Torch is designed to create the ultimate in lighting enhancement. The display possibilities are nearly endless; outdoor living spaces, retail or business store fronts, walkway pillars, pool areas, mounted onto movable bases or featured on an exterior wall or entry. The Tempest Torch comes in two version: A very easy manual light system or an electronic ignition version that allows multiple units to be turned on/off by the flip of a light switch or can be tied into your homes automated lighting system.
HTML
                            ],
                            [
                                'title' => 'Tempest Deck Mount',
                                'description' => <<<'HTML'
13" Diameter x 5"H

HTML
                            ],
                            [
                                'title' => 'Tempest Torch Head',
                                'description' => <<<'HTML'
Created as a decorative outdoor furnishing for a wide array of exterior settings and applications, the Tempest Torch is designed to create the ultimate in lighting enhancement. The display possibilities are nearly endless; outdoor living spaces, retail or business store fronts, walkway pillars, pool areas, mounted onto movable bases or featured on an exterior wall or entry. The Tempest Torch comes in two version: A very easy manual light system or an electronic ignition version that allows multiple units to be turned on/off by the flip of a light switch or can be tied into your homes automated lighting system. BTU input Max: 20,000 (NG & LP) Tempered glass Glass panels are easy to remove for cleaning Stainless Steel construction Automatic gas shut off if flame goes out Easy access control panel Piezo igniter to easy lighting On/Off control Natural Gas or Propane models
HTML
                            ],
                            [
                                'title' => 'Tempest Post Cover, Square Black',
                                'description' => <<<'HTML'
For deck mount. Decorative base. 13" Sq x 6"H
HTML
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Railings & Pavers',
                'description' => <<<'HTML'
How would you like to take your windows, doors, and walkways to the next level? At Danielle Fence & Outdoor Living, we have a wide variety of railings – ranging from traditional to contemporary styling – that will enhance both the safety and appearance of windows and walkways. We can also do the same for driveways, pool decks, walkways, and more with a variety of beautifying paver solutions. Look over our portfolio of products or browse our blog for design ideas. Dress up your home with our railings and pavers, and your neighbors will worship the very ground that you walk on!
HTML,
                'subcategories' => [
                    [
                        'title' => 'Railings',
                        'description' => <<<'HTML'

HTML,

                        'products' => [
                            [
                                'title' => 'Aluminum Railing',
                                'description' => <<<'HTML'
Our Aluminum Railing is the overwhelming choice for those who want architectural beauty without the costly and time-consuming maintenance of other railing materials. Let us customize a railing to suit the style and beauty of your home. Our aluminum railing is ideal for your porch, deck, patio, or balcony.

HTML],
                            [
                                'title' => 'New England Railing',
                                'description' => <<<'HTML'
Enjoy traditional beauty with the no maintenance, carefree lifestyle of modern materials in the New England Vinyl Railing. Fence StyleRailingMaterialPVC / Vinyl.
HTML
                            ],
                            [
                                'title' => 'Belly Railing',
                                'description' => <<<'HTML'
Not many railings have the detail and styling found in the Belly Vinyl Railing. The maintenance free Belly Railing creates an impressive and rich appearance to any view! PCV/VINYL
HTML
                            ],
                            [
                                'title' => 'Aztec Railing',
                                'description' => <<<'HTML'
The Aztec Vinyl Railing is a great choice for your deck or porch. It has an amazing style all its own! Fence StyleRailingMaterialPVC / Vinyl
HTML
                            ],
                            [
                                'title' => 'Sacremento Railing',
                                'description' => <<<'HTML'
Great for second and third floor balcony railings. With our Sacramento Vinyl Railing, you can create the look of traditional and elegant accents to your deck, patio, balcony, roof line, or trim.Fence StyleRailingMaterialPVC / Vinyl
HTML
                            ],
                            [
                                'title' => 'Chain Railing',
                                'description' => <<<'HTML'
5" x 5" Vinyl Post with adjustable locking chain guide rail for added safety. Fence StyleRailing.
HTML
                            ],
                            [
                                'title' => 'Spindle Railing',
                                'description' => <<<'HTML'
Our Spindle Railing will work beautifully with your porch, deck or patio, adding another element of architecture to your home. Fence StyleRailingMaterialPVC / Vinyl
HTML
                            ],
                            [
                                'title' => 'Custom Accents',
                                'description' => <<<'HTML'
We create ornamental custom accents from aluminum or wrought iron. We can do custom designs or duplications. If you can draw it, we can build it. Made with decorative iron.
HTML
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pavers',
                        'products' => [
                            [
                                'title' => 'Appian Stone',
                                'description' => <<<'HTML'
The Old World meets maintenance-free, modern durability in Appian-Stone&reg; pavers. Named after Europe's famous Appian
Way, these paver give your hardscape a natural look and feel that evokes another age. Suitable for pedestrian and vehicular traffic, Appian-Stone® is available in a wide range of colors. Several pattern designs and even more flexibility to your project. Brick PaversWalkways and Patios.

HTML],
                            [
                                'title' => 'Subterra',
                                'description' => <<<'HTML'
GREAT-LOOKING AND GREEN. Subterra Stone might very well be the most attractive, natural-looking permeable paver on the market. With its false joint structure, Subterra offers the elegant look of natural chiseled stone, yet it is easy to install. Combined with its unsurpassed environmental benefits, Subterra is ideal for homeowners who desire environmental stewardship without compromising beauty and style. Permeable
HTML
                            ],
                            [
                                'title' => 'Mega-Arbel',
                                'description' => <<<'HTML'
Mega-Arbel pavers give homeowners the perfectly integrated, natural-looking hardscapes they desire. Featuring a range of attractive natural hues to choose from, Mega-Arbel’s scale is similar to natural flagstone—roughly two times larger than Arbel, its smaller counterpart. Plus, installation is easy—cutting is reduced to a minimum due to Mega-Arbel’s ingenious interlocking design. Brick PaversPermeable.
HTML
                            ],
                            [
                                'title' => 'Holland Stone',
                                'description' => <<<'HTML'
With its simple shape and utilitarian appeal, Holland Stone is a practical choice for a variety of residential and commercial installations. Its exceptional strength and durability combine with a range of captivating color blends that add to Holland Stone’s popularity. Basic in form, its clean, modular shape makes possible a myriad of applications. Brick Pavers, Walkways & Patios.
HTML
                            ],
                            [
                                'title' => 'Highland Stone',
                                'description' => <<<'HTML'
Combining multiple product sizes, the Highland Stone® retaining wall system evokes the random look of hand-stacked walls. Brick PaversWalls, Stairs & Steps.
HTML
                            ],
                            [
                                'title' => 'Aqua Bric',
                                'description' => <<<'HTML'
A residential look that stands up to even the heaviest industrial traffic. Environmentally and economically sound, Aqua-Bric permeable pavers are comfortable underfoot, meeting Americans with Disabilities Act architectural guidelines, but they're strong enough for vehicle traffic. Use for plazas, driveways, entrances and parking lots to eliminate standing water, allow natural drainage and recharge groundwater. Minimal openings, an interlocking design and exceptional color allow maximum design flexibility. Our Aqua-Bric pavers can even be antiqued to lend European charm to any project. Brick PaversPermeable.
HTML
                            ],
                            [
                                'title' => 'Weston Stone',
                                'description' => <<<'HTML'
This 3-piece wall system is a 4" high, smooth-face, tapered, antiqued block set that can be used independently to build small retaining walls, free-standing walls, and more. This system can also be used with Weston Stone-Universal for caps, columns, and other creative elements. Weston Stone is available in rich color blends to complement the Belgard family of pavers and natural surroundings alike.
HTML
                            ],
                            [
                                'title' => 'Uni Eco-Stone',
                                'description' => <<<'HTML'
Uni Eco-Stone&trade; makes efficient use of land that might not otherwise be developed because of stormwater retention
and limitations on the impervious area allowed on a site. This paver gives the designer a tool to minimize the environment's impact on land development. Made with the same strength, durability and aesthetics as solid concrete pavers. Uni Eco-Stone™ is a natural way to handle storm water runoff, conserve rainwater, recharge groundwater storage, improve water quality and mitigate pollution on surrounding surface waters. Brick PaversPermeable.
HTML
                            ],
                            [
                                'title' => '4in. x 8in. Pavers',
                                'description' => <<<'HTML'
Customize your hardscaping project the way you want it with our 4x8 Brick Pavers. The tried and true shape of our brick pavers combines simplicity with sophistication and versatility. These pavers will look great whether you install them in running bond, basketweave, or herringbone patterns. Brick PaversWalkways and Patios.
HTML
                            ],
                            [
                                'title' => 'Olde Towne',
                                'description' => <<<'HTML'
The Olde Towne Paver Collection brings classic appeal to your residential or commercial hardscape project. Olde Towne pavers can transform your driveway into a elegantly styled entrance way that is sure to become the envy of your neighborhood. Add a focal point to your project by integrating a Romanesque Circle. Accent your driveway, patio or pool deck pavers using a solid border of Olde Towne 6x9 pavers.
HTML
                            ],
                            [
                                'title' => 'Stonegate Wall Block',
                                'description' => <<<'HTML'
The Stonegate Wall Series is made to resemble weathered cut stone. Stonegate retaining wall blocks add classic Old World charm to your backyard design project. The Stonegate Wall Series enables you to create a low barrier knee wall on both sides of a walkway or define the boundaries of your paver patio.
HTML
                            ],
                            [
                                'title' => 'Stonehurst',
                                'description' => <<<'HTML'
Stonehurst brick pavers, available in two finishes and several colors, provide an unrivaled solution to all of your hardscaping needs. The natural slate stone finish of these premium pavers give your home an elegant, upscale appearance. Brick PaversWalkways and Patios.
HTML
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Outdoor Living Spaces',
                'description' => <<<'HTML'
<p>Can The Great Outdoors get even greater?&nbsp; We think so.&nbsp; At Danielle Fence &amp; Outdoor Living, we offer a large selection of outdoor environment solutions that includes spacious screen rooms, magnificent arbors, gracious gazebos, and cozy cabanas; outdoor features that are both functional and decorative, with designs that are both contemporary and traditional.</p>
<p>Take a screen room, for instance. While there’s nothing like enjoying nature, sometimes nature actually gets in the way. Flying critters that bite and creeping things you can’t identify, for example, can make being outside, well, a lot less fun. What you need is a screened enclosure, which our professionals will design and install for you.</p>
<p>We’re also expert at beautifying backyards with decorative garden features, such as arbors, gazebos, and pergolas. Transform that backyard into a restful respite, where you can enjoy all that nature has to offer, along with the company of family and friends. Look over our portfolio of products or browse our blog for design ideas now, so that you can begin your lifetime of outdoor room enjoyment today.&nbsp;</p>    </div>
HTML,

                'subcategories' => [
                    [
                        'title' => 'Screen Rooms',
                        'description' => 'Screen Rooms',
                        'products' => [
                            [
                                'title' => 'Screen Room with Insulated Roof',
                                'description' => <<<'HTML'
Let Danielle help you increase your outdoor living space with a new screen room. Enjoy the outdoors without those pesky Florida bugs and UV rays! At Danielle, we handle all aspects of your project from start to finish. Request a FREE quote and we will provide you with your options so that you can make a selection that meets all your needs.
HTML

                            ],
                            [
                                'title' => 'Screen Rooms',
                                'description' => <<<'HTML'
Let Danielle help you increase your outdoor living space with a new screen room. Enjoy the outdoors without those pesky Florida bugs and UV rays! At Danielle, we handle all aspects of your project from start to finish. Request a FREE quote and we will provide you with your options so that you can make a selection that meets all your needs.
HTML

                            ],
                        ],
                    ],
                    [
                        'title' => 'Pergolas',
                        'products' => [
                            [
                                'title' => 'Insulated Roof Systems',
                                'description' => <<<'HTML'
The Insulated Roof System offers a great looking Patio Roof and can easily be enclosed with a Screen Room or Patio Enclosure. Sit back and enjoy the openness of your new outdoor living space today with an Insulated Roof System.
HTML],
                            [
                                'title' => 'Aluminum Pergolas',
                                'description' => <<<'HTML'
Is it wood or is it aluminum? With its realistic finish, it is hard to tell. However, the difference will be clear when your Aluminum Pergola is never in need of paint or repair, will not burn, or attract termites and is virtually a maintenance-free part of your home or business.
HTML
                            ],
                            [
                                'title' => 'Equinox Louvered Roof',
                                'description' => <<<'HTML'
The Equinox Louvered Roof is an ingenious mechanism that transforms from a solid water proof covering to an open garden trellis or Pergola style covering giving light, ventilation and views of the clear sky above. All this takes place at the touch of a button giving you complete flexibility of your light and weather control needs for any outdoor living area.
HTML
                            ],
                            [
                                'title' => 'Vinyl Pergolas',
                                'description' => <<<'HTML'
Bring a touch of Italy to your backyard with an eye-catching pergola. You will have your friends and family in awe! Danielle Fence & Outdoor Living can help you create an environment that reflects your own personality and style. Use the pergola to make the outdoors more inviting, to extend livable space or to create a shady retreat. A custom pergola will add grace, style, comfort and architectural character to your home.
HTML
                            ],
                        ],
                    ],
                    [
                        'title' => 'Arbors',
                        'products' => [
                            [
                                'title' => 'Caprice Arbor',
                                'description' => <<<'HTML'
Make a grand statement and add style to an average yard with the Caprice Arbor. This attractive arbor will add beauty and elegance to your yard year after year with no maintenance.
HTML],
                            [
                                'title' => 'Morning Glory Arbor',
                                'description' => <<<'HTML'
Create a bold entrance to your yard or garden with the Morning Glory Arbor. The cross-arched top crowns your garden with whimsical grace.
HTML
                            ],
                            [
                                'title' => 'Highlander Arbor',
                                'description' => <<<'HTML'
Pique interest in your garden with the Highlander Arbor. The classic design of the side panels, combined with an arched or flat top lends visual interest while maintaining an elegant feel.
HTML
                            ],
                            [
                                'title' => 'Fairfield Arbor',
                                'description' => <<<'HTML'
Make a grand statement and add style to an average yard with the Fairfield Arbor. This attractive arbor will add beauty and elegance to your yard year after year with no maintenance.
HTML
                            ],
                            [
                                'title' => 'Day Lily Arbor',
                                'description' => <<<'HTML'
Make a classic entrance into an ordinary yard with the clean, traditional styling of the Day Lily Arbor. The white lattice and refined look make the Day Lily Arbor a welcome addition to any home.
HTML
                            ],
                            [
                                'title' => 'Vesper Rose Arbor',
                                'description' => <<<'HTML'
Adorn your garden with the Vesper Rose Arbor. The detailed geometric designs on the side panels add a modern feel to your garden. The white vinyl construction brightens any surrounding while offering a weatherproof exterior.
HTML
                            ],
                            [
                                'title' => 'Riviera Arbor',
                                'description' => <<<'HTML'
With irresistible radiance, the Riviera Arbor brings the romantic aspects into your yard or garden, which never goes out of style.
HTML
                            ],
                            [
                                'title' => 'Regal Arbor',
                                'description' => <<<'HTML'
For the look of wrought iron without the maintenance, the Regal Arbor creates a classic theme in your garden that you’ll want to visit all year round.
HTML
                            ],
                            [
                                'title' => 'Oxford Arbor',
                                'description' => <<<'HTML'
Create a lively centerpiece for any yard or garden with the Oxford Arbor. When coupled with climbing vines along the sides, it makes for a unique design.
HTML
                            ],
                            [
                                'title' => 'Arched Arbor',
                                'description' => <<<'HTML'
Our Arched Aluminum Arbor is made from quality aluminum with a black powder coated finish. The sides are designed to allow garden plants and vines to grow throughout the arbor.
HTML
                            ],
                        ],
                    ],
                    [
                        'title' => 'Gazebos',
                        'products' => [
                            [
                                'title' => '7ft. Gazebo',
                                'description' => <<<'HTML'
Create an outdoor environment that fits your lifestyle. Use a gazebo for a spa enclosure, game room or poolside picnic area. Comfortable and accommodating, it provides a pleasant place to sit back and relax.
HTML],
                            [
                                'title' => '10ft. Gazebo',
                                'description' => <<<'HTML'
Create an outdoor environment that fits your lifestyle. Use a gazebo for a spa enclosure, game room or poolside picnic area. Comfortable and accommodating, it provides a pleasant place to sit back and relax.
HTML
                            ],
                            [
                                'title' => 'Victorian Gazebo',
                                'description' => <<<'HTML'
Bring back the Victorian Age with a Gazebo designed to fit your outdoor space. Available in 2 sizes with 4 different color options. For a unique touch consider adding one of our new Embossed or Streaked textures to your Gazebo.
HTML
                            ],
                        ],
                    ],
                ],
                'products' => [

                    [
                        'title' => 'Pavilions and Cabanas',
                        'description' => <<<'HTML'
Spend time with friends and family in your open air pavilion or cabana by Danielle Outdoor Living. Our pavilions and cabanas create the perfect space for entertaining and gives you and your guests a place to escape from the hot Florida sun.
HTML,
                    ],
                ],
            ],
            [
                'title' => 'Specialty Products',
                'description' => '<p>Discover our unique collection of specialty fencing and outdoor products designed to meet your specific needs. From custom solutions to innovative designs, Danielle Fence & Outdoor Living offers specialized products that go beyond traditional fencing to enhance your property\'s functionality and aesthetic appeal.</p>',
                'subcategories' => [
                    [
                        'title' => 'Custom Solutions',
                        'description' => 'Tailored fencing and outdoor products designed specifically for your unique requirements.',
                    ],
                    [
                        'title' => 'Commercial Specialty',
                        'description' => 'Specialized commercial-grade products for businesses, schools, and industrial applications.',
                    ],
                    [
                        'title' => 'Decorative Accents',
                        'description' => 'Unique decorative elements and accessories to complement your outdoor living space.',
                    ],
                ],
            ],
        ];
    }

    public function blogCategories(): array
    {
        return [
            'General',
            'Fencing',
            'Grills',
            'Pergolas',
            'Gazebos',
            'Fire Features',
        ];
    }

    public function faq()
    {
        return [
            [
                'question' => 'What kind of maintenance does vinyl fencing require?',
                'answer' => 'A vinyl / PVC fence and accessories requires virtually no maintenance. The high quality of Danielle Designer Series™, Country Estate™, Country Manor™, and G-Fence™ products are impervious to deterioration from moisture, temperature extremes, ultraviolet light exposure. and the wear and tear from time itself. You will never have to scrape or paint your vinyl fence, unlike wood, metal, aluminum, or imitation PVC fence. You will be able to enjoy your Danielle Fence vinyl fence from the very first day it is installed to years down the road. No traditional fence maintenance is required.',
            ],
            [
                'question' => 'How do I clean my vinyl/PVC fence?',
                'answer' => 'In the event that your PVC fence grows mold, you can quickly and easily clean it off using a pressure washer. That is all that is needed to make your fence look new again!',
            ],
            [
                'question' => 'Can my vinyl/PVC fence be recycled?',
                'answer' => 'If the day comes when you no longer have a use for your  vinyl / PVC fence, then it can be dismantled and the materials can be safely recycled.',
            ],
            [
                'question' => 'Can more fence be added to my existing wood, vinyl, aluminum, or post & rail fence?',
                'answer' => 'Every project is different but in most cases the answer is yes. It is common for fence and outdoor home improvement projects to be completed in phases, which means they are spread out over time. A new section of Danielle fence can be added to a previous project and when done, both the old and the new will blend perfectly.',
            ],
            [
                'question' => 'Will a quality wood, vinyl, aluminum, post & rail or EcoStone fence enhance my property value?',
                'answer' => 'Yes, a beautiful fence around your property enhances its value in many ways. It may provide privacy to your backyard or prevent uninvited guests to your swimming pool. Maybe you simply want an attractive backdrop for your flower garden, or the ability to give your dog room to run and play without escaping. Adding a fence is a great way to get any of those tasks done, with flair. If you ever decide to sell your home, then your Danielle fence will add to the appeal of your listing because potential buyers will know that they won’t have to go through the time and expense of adding a fence themselves.',
            ],
            [
                'question' => 'Does Danielle Fence install vinyl or PVC fence in colors other than white, and can it be textured or have a wood-grain finish?',
                'answer' => 'Danielle Fence styles are available in four colors: white, almond, adobe, and gray. These different color choices will make it easy to match a fence to your residence. All four colors can also be embossed or streaked, to add even more options for you.',
            ],
            [
                'question' => 'How do I find a reputable fence contractor in Central Florida or the Tampa Bay area?',
                'answer' => 'Ideally, the company that you hire should be someone you know or someone who has successfully installed a fence or outdoor project for a friend or neighbor.

A good fence contractor and installer:
<ul>
<li>Is well known and easily reached by phone or in-person.</li>
<li>Has a physical showroom that you can visit to inspect materials and samples.</li>
<li>Has an established reputation.</li>
<li>Will provide you with a detailed specification page showing the design and the materials to be used for your new fence.</li>
<li>Will show you photos of previous installations and offer names of past customers for references.</li>
<li>Will work with you to understand your needs and create designs for your requests.</li>
<li>Will not ask you to pay for the entire job in advance.</li>
<li>Will never pressure you to sign a contract.</ul>',
            ],
            [
                'question' => 'What is the required fence clearance for fire hydrants in Hillsborough, Pasco, Polk, and other counties in Florida?',
                'answer' => 'All hydrants must have a 4′ rear clearance and a 7′ clearance on all other sides of the valve, including landscaping. Rear clearance means the side of the hydrant with no valve.',
            ],
        ];
    }

    public function carousels()
    {
        //        $f =[];
        //        $files = glob('./resources/images/default_slides/*');
        //        foreach($files as $file) {
        //            $a = substr($file, strrpos($file, '/') + 1);
        //            $b = str_replace('-',' ',$a);
        //            $c = ucwords($b);
        //            $f[$a] = $c;
        //        }
        //        asort($f);
        //        return $f;
        return [];
    }
}
