=== Headit ===
Contributors: StampyCode
Donate link: https://stampy.me
Tags: http header, headers, csp, xss, csrf, hsts, hpkp
Stable tag: 1.0.3
Requires at least: 4.0
Tested up to: 4.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Headit is a simple plugin to allow you to add custom HTTP response headers to your site.

== Description ==

This plugin addresses the need for a simple way to add HTTP headers to outbound HTTP responses in your site.

These headers can include custom ones specific to your application, or can be security related. Some you may wish to specify to protect your site may include:

*  Public-Key-Pins
*  Strict-Transport-Security
*  X-Frame-Options
*  X-XSS-Protection
*  X-Content-Type-Options
*  Content-Security-Policy
*  Content-Security-Policy-Report-Only

== Related Links ==

* [Troy Hunt - Introducing you to browser security headers on Pluralsight](http://www.troyhunt.com/2015/09/introducing-you-to-browser-security.html)
* [PluralSight.com - Introduction to Browser Security Headers](https://app.pluralsight.com/library/courses/browser-security-headers)
* [OWASP - List of useful HTTP headers](https://www.owasp.org/index.php/List_of_useful_HTTP_headers)
* [Scott Helme - Hardening your HTTP response headers](https://scotthelme.co.uk/hardening-your-http-response-headers/)

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/headit` directory, or install the plugin through the WordPress plugins screen directly
1. Activate the plugin through the `Plugins` screen in WordPress
1. Use the Settings->Headit screen to configure the plugin

== Frequently Asked Questions ==

= Can I set dynamic headers using Headit? =

Currently Headit can only be used to add static headers to your site.

= Can I override existing headers? =

All headers added using this plugin will not replace existing headers present in the response.

== Changelog ==

= 1.0 =
* Able to set custom static response headers

== Screenshots ==

1. The plugin should appear in your plugins list when installed. Note the 'Settings' link where you can configure for Headit.
2. This is the settings window for Headit.

