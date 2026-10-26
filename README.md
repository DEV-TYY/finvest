# Futuristic IT WordPress Theme

A modern WordPress theme designed for IT and healthcare solutions companies with a dark green color scheme, matching the design specifications.

## Features

- **Dark Green Color Scheme**: Professional and modern design with dark green (#1a4d2e) as the primary color
- **Custom Post Types**: Services, Products, Team Members, and Partners
- **Responsive Design**: Mobile-friendly layout that works on all devices
- **Multiple Page Templates**: Home, About Us, Services, Contact Us, Product Archive, and Single Product pages
- **Interactive Elements**: FAQ accordion, product image gallery, smooth scrolling
- **Custom Meta Fields**: Product prices, features, service icons, team roles
- **Navigation Menu**: Primary navigation with custom menu support

## Theme Structure

```
futuristict-theme/
├── style.css              # Main stylesheet with all CSS
├── functions.php          # Theme functions and custom post types
├── index.php              # Default index template
├── header.php             # Header with navigation
├── footer.php             # Footer with links
├── front-page.php         # Home page template
├── page-about.php         # About Us page template
├── page-services.php     # Services page template
├── page-contact.php       # Contact Us page template
├── single-product.php    # Single product page template
├── archive-product.php   # Product archive template
├── js/
│   └── main.js           # JavaScript functionality
└── README.md             # This file
```

## Installation

### 1. Install the Theme

1. Copy the entire `futuristict-theme` folder to your WordPress installation:
   ```
   wp-content/themes/futuristict-theme/
   ```

2. Log in to your WordPress admin dashboard
3. Go to **Appearance > Themes**
4. Find "Futuristic IT Theme" in the list
5. Click **Activate**

### 2. Configure Permalinks

1. Go to **Settings > Permalinks**
2. Select "Post name" or any structure other than "Plain"
3. Click **Save Changes**

This is necessary for custom post types to work correctly.

### 3. Create Navigation Menu

1. Go to **Appearance > Menus**
2. Create a new menu named "Primary Menu"
3. Add the following pages to the menu:
   - Home
   - About Us
   - Services
   - Products (custom link: /products/)
   - Contact Us
4. Check "Primary Menu" in "Menu Settings"
5. Create a second menu named "Footer Menu"
6. Add pages to the footer menu (Home, About, Services, Products, Contact)
7. Check "Footer Menu" in "Menu Settings"
8. Click **Save Menu**

### 4. Set Front Page

1. Go to **Settings > Reading**
2. Under "Your homepage displays", select "A static page"
3. For "Homepage", select the "Home" page
4. Click **Save Changes**

### 5. Configure Site Content

All text content across the site is managed through the WordPress admin:

1. Go to **Site Content** in the admin menu
2. Edit any text field for the Homepage, Contact, Services, About, Header, or Footer
3. Click **Save Changes**

The theme uses dynamic options for all text content - no hardcoded text remains in the templates.

## Custom Post Types

### Services

- Go to **Services > Add New** to create services
- Each service has:
  - Title
  - Description
  - Excerpt (shown in cards)
  - Icon (emoji or character)
  - Featured image

### Products

- Go to **Products > Add New** to create products
- Each product has:
  - Title
  - Description
  - Excerpt (shown in cards)
  - Price
  - Features (one per line)
  - Featured image
  - Product category

### Team Members

- Go to **Team > Add New** to create team member profiles
- Each team member has:
  - Name
  - Bio
  - Role/Position
  - Featured image (photo)

### Partners

- Go to **Partners > Add New** to add partner logos
- Each partner has:
  - Name
  - Featured image (logo)

## Page Templates

### Front Page (front-page.php)

Displays:
- Hero section with call-to-action
- Services grid (6 services)
- Products grid (4 products)
- Partners section
- CTA section

### About Us (page-about.php)

Displays:
- Hero section
- Mission, Vision, Values
- Team members grid
- FAQ accordion

### Services (page-services.php)

Displays:
- Hero section
- All services in a grid
- CTA section

### Contact Us (page-contact.php)

Displays:
- Hero section
- Contact information
- Contact form
- Map placeholder

### Single Product (single-product.php)

Displays:
- Hero section
- Product image gallery
- Product details
- Price and features
- Related products

### Product Archive (archive-product.php)

Displays:
- Hero section
- All products in a grid
- Pagination

## Customization

### Colors

You can customize the color scheme by editing the CSS variables in `style.css`:

```css
:root {
    --primary-green: #1a4d2e;
    --dark-green: #0d2818;
    --light-green: #2d6a4f;
    --accent-yellow: #f4d03f;
    --accent-orange: #e67e22;
    /* ... more variables */
}
```

### Logo

To add a custom logo:

1. Go to **Appearance > Customize**
2. Click **Site Identity**
3. Upload your logo
4. Click **Publish**

### Contact Form

The theme includes a basic contact form. For advanced form functionality:

1. Install the Contact Form 7 plugin
2. Create a form with ID "1"
3. The theme will automatically use it

Alternatively, you can use any other contact form plugin and update the shortcode in `page-contact.php`.

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## Support

For issues or questions:

1. Check the WordPress Codex for theme development
2. Review the template files for customization examples
3. Ensure permalinks are configured correctly

## License

This theme is licensed under the GNU General Public License v2 or later.

## Credits

- Designed based on modern IT/healthcare website patterns
- Built with WordPress best practices
- Responsive design with mobile-first approach
