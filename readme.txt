=== Byte\'s PHP Code Widget ===
Contributors: ByteEnable
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5DYVPBJDMF9TE
Tags: php, widget, plugin, execute, eval
Donate link:
Requires at least: 3.4
Tested up to: 3.7.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mix HTML and PHP in a widget with mobile support.

== Description ==
This is a widget plugin that allow's you to mix PHP and html code with mobile
support.  Two text area's are provided.  The first is the standard "Title".
The one named "Code:" can mix PHP and html.  Two checkboxes allow you to choose
before and/or after posts.  No limit on the number of widgets.

Wordpress version 3.4 and higher has defined wp_is_mobile().  This can be used inside 
your code mix to perform certain actions if the browser is mobile.  Mobile
support is via wp_is_mobile() function which returns true if on a mobile
browser.  See the Wordpress API for more information.

A variable has been defined for use with Google Mobile Adsense:

$myMobileAdsenseCode

This widget requires some knowledge of PHP and HTML coding.  Misuse could crash
your site or cause errors with Adsense.

Examples:

<div><?php $i=5;echo $i;?></div>

Output:
5

To use Google mobile adsense include the following in the "Code:" area:

<?php if ( wp_is_mobile() $myMobileAdsenseCode="ca-mb-pub-xxxxxxxxxxxxxxxx";?>

The plugin will take care of the rest.  Another check is made to ensure
that wp_is_mobile is true inside the plugin and that the Google Adsense variable
has a value.

You can combine both regular and mobile adsense.  Be careful.

The following snippet will either show mobile or regular ads depending on the
browswer used:

<?php if ( wp_is_mobile() { $myMobileAdsenseCode="ca-mb-pub-xxxxxxxxxxxxxxxx";}
else { $myGoogleAdsenseCode = '<script async
src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- side-top-right -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-xxxxxxxxxxxxxxx"
     data-ad-slot="zzzzzzzz"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';}

Ordered list:

1. Support for the mixing of PHP and HTML
2. Support for mobile browsers
3. Support for Google Adsense including mobilie
4. Includes "before post" support
5. Includes "after post" support
6. No limit on the number of widgets
7. Includes dynamic title support in sidebars

Unordered list:

* Support for the mixing of PHP and HTML
* Support for mobile browsers
* Support for Google adsense including mobile
* Includes support for "before post"
* Includes support for "after post"
* No limit on the number of widgets
* Include dynamic title support in sidebars

Link to [WordPress](http://wordpress.org/ \"Your favorite software\") and one to [Markdown\'s Syntax Documentation][markdown syntax].


== Installation ==
1. Extract bytes-php-code.zip to the \"/wp-content/plugins/\" directory.
2. Activate the plugin through the \"Plugins\" menu in WordPress.
3. Navigate to the widget\'s page to drag n drop a widget for use.

== Frequently Asked Questions ==


== Screenshots ==
1. The screenshot description corresponds to screenshot-1.jpg.

== Changelog ==

= 0.1 =
* Initial release.

== Upgrade Notice ==

= 0.1 =
* Initial release.
