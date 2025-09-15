# Danielle Fence & Outdoor Living

## Product Management System Architecture

### Hierarchical Product Structure

#### 1. ProductCategory (Hierarchical)
- Can contain other **ProductCategories** (nested categories - unlimited depth)
- Can contain **Products** (leaf items)
- Examples:
  ```
  Fence & Gates (Root Category)
  ├── Residential Fencing (Subcategory)
  │   ├── Vinyl Privacy Fence (Product)
  │   └── Wood Privacy Fence (Product)
  ├── Commercial Fencing (Subcategory)
  └── Pool Fencing (Subcategory)
  ```

#### 2. Product
- Belongs to a **ProductCategory**
- Has a **base_price** (starting price before modifiers)
- Has many-to-many relationships with:
  - **Colors** (available color options)
  - **Heights** (available height options)
  - **Spacings** (available spacing options)

#### 3. Attribute Models with Price Modifiers

**Color Model:**
- `name` - Color name (e.g., "Arctic White", "Saddle Tan")
- `slug` - URL-friendly identifier
- `hex_code` - Color hex value for display
- `color_swatch_image` - **Dedicated image showing just the color swatch**
- `modifier_type` - Price modification type:
  - `add_percent` - Add percentage to base price
  - `subtract_percent` - Subtract percentage from base price
  - `add_value` - Add fixed dollar amount
  - `subtract_value` - Subtract fixed dollar amount
- `modifier_amount` - Numeric value for the modifier

**Height Model:**
- `name` - Height name (e.g., "6 Foot", "8 Foot")
- `value` - Numeric height value
- `unit` - Measurement unit (ft, inches, etc.)
- `modifier_type` & `modifier_amount` - Same pricing logic as Color

**Spacing Model:**
- `name` - Spacing name (e.g., "Standard 4 inch", "Wide 6 inch")
- `value` - Numeric spacing value
- `unit` - Measurement unit
- `modifier_type` & `modifier_amount` - Same pricing logic as Color

#### 4. Product Variants & Combinations

Each unique combination of **Color + Height + Spacing** creates a product variant with:

**Pricing Calculation:**
```
Final Price = base_price + color_modifier + height_modifier + spacing_modifier
```

**Example:**
```
Vinyl Privacy Fence: $100.00 base price
├── Arctic White: +10% ($10.00)
├── 6 Foot Height: +$15.00
├── 4 inch Spacing: +5% ($5.00)
└── Final Price: $100 + $10 + $15 + $5 = $130.00
```

**Product Images:**
- **Color Swatch Images**: Pure color samples for UI display, color selection, etc.
- **Product Combination Photos**: Actual product photos showing specific color/height/spacing
- **Default Product Photo**: Fallback when no specific combination photo exists

#### 5. Backend Management Features

**Category Management:**
- Hierarchical category tree with drag & drop
- Active/inactive status
- Sort ordering

**Product Management:**
- Assign to categories
- Set base pricing
- Select available colors, heights, spacings
- Upload combination-specific photos

**Attribute Management:**
- Manage Colors, Heights, Spacings as separate entities
- Set pricing modifiers for each attribute
- Upload color swatch images
- Backend interfaces for all attribute types

**Photo Management:**
- Upload photos for specific Color+Height+Spacing combinations
- Automatic fallback to default photos
- Color swatch management separate from product photos

This architecture provides maximum flexibility for pricing and product variations while maintaining a clean, manageable backend system.