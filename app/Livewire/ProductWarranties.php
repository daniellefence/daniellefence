<?php

namespace App\Livewire;

use Livewire\Component;

class ProductWarranties extends Component
{
    public $warranties2 = [
        'fence' => [
            'label' => 'Fence Warranties',
            'items' => [
                'vinyl' => [
                    'image' => 'pvcwarranty.jpg',
                    'label' => 'Vinyl (PVC) Fence Warranty',
                    'images' => [
                        [
                            'title' => 'BGM PVC/Vinyl Fence',
                            'url' => 'D0027_B_BGM-10-Year-Prorated-Limited-Warranty-Danielle_07-13-12.webp',
                        ],
                        [
                            'title' => 'CEF PVC/Vinyl Fence',
                            'url' => 'CEF-Warranty-Card-1.webp',
                        ],
                        [
                            'title' => 'Country Manor Products',
                            'url' => 'CEF-Warranty-Card-1.webp',
                        ],
                    ],
                ],
                'simulated' => [
                    'image' => 'simulatedstonefencewarranty.jpg',
                    'label' => 'Simulated Stone Warranty',
                    'images' => [
                        [
                            'title' => 'Simulated Stone Fence Warranty',
                            'url' => 'Bufftech-Warranty_2019_2.jpg',
                        ],
                    ],
                ],
                'aluminum' => [
                    'image' => 'aluminumfencewarranty.jpg',
                    'label' => 'Aluminum Fence Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose">
<h3 class="text-center">LIMITED LIFETIME WARRANTY</h3>
<p>Aluminum Fencing carries a lifetime- limited warranty (“warranty”) against defects in workmanship.  Aluminum Fencing also warrants the powder coated finish will not chip, crack, or flake.  The warranty is not transferable and is only valid to the original purchaser.  The warranty on commercial installations of fences that are purchased by other than a natural person, shall be limited to a period of thirty (30) years.</p>

<p>Aluminum Fence Manufacturer will repair and/or replace, at their sole discretion, those found to be defective.  Aluminum Fence Manufacturer will not be responsible for any incidental or consequential damages.  This warranty does not cover the cost of removal, or transportation charges incurred for the purpose of inspection and validation of the claim for the repair or replacement of the fence.  All removal, shipping, and reinstallation costs shall be the responsibility of the Purchaser.  Any materials that are suspected of needing warranty action must be shipped to Danielle Fence Manufacturing in Mulberry, Florida.  The freight charges must be pre-paid by the shipper.  Danielle Fence Manufacturing will not accept collect shipments.</p>

<p>The warranty becomes void if the product is mishandled, altered, abused, misused, damaged in transit or damaged by an uncontrollable force of nature, act of God, or declaration of war.  Aluminum Fence Manufacturer will not be held responsible for personal injury resulting from a defect in the fencing materials.</p>

<p>In order for the warranty to be valid, the attached warranty acknowledgement must be completed and returned to Danielle Fence Manufacturing within thirty (30) days of the installation.  Failure to timely return the attached warranty acknowledgement and pay in full for the material will automatically void the warranty, without further action on the part of Aluminum Fence Manufacturer.</p>

<p>The above warranty constitutes the complete warranty by Aluminum Fence Manufacturer and there is no other agreement either written or implied.  No person is authorized to modify this warranty.  Venue for any legal action brought to enforce any right under this warranty shall be in Hernando County, Florida.  The warranty gives you specific legal rights and you may have other rights which may vary from State to State.</p>
</div>
HTML,

                ],
                'wood' => [
                    'image' => 'woodfencewarranty.jpg',
                    'label' => 'Wood Fence Warranty',
                    'images' => [
                        [
                            'title' => 'Wood Fence Warranty',
                            'url' => '30-Year_Posts.jpg',
                        ],
                    ],
                ],
                'textured' => [
                    'image' => 'texturedvinylfencewarranty.jpg',
                    'label' => 'Textured Vinyl Fence Warranty',
                    'images' => [
                        [
                            'title' => 'Textured Vinyl Fence Warranty',
                            'url' => 'Bufftech_Warranty-2-1.jpg',
                        ],
                    ],
                ],
            ],
        ],
        'grills-and-accessories' => [
            'label' => 'Grills & Accessories',
            'items' => [
                'chicago-brick-oven' => [
                    'image' => 'CBO.jpg',
                    'label' => 'Chicago Brick Oven Warranty',
                    'images' => [
                        [
                            'title' => 'Chicago Brick Oven Warranty',
                            'url' => 'CBO-Warranty_1.jpg',
                        ],
                    ],
                ],
                'evo' => [
                    'image' => 'evo2.jpg',
                    'label' => 'EVO Grill Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="warranty-desc"><p>Evo, Incorporated warrants to the original residential consumer-purchaser that the Evo grill shall be free from rust-through on all metal surfaces and shall be free from defects in materials and workmanship under normal and reasonable use from the original date of purchase. Evo promises to replace, at its determination, any product or component that is defective and covered under this warranty for as long as you, the registered original consumer-purchaser, owns the grill. This is your sole and exclusive remedy. This warranty is for the benefit of the original consumer-purchaser and is non-transferable. This warranty is subject to the limitations, exclusions and other provisions listed below.</p>
<p>Limitations Involving Materials and Components:<br>
Warranty does not apply to normal wear and tear, which are expected over the course of ownership. The materials and components listed below are covered according to the following schedule from the original date of purchase:</p>
<ul>
<li>One Year – electrical and electronic components [including, but not limited to, electronic displays, overlay and membrane switches, temperature sensors (RTD and K-Value Thermal Couple), hot surface igniters, computers, transformers, heater elements, relays, igniters, ignition controllers, wiring, switches, encoders, outlets and plugs</li>
<li>One Year – gas components [including, but not limited to, gas regulator, gas hoses, manifold assemblies]</li>
<li>One Year – accessories and repair parts</li>
</ul>
<p>The Warranty Registration Card (or online warranty registration form available at www.evoamerica.com/content/residential-warranty-registration) must be completed and returned/submitted to Evo, Incorporated within 30 days from the date of purchase. The original purchase invoice or payment record must be retained and produced upon request if claims are made under this warranty. To receive a replacement Warranty Registration Card, write or call the address listed at the bottom of this page. Warranties are void if the original serial numbers have been removed, altered, or cannot be readily determined.</p>
<p>THIS WARRANTY APPLIES ONLY TO PRODUCTS PURCHASED AND LOCATED WITHIN THE UNITED STATES OR CANADA.</p>
<p>WHAT IS NOT COVERED BY THIS WARRANTY<br>
1. Conditions and damages resulting from any of the following:</p>
<ul>
<li>Improper or inadequate installation, delivery, use, storage or maintenance</li>
<li>Any repair not authorized in writing by Evo, Inc., any modifications, misapplications, or unreasonable use</li>
<li>Improper setting of any control</li>
<li>Harsh environmental conditions, including, but not limited to, continual seawater spray,&nbsp;high pressure&nbsp;water, and direct contact with corrosive chemicals and materials</li>
<li>Excessive or inadequate electrical, or gas supply</li>
<li>Accidents, natural disasters, acts of God</li>
<li>Conditions covered by the purchaser’s insurance</li>
<li>Cleaning supplies and filters</li>
</ul>
<p>2. Products purchased or utilized for commercial use without the express authorization of Evo, Incorporated for such use.<br>
3. Labor not pre-authorized by Evo, Incorporated, and labor not performed by an authorized Evo service agency or representative.<br>
4. Pre-authorized warranty labor performed outside of normal business hours, and at overtime and premium rates.<br>
5. The cost of service or a service call to:</p>
<ul>
<li>Identify or correct installation errors</li>
<li>Transport the product or component for service to/from the manufacturer or service center</li>
<li>Instruct the user of the proper use of the product</li>
</ul>
<p>6. The cost for any inconvenience, personal injury or property damage due to&nbsp;failure&nbsp;of the product, and cost of damage arising out of the transportation of the product which is covered under different terms with the carrier.<br>
7. Natural variations in color and finishes that are inherent to the material and unavoidable (and therefore not defects).</p>
<p>ALL IMPLIED WARRANTIES, INCLUDING THE IMPLIED WARRANTIES OF MERCHANTABILITY, SUITABILITY, QUALITY AND/OR FITNESS FOR A PARTICULAR PURPOSE, ARE LIMITED IN DURATION TO THE EXPRESS WARRANTY PERIODS SPECIFIED ABOVE FOR THE PARTS DESCRIBED THEREIN. EVO, INCORPORATED MAKES NO OTHER WARRANTY AND WILL NOT BE LIABLE FOR ANY DIRECT OR INDIRECT, CONSEQUENTIAL OR INCIDENTAL DAMAGES. Some states do not allow limitations on how long an implied warranty lasts, so the above limitation may not apply to you. Neither Evo manufacturer representatives and dealers, nor the retail establishment selling this product&nbsp;has&nbsp;any authority to make any warranties or to promise remedies in addition to or inconsistent with those stated above. The maximum liability to Evo, Incorporated in any event, shall not exceed the purchase price of the product paid by the original consumer-purchaser. Some states do not allow the exclusion or limitation of incidental or consequential damages, so the above limitations or exclusions may not apply to you. This warranty gives you specific legal rights, and you may also have other rights which vary from state to state.</p>
</div>
HTML,

                ],
                'aog' => [
                    'image' => 'AOG.jpg',
                    'label' => 'American Outdoor Grill Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
 <div class="prose">
<h2>AMERICAN OUTDOOR GRILL® WARRANTY HIGHLIGHTS</h2>


<p>FIFTEEN YEAR WARRANTY</p>


<p>American Outdoor Grill® stainless steel burners are warranted for Fifteen (15) years</p>


<p>TEN YEAR WARRANTY</p>


<p>All other American Outdoor Grill® parts (excluding ignition systems, accessories, infrared burner, and vaporizer panels) are warranted for Ten (10) years</p>


<p>THREE YEAR WARRANTY</p>


<p>Infrared burners and vaporizer panels are warranted for Three (3) years</p>


<p>ONE YEAR WARRANTY</p>


<p>Ignition systems (excluding batteries) and accessories (including side burners, motors, and thermometers) are warranted for One (1) year</p>
 </div>
HTML,

                ],
                'memphis' => [
                    'image' => 'memphis.jpg',
                    'label' => 'Memphis Grills Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose">
<p>Products manufactured by Memphis Wood Fire Grills carry a seven (7) year Limited Warranty from the date of purchase by the original owner against defects in material and workmanship. Electronic and electrical components carry a three (3) year replacement warranty when subjected to normal residential use. Limited Warranty does not apply to burn pot, meat probe, grill cover gaskets or damage caused by corrosion. The meat probe is under Warranty for 30 days from the date of purchase.</p>
<p>Conditions of Limited Warranty<br>
During the term of the Limited Warranty, Memphis Wood Fire Grills’ (MWFG)&nbsp;obligation shall be limited to replacement of covered, failed components, F.O.B. point of shipment. MWFG will repair or replace parts returned to MWFG, freight&nbsp;prepaid,&nbsp;if the part(s) are found by MWFG to be defective upon examination. MWFG shall not be liable for transportation charges, labor costs, or export duties. Except as provided in this CONDITIONS OF LIMITED WARRANTY, repair or replacement of parts in the manner and for the period of time stipulated hereunder shall constitute the fulfillment of all direct and derivate liabilities and obligations from MWFG to you.</p>
<p>The Warranty coverage begins on the original date of purchase as stated on the sales receipt. Warranty Registration and proof of original date of purchase&nbsp;is&nbsp;required to validate the Limited Warranty.</p>
<p>Repair or replacement of the MWFG component does not extend the Limited Warranty.</p>
<p>Pouring hot liquids on or in your MWFG product will void this warranty. Any modifications including holes, screws, and any other sheet metal changes to the product will void this warranty.</p>
<p>MWFG takes every precaution to utilize materials that retard rust. Even with these safeguards, the material can be compromised by various substances and conditions beyond MWFG control. High temperatures, excessive humidity, chlorine, industrial fumes, fertilizers, lawn pesticides and salt are some of the substances that can affect metals and metal coatings. For these reasons, the Limited Warranty DOES NOT COVER RUST OR OXIDATION, unless there is a loss of structural integrity on the grill component. Should any of the above occur, refer to your Owner’s Manual maintenance section for finish protection. MWFG recommends that you purchase&nbsp;a MWFG&nbsp;full-length protective cover for your grill when not in use.</p>
<p>The Limited Warranty is based on residential use. Warranty coverage does not apply to products used in commercial applications. Shipping costs for the product&nbsp;is&nbsp;not covered by the Warranty.</p>
<p>Exceptions to the Limited Warranty</p>
<p>There is no written or implied performance warranty on MWFG Products as the manufacturer has no control over the installation, operations, cleaning, maintenance or the type of fuel burned.</p>
<p>This Limited Warranty will not apply if your product has not been installed, operated, cleaned and maintained in strict accordance with the manufacturer’s instructions. Burning anything other than Premium Grade BBQ wood pellets may void the Warranty. Memphis recommends using Memphis Wood Fire Pellets. The Warranty does not cover damage or breakage due to misuse, improper handling or modifications.</p>
<p>NEITHER THE&nbsp;MANUFACTURER,&nbsp;NOR THE SUPPLIERS TO THE PURCHASER, ACCEPTS RESPONSIBILITY, LEGAL OR OTHERWISE, FOR THE INCIDENTAL OR CONSEQUENTIAL DAMAGE TO THE PROPERTY OR PERSONS RESULTING FROM THE USE OF THIS PRODUCT. ANY WARRANTY IMPLIED BY LAW, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANT‐ABILITY OR FITNESS, SHALL BE LIMITED TO ONE (1) YEAR FROM THE DATE OF ORIGINAL PURCHASE. WHETHER A CLAIM IS MADE AGAINST THE MANUFACTURER BASED ON THE BREACH OF THIS WARRANTY OR ANY OTHER TYPE OF WARRANTY EXPRESSED OR IMPLIED BY LAW, MANUFACTURER SHALL IN NO EVENT BE LIABLE FOR ANY SPECIAL, INDIRECT, CONSEQUENTIAL OR OTHER DAMAGES OF ANY NATURE WHATSOEVER IN EXCESS OF THE ORIGINAL PURCHASE PRICE OF THIS PRODUCT. ALL WARRANTIES BY MANUFACTURER ARE SET FORTH HEREIN AND NO CLAIM SHALL BE MADE AGAINST MANUFACTURER ON ANY ORAL WARRANTY OR REPRESENTATION.</p>
<p>Some states do not allow the exclusion or limitation of incidental or consequential&nbsp;damages,&nbsp;or limitations of implied warranties, so the limitations or exclusions set forth in this Limited Warranty may not apply to you. This Limited Warranty gives you specific legal rights and you may have other rights, which vary from state to state.</p>
<p>The Limited Warranty for seven (7) years is in lieu of all other warranties expressed or implied, at law or other‐ wise, and MWFG does not authorize any person or representative to assume for MWFG any obligation or liability in connection with the sale of this product. This means that no warranties, either expressed or implied are ex‐ tended to persons who purchase the product from anyone other than MWFG or an authorized MWFG Dealer or Distributor.</p>
<p>&nbsp;</p>
<p>Procedure for Warranty Service</p>
<ol>
<li>Complete Warranty Registration&nbsp;<a href="http://memphisgrills.com/warranty-registration/">here</a>&nbsp;or mail the Warranty Registration Form at the end of this Owner’s Manual.</li>
<li>Contact your nearest Memphis Grills&nbsp;Dealer for service and/or part replacement as stated under the conditions of the Limited Warranty.</li>
<li>Be prepared to provide the following: purchaser’s name, date of purchase,&nbsp;copy&nbsp;of dated sales receipt, model and&nbsp;serial number&nbsp;of product and an accurate description of the problem.</li>
</ol>
<p>We strongly recommend you first contact your nearest Memphis Grills&nbsp;Dealer for sales and service. If further assistance is needed call Memphis Wood Fire Grills&nbsp;Customer Service and Technical Support at 1‐888‐883‐2260.</p>
</div>
HTML,

                ],
                'big-green-egg' => [
                    'image' => 'BGE.jpg',
                    'label' => 'Big Green Egg Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose"><h3>Warranty</h3>
<p>IMPORTANT&nbsp;– SEE&nbsp;<a target="_blank" href="http://biggreenegg.com/safety-tips/">SAFETY TIPS</a>&nbsp;AND&nbsp;<a target="_blank" href="http://biggreenegg.com/first-timer-tips/">FIRST TIMER TIPS</a>&nbsp;BEFORE USING YOUR EGG<br>
AFTER READING THE WARRANTY BELOW MAKE SURE YOU&nbsp;<a target="_blank" href="http://biggreenegg.com/warranty-registration/">REGISTER YOUR EGG</a>.<br>
</p>
<p>The Big Green Egg (“BGE”) was the first ceramic grill manufacturer in the world to stand behind its products by offering a Limited Lifetime Warranty, and has maintained this standard for over a quarter-century! Today, each Big Green Egg is carefully inspected and certified to be the highest-quality outdoor cooker ever, and we continue to offer best-in-class customer service and warranty support to purchasers of the Ultimate Cooking Experience!®</p>
<h3 class="lt-green">WARRANTY CLAIM PROCEDURE:</h3>
<p>A valid proof of purchase receipt from an Authorized Dealer will be required to make a Warranty claim. For Warranty support, contact the Authorized Dealer from which the item was purchased.<br>
You may contact any Authorized Dealer if the EGG was purchased within the United States. For EGGs purchased in countries outside the United States, Warranty claims are handled by an Authorized Dealer or Distributor in the country of purchase.<br>
Please refer to the INTERNATIONAL section of the BGE website at BigGreenEgg.com to locate the Authorized BGE International Distributor in your particular region. Warranty claims must be made through an Authorized Dealer or Distributor within the original country of purchase.<br>
Do not ship or mail any components for a Warranty claim before contacting an Authorized Dealer or Distributor, as in some cases it may not be necessary to return the warranted part. Our goal is to make any Warranty claim as simple as possible. If&nbsp;further assistance is needed, please email&nbsp;<a href="mailto:warranty@BigGreenEgg.com" target="_blank" rel="noopener">Warranty@BigGreenEgg.com</a></p>
<p><br>
In the unlikely event that you have a Warranty Claim on a Big Green Egg, these are the TERMS AND CONDITIONS OF THE BIG GREEN EGG LIMITED LIFETIME WARRANTY<br>
</p>
<p>1. THE BIG GREEN EGG:&nbsp;Each Big Green Egg® ceramic cooker (XXLarge, XLarge, Large, Medium, Small, MiniMax and Mini) carries a Limited Lifetime Warranty for materials and workmanship on all ceramic components (including dome, base, damper top, fire box and fire ring) to the original purchaser or owner who has purchased the product from an Authorized Dealer and has registered their Warranty as required (the “Warranty”). This Warranty is valid for as long as the original purchaser owns the EGG® or covered component, except for other ceramic, metal and wood components which are covered as explained below. This warranty is in addition to and does not affect your statutory rights which may apply.<br>
2. OTHER CERAMIC PRODUCTS:&nbsp;The Big Green Egg brand of convEGGtor and Ceramic Pizza/Baking Stones carry a Limited Three (3) Year Warranty to the original purchaser. These ceramic components are not covered for breakage from dropping, improper storage, misuse or abuse.<br>
3. METAL COMPONENTS:&nbsp;Metal, Stainless Steel and Cast Iron components of the EGG (including the metal bands, hinge mechanism, dual function metal top, cooking grid, fire grate and draft door) carry a Limited Five (5) Year Warranty to the original purchaser.<br>
The Big Green Egg makes every effort to utilize materials that resist rust and to use&nbsp;high temperature&nbsp;coatings on metal surfaces. However, metal materials and protective coatings can be compromised by surface scratches or exposure to substances and conditions beyond BGE’s control. Among other things, chlorine, industrial fumes, chemicals, fertilizers, extreme humidity, lawn pesticides and salt are some of the substances that can corrode paint and finish on metal coatings. For these reasons, the Warranty on Metal, Stainless Steel and Cast Iron Components&nbsp;DOES&nbsp;NOT COVER RUST, OXIDATION, FADING or other BLEMISHES unless it also results in a loss of structural integrity or a failure of these components of the EGG.<br>
4. WOOD and COMPOSITE COMPONENTS:&nbsp;Wood EGG Mates,&nbsp;High Density&nbsp;Composite EGG&nbsp;Mates&nbsp;and Genuine BGE Hardwood Tables carry a Limited One (1) Year Warranty to the original purchaser. Only genuine BGE Mates and Tables are covered under this Warranty – please be certain the Tables or Mates you purchase are BGE branded products as third-party products are not covered under the BGE Warranty even if sold by a BGE Dealer.<br>
BGE Mates and Hardwood Tables are not covered for cosmetic or coloring changes, weathering or cracks unless there is also a loss of structural integrity. Please follow recommended care guidelines to maintain&nbsp;appearance&nbsp;of wood products.<br>
CAUTION NOTICE: DO NOT place an EGG directly on or near a combustible surface, deck, table or&nbsp;other flammable base&nbsp;without the use of a BGE Metal Nest or Metal Table Nest, or without making use of&nbsp;other fireproof barrier&nbsp;such as a 2” non-porous concrete block under the EGG. Failure to safely support the EGG will void the Warranty and BGE EXPRESSLY DISCLAIMS ANY LIABILITY FOR ANY DIRECT, INDIRECT, INCIDENTAL OR CONSEQUENTIAL DAMAGE WHICH MAY RESULT.<br>
Do not attempt to use a table nest to support an EGG unless the EGG is actually housed within a table, island or&nbsp;other surround. The low-profile Table Nest is not designed as a free-standing support for your EGG! Only the Mini and MiniMax have a low-profile Nest designed to be used as a free-standing base.<br>
IMPORTANT – See Getting Started and Safety Tips at BigGreenEgg.com.<br>
5. TEMPERATURE GAUGE AND GASKET:&nbsp;Gaskets and the Temperature Gauge carry a Limited One (1) Year Warranty to the original purchaser.<br>
6. MISCELLANEOUS:&nbsp;Other BGE components such as the BGE Cooking Island or BGE accessories purchased from an Authorized Big Green Egg Dealer may also carry various warranties – please check the specific item for details.<br>
7. WHAT IS NOT COVERED:&nbsp;These Warranties are based on normal and reasonable residential use and service of the EGG. Commercial uses and related applications are excluded from Warranty coverage. Warranty does not apply to any incidental losses or accidental damage or breakage, or for any damage caused by: transporting; dropping; misassembly; improperly supporting; attempting to suspend the EGG by any means other than an approved BGE Nest or solid, non-combustible surface under the base; commercial use; modifications; alterations; negligence; abuse; improper care; road hazards; normal and reasonable wear and tear; floods, storms or natural disasters. Warranty coverage does not extend to scratches, dents, chips, crazing, fading, appearances or minor cosmetic cracks of the exterior glaze that do not affect the performance of the EGG.<br>
BIG GREEN EGGS AND RELATED BGE PRODUCTS PURCHASED FROM UNAUTHORIZED RESELLERS, UNAUTHORIZED THIRD PARTIES OR THROUGH UNAUTHORIZED RETAIL CHANNELS SUCH AS DISCOUNT CLUBS AND DISCOUNT CHAIN STORES ARE NOT COVERED UNDER THE BIG GREEN EGG WARRANTY.<br>
Please note: When&nbsp;a consumer purchases&nbsp;from an unauthorized source or reseller, even one operating as an apparently legitimate business offering products in unopened boxes with blank warranty cards, they are buying, by legal definition, used products. When someone buys from an unauthorized reseller or retailer, or from an unauthorized online reseller, they are almost always buying re-sold items without manufacturer’s warranties regardless of any statements or claims made by the seller. This is the published policy of many brands and companies, not just BGE. Check for Authorized BGE Dealers at http://www.biggreenegg.com/locator/<br>
8. DATE OF COVERAGE:&nbsp;The Warranty coverage begins when an EGG is purchased from an Authorized Dealer and is registered at BigGreenEgg.com by the original purchaser or owner as required under this Warranty. If you are unable to register your EGG at the website, an Authorized Dealer can provide a form to complete and mail to BGE.<br>
9. COVERAGE UNDER THE WARRANTY:&nbsp;Original BGE components that are found to have defects in materials or workmanship, and that are covered under a valid and registered Warranty, will be replaced or repaired at the sole discretion of BGE at no cost for the warranted item or component, subject to the terms and conditions of this Warranty. Any Warranty claim must include an accurate description of the problem or visual evidence of the defective part.<br>
10. WARRANTY CLAIM PROCEDURE:&nbsp;A valid proof of purchase receipt from an Authorized Dealer will be required to make a Warranty claim. For Warranty support, contact the Authorized Dealer from which the item was purchased.<br>
You may contact any Authorized Dealer if the EGG was purchased within the United States. For EGGs purchased in countries outside the United States, Warranty claims are handled by an Authorized Dealer or Distributor in the country of purchase.<br>
Please refer to the INTERNATIONAL section of the BGE website at BigGreenEgg.com to locate the Authorized BGE International Distributor in your particular region. Warranty claims must be made through an Authorized Dealer or Distributor within the original country of purchase.<br>
Do not ship or mail any components for a Warranty claim before contacting an Authorized Dealer or Distributor, as in some cases it may not be necessary to return the warranted part. Our goal is to make any Warranty claim as simple as possible. If&nbsp;further assistance is needed, please email&nbsp;<a href="mailto:warranty@BigGreenEgg.com" target="_blank" rel="noopener">Warranty@BigGreenEgg.com</a><br>
11. INFORMATION REQUIRED FOR CLAIM:&nbsp;A Valid Proof of Purchase is required. A purchase receipt showing date of purchase and name of Authorized Dealer from which the EGG or other BGE product was purchased must be provided with any Warranty claim. For Warranty purposes, an original purchaser is the person whose name appears on the purchase receipt, or is in possession of an original purchase receipt, and who has registered their BGE Warranty as required.<br>
12. SHIPPING AND DELIVERY:&nbsp;BGE is not liable for shipping, delivery charges, labor, packaging costs, export/import duties, VAT or any levied taxes resulting from any Warranty claim, service, repair or&nbsp;return,&nbsp;unless authorized in advance in writing by BGE.<br>
13. VOIDING THE WARRANTY:&nbsp;Any unauthorized modifications or alterations to an EGG will void the Warranty. This includes using any parts inside the EGG other than authentic BGE components; drilling holes or tampering with any of the parts; or using any internal components in any way other than as intended by the manufacturer. Modifying or substituting any internal components, including the fire grate and fire ring, will void the Warranty, and BGE expressly disclaims any liability for any direct, indirect, incidental or consequential damage which may result. The pouring of lighter fluids or any flammable mixture onto or into an EGG will void the Warranty. This practice is dangerous and may result in damage or injury. Please see Safety Tips at BigGreenEgg.com.<br>
14. DELAY OR DEFAULT:&nbsp;The Big Green Egg shall not be liable for any delay or default in BGE’s performance under the Warranty caused by any event or contingency beyond the control of BGE, including, without limitation, acts of God, war, government restrictions or restraints, strikes, fire, floods, transportation delays or reduced supply of materials.<br>
15. LIMITATIONS:&nbsp;This Limited Warranty is non-transferable. There are no other warranties, express or implied, except as specifically stated in this Warranty or as may be provided for under statutory rights which vary from state to state and country to country. The Big Green Egg does not authorize any person or representative to make or assume for BGE any obligation or liability in connection with the sale of any EGG or BGE product.<br>
Warranties, whether written, oral, expressed or implied, are not extended to persons who obtain the product from any source other than the Big Green Egg or from an Authorized Big Green Egg Distributor or Dealer, or through an authorized BGE promotion. Purchasing and/or accepting delivery of any BGE product from unauthorized dealers or online resellers will void the Warranty associated with that product. The Big Green Egg is not sold at discount clubs, discount chain stores, online or by e-commerce stores, and any product purchased from any such retailer is not covered under Warranty. Authorized Dealers can be located or verified at the BigGreenEgg.com website.<br>
16. BGE’s OBLIGATIONS:&nbsp;The repair or replacement of parts in the manner and for the period of time stipulated hereunder shall constitute the fulfillment of all Warranty obligations and/or any direct and derivative liabilities of the Big Green Egg. A purchaser’s exclusive remedy for any breach of this Warranty or of any other implied Warranty is limited as outlined herein to replacement or repair of the component, shipped to&nbsp;purchaser&nbsp;at purchaser’s expense.<br>
17. LIMITATIONS:&nbsp;TO THE MAXIMUM EXTENT ALLOWED BY LAW, ALL STATUTORY, EXPRESSED OR IMPLIED WARRANTIES, INCLUDING THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE, SHALL NOT EXTEND BEYOND THIS WARRANTY. LIABILITY FOR INCIDENTAL, SPECIAL AND CONSEQUENTIAL DAMAGES IS EXCLUDED.<br>
Some states and/or countries do not allow exclusion or limitation of incidental or consequential damages, so the above limitations or exclusions may not apply to you.<br>
18. REGISTER THE WARRANTY:&nbsp;Warranty registration is available at BigGreenEgg.com. Failure to register the EGG at BigGreenEgg.com, or to register your purchase by other means that may be made available by BGE, will invalidate your Warranty. If you require a printed form to mail in, please see any Authorized Dealer or Distributor. The Warranties as specified herein contain all your specific legal rights under the Big Green Egg Limited Lifetime Warranty. However, you may have other rights which vary from state to state and country to country.<br>
19. HEADINGS:&nbsp;The headings used in this Warranty are for convenience only, and shall not alter the terms of the Warranty.<br>
20.&nbsp;International Distributors of BGE products may provide translations of the Warranty or portions of the Warranty in other languages for convenience – however, only the English version is valid, and in the event of any dispute or questions about coverage, only the English version will be considered.<br>
21. Please see&nbsp;<a target="_blank" href="http://biggreenegg.com/safety-tips/">Safety Tips</a>&nbsp;and&nbsp;<a href="http://biggreenegg.com/first-timer-tips/">First Timer Tips</a>&nbsp;on this website if assembling or using an EGG for the first time.<br>
Thank you for choosing a Big Green Egg – we know you will enjoy The Ultimate Cooking Experience, and we are here along with our Authorized Dealer network to stand behind you with unmatched customer service and warranty support.<br>
The Big Green Egg Team</p>
<p>Effective March 2014.<br>
© COPYRIGHT. BIG GREEN EGG.<br>
ALL RIGHTS RESERVED.<br>
Big Green Egg®, EGG®, EGGcessories®, The Ultimate Cooking Experience®, EGGheads®, MiniMax™, Mates™,&nbsp;Nest™&nbsp;and convEGGtor™ are Trademarks or Registered Trademarks of the Big Green Egg Inc.</p>
</div>
HTML,

                ],
                'fire-magic' => [
                    'image' => 'FireMagic.jpg',
                    'label' => 'Fire Magic Grills Warranty',
                    'images' => [
                        [
                            'title' => 'Fire Magic Grills Warranty',
                            'url' => 'Fire-Magic-Warranty_1.jpg',
                        ],
                    ],
                ],
                'summerset' => [
                    'image' => 'Summerset.jpg',
                    'label' => 'Summerset Grills Warranty',
                    'images' => [
                        [
                            'title' => 'Summerset Grills Warranty',
                            'url' => 'Summerset-Grills.jpg',
                        ],
                    ],
                ],
            ],
        ],
        'fire-features' => [
            'label' => 'Fire Features',
            'items' => [
                'tempest-torch' => [
                    'image' => 'tempest-torch.jpg',
                    'label' => 'Tempest Torch Warranty',
                    'images' => [
                        [
                            'title' => 'Tempest Torch Warranty',
                            'url' => 'Tempest-Torch-Warranty_06232017-scaled.jpg',
                        ],
                    ],
                ],
                'fire-gear' => [
                    'image' => 'FireGear.jpg',
                    'label' => 'Fire Gear Outdoors Warranty',
                    'images' => [
                        [
                            'title' => 'Fire Gear Outdoors Warranty',
                            'url' => '2020-Warranty_Page_1-scaled.jpg',
                        ],
                    ],
                ],
                'real-fyre' => [
                    'image' => 'realfyre.jpg',
                    'label' => 'ReadFyre Premium Gas Logs Warranty',
                    'images' => [],
                ],
            ],
        ],
        'outdoor-kitchens' => [
            'label' => 'Outdoor Kitchens',
            'items' => [
                'werever-outdoor-cabinets' => [
                    'image' => 'werever.jpg',
                    'label' => 'Werever Outdoor Cabinets Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose"><h3>Limited Lifetime Manufacturers Residential Warranty</h3>
<p>Werever Products, Inc.&nbsp;will repair or replace cabinetry which proves to be defective in material or workmanship under normal residential use for the lifetime of the original purchaser.</p>
<p>This warranty is not transferable and is expressly limited to the cabinet carcass, base, doors, drawers, shelves, and&nbsp;high density polyethylene (HDPE) drawer slides.</p>
<p>Items not specifically listed in this warranty are not covered by this warranty. No other warranty, express or implied, is applicable to this product. Separate components not manufactured by Werever Products such as grills, refrigerators, countertops, casters, stainless steel drawer slides, and accessories may be covered by a separate manufacturer’s warranty, but are not covered by this Limited Lifetime Manufacturers Residential Warranty.</p>
<p>Werever Products shall not be liable for the loss of use of the product, inconvenience, loss or any other damages, direct or consequential, arising out of the use of or inability to use this product.</p>
<p>This warranty does not apply to cabinets that have been misused, modified, or improperly installed. This warranty does not apply to the natural aging of the finish. This warranty applies only to defects and does not apply to natural aging or wear and tear.</p>
<p>The above warranty is limited to the repair or replacement of the defective part at the discretion of Werever Products, Inc. and does not include labor, shipping, or service trip expenses necessary for removal, inspection, delivery, or replacement of defective parts. Parts replaced or repaired under this warranty are not guaranteed for color match. Defective cabinet parts are subject to a one time replacement or repair. Components and products not manufactured by Werever will carry the warranty of the original manufacturer and are subject to availability from our supplier.</p>
<p>This warranty does not apply to sliding-door outdoor tv cabinets, which&nbsp;are covered by a separate warranty. Piano-hinged tv cabinets are limited to a three (3) year warranty period.</p>
<p>Movable carts including the Big Green Egg cabinet line are limited to a three (3) year warranty period.</p>
<p>To obtain warranty coverage: Retain your bill of sale and copy of this warranty statement to prove original purchase and warranty terms in effect at the date of your sale. A copy of the sales receipt must be submitted at the time warranty service is requested. Defective parts must be returned to Werever before a warranty claim can be processed. Warranty requests must be accompanied by photographs of the cabinetry as installed to document the defect. Warranty requests will not be processed without proof of purchase and proper documentation.</p>
</div>
HTML,

                ],
            ],
        ],
        'pavers-and-walls' => [
            'label' => 'Pavers And Walls',
            'items' => [
                'tremron' => [
                    'image' => 'TremronLogo.jpg',
                    'label' => 'Tremron Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose"><p>Tremron Group's interlocking concrete pavers and retaining walls meet or exceed the requirements of ASTM C-936 and ASTM C-1372. Tremron Group warrants the structural integrity of its products for 25 years from the date of installation. This warranty does not apply to splitting, chipping, spalling or other breakage that may be caused by impact, abrasion or improper use. Efflorescence may occur and is not covered by this warranty. This warranty is only valid if the material is installed in accordance with the guidelines of the ICPI(www.icpi.org) or the NCMA(www.ncma.org). This warranty is for residential construction only and does not imply a warranty for commercial applications. Tremron Group's obligation is limited to providing replacement material at no charge. Tremron Group will not be responsible for any replacement labor or freight. The original proof of purchase is required. Color matching is not guaranteed.</p>
<p>Due to the variances in the printing process, all product and color appearances may be different than as displayed in this website or brochure as well as may vary in appearance from one brochure to another. Tremron Group makes no claim or warranty as to actual product or product color appearance in comparison to what is displayed in this website or brochure. Products and product colors naturally vary from plant to plant as well as from one production run to another. Please visit your local Tremron Design Center for product samples.</p>
</div>
HTML,

                ],
                'belgard' => [
                    'image' => 'Belgard.jpg',
                    'label' => 'Belgard Warranty',
                    'images' => [],
                    'text' => <<<'HTML'
<div class="prose">
    <p>As the largest provider of hardscape products in North America, we proudly stand behind our products with a Belgard lifetime transferable limited warranty.</p>
    <p>Our commitment to manufacturing the highest quality interlocking concrete pavers and retaining walls on the market extends to your customer, the homeowner. Once installed by an authorized Belgard Contractor, your hardscape products are covered under Belgard’s paver warranty for as long as they own their home and can be transferred should they sell the home at any time.</p>
    <p>Please encourage your customers to register their Belgard warranties with us to maximize their Belgard experience, and stay up to date on product care and maintenance. They can access the online warranty registration at&nbsp;
        <a target="_blank" href="http://pages.oldcastlebrands.com/warranty/step-1/">belgard.com/warranty</a>
    </p>
    <p>You can obtain Belgard Warranty Cards to provide to your customers from your local Belgard Sales Representative.</p>
<h3>BELGARD HARDSCAPES LIFETIME TRANSFERABLE LIMITED WARRANTY</h3>
<p>Oldcastle Architectural, Inc. ("Belgard") is proud to inform you that all of our interlocking concrete paver and retaining walls ("Products") meet and/or exceed the requirements of ASTM C-936 and ASTM C-1372. Belgard guarantees its Products against these standards for the lifetime of the Product defined by ICPI. This guarantee does not apply to splitting, chipping or other breakage that could be caused by impact, abrasion or overloading. This warranty is transferable. The original proof of purchase is required.</p>
<p>This warranty is only valid if the material is installed under the guidelines of the ICPI (<a href="http://www.icpi.org/">www.ICPI.org</a>), The NCMA (<a target="_blank" href="http://www.ncma.org/">www.ncma.org</a>) or the Belgard Installation Guideline Manual. Improper installation voids this warranty. This warranty is for residential applications only and does not apply to commercial applications. It is recommended that the job is installed by a Belgard Authorized Contractor who guarantees their workmanship for a minimum of 2 years from the date of install.</p>
<p>For warranty service, contact Belgard at 1-800-BELGARD. A service representative will investigate your claim within 10 business days. If the Belgard Product fails to meet the specifications, Belgard will replace the defective product at no charge. Color matching cannot be guaranteed. Belgard will not be responsible for any replacement labor, consequential damages or incidental damages. THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS, AND YOU MAY ALSO HAVE OTHER RIGHTS WHICH VARY FROM STATE TO STATE. SOME STATES DO NOT ALLOW FOR THE EXCLUSION OR LIMITATION OF INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU.</p>
</div>
HTML,

                ],
            ],
        ],
    ];

    public $warranties = [

        'vinyl' => [
            'image' => 'pvcwarranty.jpg',
            'label' => 'Vinyl (PVC) Fence Warranties',
            'warranties' => [
                [
                    'title' => 'BGM PVC/Vinyl Fence',
                    'pdf' => 'BGM.pdf',
                ],
                [
                    'title' => 'CEF PVC/Vinyl Fence',
                    'pdf' => '',
                ],
                [
                    'title' => 'Country Manor Products',
                    'pdf' => '',
                ],
            ],
        ],

    ];

    public $show_modal = false;

    public $label;

    public $image;

    public $warranty = [];

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function showModal($key)
    {
        foreach ($this->warranties as $warranties) {
            foreach ($warranties as $ke => $warranty) {
                if ($ke == 'items') {
                    foreach ($warranty as $k => $war) {
                        if ($k == $key) {
                            $this->warranty = $war;
                            $this->show_modal = true;

                            return;
                        }
                    }
                }
            }
        }
    }

    public function hideModal()
    {
        $this->show_modal = false;
    }

    public function render()
    {
        return view('livewire.product-warranties');
    }
}
