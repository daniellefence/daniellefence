#!/bin/bash

# Create remaining page views from template
cd ~/Herd/daniellefence/resources/views/pages

pages=(
    "showroom"
    "product-warranties"
    "why-danielle-fence"
    "acceptable-use"
    "cookie-policy"
    "terms"
    "returns"
    "disclaimer"
    "fire-feature-catalogs"
    "mascots"
    "search"
)

for page in "${pages[@]}"
do
    cp template.blade.php "$page.blade.php"
    echo "Created $page.blade.php"
done

echo "All page views created!"
