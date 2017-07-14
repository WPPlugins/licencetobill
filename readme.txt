=== LicenceToBill for Wordpress ===

Contributors: LicenceToBill
Tags: subscription, recurring billing, subscription billing, licencetobill
Requires at least: 3.2.1
Tested up to: 3.9.2
Stable tag: 2.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The LicenceToBill plugin allows you to sell by subscription the access to your pages, articles, content, video, text published on your website by subscription
LicenceToBill manages offers, subscriptions, payment and billing.


== Description ==

LicenceToBill's official plugin for WordPress will:

* Create an "Options" page to manage your LicenceToBill settings; 
* Enable LicenceToBill's Plugin like you would do for any other Wordpress plugin. Enter your LicenceToBill credentials and refer to the FAQs for any other information. 

== Installation ==

1. Log in as administrator in Wordpress.
2. Go to Extensions > Add and send `licencetobill-for-wordpress.zip`.
3. Activate the LicenceToBill extension through the 'Plugins' menu in WordPress.
5. Go to Settings > LicenceToBill and set BusinessKey and AgentKey (Find these keys in LicenceToBill Account http://licencetobill.com/ )

== Frequently Asked Questions ==

= What are the shortcodes ? =
* Use [LTBdeals link_text='My Subscriptions'] to retrieve the url of the page hosted by LicenceToBill which displays all the subscriptions of a user logged on your wordpress site.
* Use [LTBinvoices link_text='My Invoices'] to retrieve the url of the page hosted by LicenceToBill which displays all the invoices of a user logged on your wordpress site.
* Use [LTBoffers text_if_anonymous='<a href=/"https://XYZ.licencetobill.com/">Check our offers</a>' text_if_not_anonymous='Please <a href="{link_offers}">choose a paying offer</a> or choose <a href="{link_offer}">our best offer.</a>' keyoffer='xxxx'] to display a text if the visitor is logged in or not (anonymous or not). In the case of the visitor is NOT anonymous, use the tag {link_offers} to retrieve/get/use the url of the page hosted by LicenceToBill which displays all your offers AND/OR use the tag {link_offer} to retrieve/get/use the url of the page hosted by LicenceToBill which displays the offer which its key is keyoffer. 
* Use [LTBaccess keyfeature='XXX-XXX-XXX-XXX' display_text_if_noaccess='yes' text_if_noaccess='This video/text is available only to paying subscribers. Please <a href="{link_upgrade}">choose a paying offer</a>.' display_text_if_noregistered='yes' text_if_noregistered='Please <a href="/login/">log in</a> ou de <a href="/register/">register</a>' ]CONTENT TO PROTECT[/LTBaccess]
The keyfeature attribut is mandatory. Get it from the backoffice of LicenceToBill http://secure.licencetobill.com/
* Use [LTBroles] to update the role(s) of a user logged in.

= Where can I find my BusinessKey and AgentKey ? =
* Please log in from http://licencetobill.com.
* Click on "Global Parameters" on the left menu

== Screenshots ==

== Changelog ==

= 2.1.3 =
* Bugs fixed

= 2.1.2 =
* Modify new shortcode "LTBoffers"

= 2.1.1 =
* Add new shortcode "LTBroles"

= 2.0.8 =
* Add new attributes in "LTBoffers" shortcode : 
- url_if_anonymous replaced by text_if_anonymous
- link_text replaced by text_if_not_anonymous ( ajout de 2 variables {link_offers} & {link_offer} )

= 2.0.7 =
* Add new attributes in "LTBaccess" shortcode : key_offer1, key_offer2, key_offer3

= 2.0.6 =
* Add new attributes in "LTBaccess" shortcode : display_text_if_noregistered, text_if_noregistered

= 2.0.5 =
* Bug fixes

= 2.0.4 =
* Optimization settings

= 2.0.3 =
* Help added

= 2.0.2 =
* Advanced Trial Mode
* User Data Synchronization (must have for nice billing)

= 2.0.1 =
* Fix Trial Mode

= 2.0.0 =
* Added shortcodes

= 1.0.1 =
* Bug fix on install.

= 1.0 =
* First stable release.