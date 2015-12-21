=== Genesis Staff Bio Grid ===
Contributors: jonschr
Donate link: http://redblue.us/
Tags: staff, bio, company, officers, lightbox, thickbox, genesis
Requires at least: 3.8
Tested up to: 3.9.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin creates a simple, intuitive way to list your staff with featured images and to display their bio in a lightbox. For Genesis sites only.

== Description ==

This plugin should only be used on Genesis sites (on non-Genesis sites, it won't break anything, but it also won't do anything at all other than setting up the post type).

**Credit:** [Sridhar Katakam](http://wordpress.org/support/profile/srikat) for the [staff custom post type tutorial](http://sridharkatakam.com/staff-grid-genesis-clickable-featured-images-opening-excerpts-lightbox-popup) on which this plugin is based.

If you take a look at the tutorial above, you'll see the basics of what this plugin does. In addition to setting up the staff-member post type and staff-position taxonomy, this plugin automatically sets up a thickbox lightbox which lets you show content about each staff member in a popup when the featured image is clicked.

== Installation ==

1. Use the Genesis framework. *If you aren't using a Genesis child theme, this plugin will not work with your site.*
1. Unzip the plugin and upload the folder to the '/wp-content/plugins/'' directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. That's it! There aren't currently any options to configure.

== Frequently Asked Questions ==

If you're needing more information, here's [full documentation](http://redblue.us/genesis-staff-bio-grid/)

= Where's my staff page? =
You can either use the [staff] shortcode ([more info on that](http://redblue.us/genesis-staff-bio-grid/shortcode-implementation/)), or, if you'd like to use the defaults, the archive is located at http://yoursite.com/staff

= So how does this work? =

This plugin creates a custom post type called staff-member and a taxonomy to go along with it called staff-position. It gives you built-in templates for both (these templates are part of the plugin), and a future version of the plugin will allow you to create your own replacement templates if you'd like them to do something other than the defaults.

= Does this plugin have a settings page or anything that needs to be set up before using it? =
Not at the moment, though there are some shortcode attributes that can help you customize things.

Features planned:
* An options page to allow for customization of the archive and single templates – allowing the featured image to be removed from the single template, allowing for customization

== Changelog ==

= Version 1.0.4 =
* Fixed a bug where two different lightbox sizes were being generated depending on the link clicked.

= Version 1.0.3 =
* Added beta support for nested shortcodes (within the lightboxes)
* Cleaned up styles for the edit this link
* Added phone number, facebook, twitter, and email links as post meta
* Added the CMB post meta framework

= Version 1.0.1 and 1.0.2 =
* Bugfixes
* Fallback image provided for both implementations if no featured image is present

= Version 1.0 =
* Shortcode implementation
* Documentation added

= Version 0.0.2 =
* Added div with page class to the archive template to avoid issues on sites with dark backgrounds
* Repositioned single template to put image on the right
* Issues with image sizing fixed
* Default styles added to avoid a negative margin issue with images

= Version 0.0.1 =
* Initial commit
