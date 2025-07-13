# Promo Banner - PrestaShop Module

A powerful and customizable promotional banner module for PrestaShop that helps you create eye-catching announcements, promotions, and call-to-action banners on your online store.

## 🚀 Features

### ✨ Core Features
- **Responsive Design** - Automatically adapts to all screen sizes
- **Flexible Positioning** - Choose between floating or fixed positioning
- **Rich Customization** - Extensive styling and layout options
- **Dynamic Content** - Support for product placeholders and stock information
- **Countdown Timer** - Built-in countdown component for time-sensitive promotions
- **Mobile Optimized** - Enhanced mobile experience with responsive controls

### 🎨 Appearance Options
- **Background Types**: Solid colors or gradient backgrounds
- **Text Styling**: Customizable title and subtitle with color controls
- **Image Support**: Add promotional images with flexible positioning
- **Button Customization**: Full control over CTA button appearance
- **Border Radius**: Adjustable corner rounding for modern designs

### 📍 Positioning & Layout
- **Fixed Banners**: Top or bottom page positioning
- **Floating Banners**: Corner positioning (top-left, top-right, bottom-left, bottom-right)
- **Auto-sizing**: Automatic width and height adjustment options
- **Responsive Behavior**: Smart mobile positioning and sizing

### ⏰ Advanced Features
- **Countdown Timer**: Set end dates for time-sensitive promotions
- **Stock Integration**: Display real-time product stock information
- **Dynamic Placeholders**: Use `{{stock}}`, `{{product_name}}`, `{{product_image_1}}` etc.
- **Cookie Management**: Remembers when users close banners
- **Display Controls**: Show on homepage only or all pages

## 📋 Requirements

- PrestaShop 1.7.x or higher
- PHP 7.1 or higher
- Modern web browser support

## 🔧 Installation

### Method 1: Manual Installation
1. Download the module files
2. Upload the `promobanner` folder to your PrestaShop `/modules/` directory
3. Go to **Modules > Module Manager** in your PrestaShop back office
4. Search for "Promo Banner" and click **Install**

### Method 2: ZIP Installation
1. Create a ZIP file of the `promobanner` folder
2. Go to **Modules > Module Manager** in your back office
3. Click **Upload a module** and select your ZIP file
4. Click **Install**

## ⚙️ Configuration

### Basic Setup
1. Navigate to **Modules > Module Manager**
2. Find "Promo Banner" and click **Configure**
3. Enable the banner using the **Enable Banner** toggle
4. Choose your **Display Mode** (Homepage only or All pages)

### Content Configuration
```
Banner Title: Your main promotional message
Banner Subtitle: Additional details or description
Banner Image: URL to promotional image or use {{product_image_1}}
Stock Product: Select product for dynamic stock display
```

### Appearance Settings
```
Background Type: Solid or Gradient
Background Color: Choose your brand colors
Text Alignment: Left, Center, or Right
Font Sizes: Customize title and subtitle sizes
Border Radius: Set corner rounding (0px = square, higher = rounded)
```

### Positioning Options
```
Behavior: Floating or Fixed
Position: 
  - Fixed: Top or Bottom
  - Floating: Top-left, Top-right, Bottom-left, Bottom-right
Width/Height: Auto-sizing or custom dimensions
Padding: Control internal spacing
```

### CTA Button Setup
```
Show CTA: Enable/disable call-to-action button
CTA Text: Button text content
Colors: Background and text colors
Sizing: Padding and border radius
Position: Top, Bottom, Left, or Right relative to content
Full Width: Make button span full width
Link URL: Destination URL for the button
```

### Countdown Timer
```
Enable Countdown: Show/hide countdown component
End Date: Set the countdown target date
Full Width: Make countdown span full width
```

## 🔗 Dynamic Placeholders

The module supports dynamic content placeholders:

### Available Placeholders
- `{{stock}}` - Current stock quantity of selected product
- `{{product_name}}` - Name of selected product
- `{{product_image_1}}` - First image of selected product
- `{{product_image_2}}` - Second image of selected product
- `{{product_image_3}}` - Third image of selected product

### Example Usage
```
Title: "Only {{stock}} {{product_name}} left in stock!"
Subtitle: "Don't miss out on this amazing deal"
Image URL: "{{product_image_1}}"
```

## 📱 Mobile Responsiveness

The module automatically handles mobile responsiveness:

- **Floating banners** become fixed bottom banners on mobile
- **Font sizes** automatically scale down 20% on mobile devices
- **CTA buttons** become full-width on small screens
- **Images** center-align and wrap on mobile layouts
- **Border radius** removes on mobile for edge-to-edge appearance

## 🎯 Use Cases

### Flash Sales
```
Title: "⚡ FLASH SALE - 50% OFF!"
Subtitle: "Limited time offer on selected items"
Countdown: Set to sale end time
CTA: "Shop Now"
Position: Top fixed banner
```

### Stock Alerts
```
Title: "Only {{stock}} left in stock!"
Subtitle: "{{product_name}} - Don't miss out!"
Image: "{{product_image_1}}"
Position: Floating bottom-right
```

### Newsletter Signup
```
Title: "Get 10% OFF your first order"
Subtitle: "Subscribe to our newsletter"
CTA: "Subscribe Now"
Position: Floating top-right
```

### Free Shipping
```
Title: "🚚 FREE SHIPPING"
Subtitle: "On orders over $50"
Position: Top fixed banner
Background: Gradient
```

## 🔄 Cookie Management

The module automatically manages user interactions:

- When users close a banner, a cookie is set to remember their choice
- For countdown banners, the cookie expires when the countdown ends
- For regular banners, the cookie expires after 24 hours
- This prevents annoying repeat displays while respecting user preferences

## 🎨 Styling Integration

The module includes comprehensive CSS classes for custom styling:

### Main Classes
```css
.promo-banner          /* Main banner container */
.promo-floating        /* Floating banner modifier */
.promo-top            /* Top positioned banner */
.promo-bottom         /* Bottom positioned banner */
.cta-button           /* Call-to-action button */
.banner-countdown     /* Countdown timer component */
.promo-close          /* Close button */
```

### Responsive Classes
The module automatically applies responsive styles for optimal mobile display.

## 🐛 Troubleshooting

### Banner Not Showing
1. Check if the banner is enabled in module configuration
2. Verify the display mode matches your current page
3. Clear PrestaShop cache and browser cache
4. Check if banner was previously closed (clear cookies)

### Mobile Display Issues
1. Ensure your theme doesn't override module CSS
2. Check for JavaScript conflicts in browser console
3. Verify the main container selector exists in your theme

### Countdown Not Working
1. Verify the end date format is correct
2. Check browser console for JavaScript errors
3. Ensure the date is in the future

## 📞 Support

For support and bug reports:
1. Check the troubleshooting section above
2. Verify your PrestaShop and PHP versions meet requirements
3. Test with default theme to isolate theme conflicts
4. Check browser console for JavaScript errors

## 📄 License

This module is provided as-is for educational and commercial use. Please respect the terms of use and ensure compatibility with your specific PrestaShop installation.

## 👨‍💼 Contributors

<table>
  <tbody>
    <tr>
      <td align="center"><a href="https://jamalidaissa.vercel.app"><img src="https://avatars.githubusercontent.com/u/69154853?v=4" width="100px;" alt="Jamal Id Aissa"/><br /><sub><b>Jamal Id Aissa</b></sub></a><br /></td>
    </tr>
  </tbody>
</table>
