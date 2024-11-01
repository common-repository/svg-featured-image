=== SVG Featured Image ===
Contributors: n1rus
Donate link: http://nirus.io
Tags: plugin, opengraph, facebook, twitter, featuredimage, svg, thumbnail, generator
Requires at least: 5.1
Tested up to: 5.2
Requires PHP: 7.2
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin helps Wordpress sites to use SVG images as the featured image which can be shared on Facebook or Twitter with the SVG preview image in the post.

This plugin creates a `<meta>` tags for Facebook and Twitter sharing purpose, which enables the SVG images to be set as a preview images for post shared on these social networks.

`
    <meta name="twitter:image" content="http://example.com/wp-content/uploads/svg-png/sample.png">
    <meta property="og:image" content="http://example.com/wp-content/uploads/svg-png/sample.png">
`
This plugin uses PHP ImageMagick to create thumbnails for your social shares, so please make sure this extension is available.

We recommend [Safe SVG plugin](https://wordpress.org/plugins/safe-svg/) to enable SVG/XML mime type on your Wordpress site.

== Screenshots ==
banner-1544x500.png

== Changelog ==

= 0.2 =
* Logo support is added.

= 0.1 =
* Converts the SVG to PNG for all post & pages.


== Frequently Asked Questions ==
