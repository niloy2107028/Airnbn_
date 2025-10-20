# CSS Structure Documentation

## Overview

The CSS files have been reorganized into modular files for better maintainability and easier future modifications.

## File Structure

### 1. **common.css** (Required on all pages)

Contains shared styles used across all pages:

-   Body and container styles
-   Footer styles
-   Navigation styles
-   Common responsive breakpoints

**Used in:** All pages

---

### 2. **index.css** (Listings grid view)

Styles specific to the listings index/grid page:

-   Listing card styles
-   Card hover effects
-   Grid layout styles

**Used in:**

-   `listings/index.blade.php`

---

### 3. **show.css** (Individual listing detail)

Styles for individual listing detail pages:

-   Show page card styles
-   Map container styles
-   Detail view specific styles

**Used in:**

-   `listings/show.blade.php`

---

### 4. **forms.css** (Forms and inputs)

Styles for form pages:

-   Login form
-   Signup form
-   Create listing form
-   Edit listing form
-   Image preview styles
-   Button styles

**Used in:**

-   `auth/login.blade.php`
-   `auth/signup.blade.php`
-   `listings/create.blade.php`
-   `listings/edit.blade.php`

---

### 5. **bookings.css** (Booking pages)

Styles for booking-related pages:

-   My bookings page
-   Host dashboard
-   Booking details
-   Booking status indicators

**Used in:**

-   `bookings/my-bookings.blade.php`
-   `bookings/host-dashboard.blade.php`
-   `bookings/show.blade.php`
-   `bookings/create.blade.php`

---

### 6. **style.css** (Main import file - DEPRECATED)

**Note:** This file currently exists for backwards compatibility.
You should update your layouts to import individual CSS files as needed.

---

## How to Use

### Option 1: Import All (Current approach)

Keep using `style.css` in your layout - it imports all CSS files:

```html
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
```

### Option 2: Import Only What You Need (Recommended)

Import only the CSS files needed for each page:

**Example for Index Page:**

```html
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
```

**Example for Show Page:**

```html
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
```

**Example for Login Page:**

```html
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/forms.css') }}" />
```

---

## Advantages

1. **Better Organization** - Easy to find styles for specific pages
2. **Easier Maintenance** - Modify styles for one page without affecting others
3. **Performance** - Load only CSS needed for each page (if using Option 2)
4. **Scalability** - Easy to add new page-specific styles
5. **Team Collaboration** - Multiple developers can work on different files

---

## Migration Steps

To fully migrate to the new structure:

1. Update `resources/views/layouts/app.blade.php` to import common.css
2. Create page-specific layout sections that import page-specific CSS
3. Test each page to ensure styling remains unchanged
4. Remove old style.css once migration is complete

---

## Future Enhancements

You can add more specialized CSS files as needed:

-   `dashboard.css` - Admin/dashboard styles
-   `profile.css` - User profile page styles
-   `search.css` - Advanced search page styles
-   `animations.css` - Custom animations
-   `utilities.css` - Utility classes

---

## Notes

-   All original styles have been preserved
-   No visual changes should occur
-   `common.css` must be included on all pages
-   Responsive breakpoints are maintained in each file
