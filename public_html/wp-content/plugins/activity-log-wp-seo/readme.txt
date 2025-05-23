=== WP Activity Log for Yoast SEO ===
Contributors: WPWhiteSecurity
Plugin URI: https://wpactivitylog.com/
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html
Tags: activity log for Yoast SEO, WP Activity Log extension, activity logs
Requires at least: 5.0
Tested up to: 6.1.1
Stable tag: 1.3.1
Requires PHP: 7.2

Keep a detailed log of your team's changes in the Yoast SEO meta box & plugin settings.

== Description ==

Yoast SEO allows you and your users to configure on-page SEO to help you improve your website's ranking.

Keep a record of the changes that you and your team do in your Yoast SEO plugin settings and the Yoast meta box by installing this extension alongside the WP Activity Log plugin.

Refer to [activity log for Yoast SEO](https://wpactivitylog.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) for more detailed information on this integration.

#### About WP Activity Log
[WP Activity Log](https://wpactivitylog.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) is the most comprehensive real time activity log plugin for WordPress. It helps thousands administrators and security professionals keep an eye on what is happening on their websites and multisite networks.

WP Activity Log is also the most highly rated WordPress activity log plugin and have been featured on popular sites such as GoDaddy, ManageWP, Pagely, Shout Me Loud and WPKube.

### Getting started

To keep a log of the changes that happen on your Yoast SEO plugin, metabox and more simply:

1. Install the [WP Activity Log plugin](https://wpactivitylog.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description)
1. Install this extension from the section <i>Enable/disable events</i> > <i>Third party extensions</i>.

### With this extension you can keep a log of:

Below are some of the user and plugin changes you can keep a log of when you install this extension with the WP Activity Log plugin:

* Yoast SEO plugin features such as readability anaylises
* Template on-page SEO title and meta description
* Changes to on-pages SEO in the Yoast SEO metabox


Refer to the [activity logs event IDs for WooCommerce](https://wpactivitylog.com/support/kb/list-wordpress-activity-log-event-ids/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) for a complete list of the changes the plugin can keep a log of.

== Installation ==

=== Install this extension for Yoast SEO from within WP Activity Log (easiest method) ===

1. Navigate to the section <i>Enable/disable events</i> > <i>Third party extensions</i>.
1. Click <i>Install extension</i> under the Yoast SEO logo and extension description.

=== Install this extension from within WordPress ===

1. Ensure WP Activity Log is already installed.
1. Visit 'Plugins > Add New'.
1. Search for 'Activity Log WP SEO'.
1. Install and activate the extension.

=== Install this extension manually ===

1. Ensure WP Activity Log is already installed.
1. Download the plugin and extract the files.
1. Upload the `activity-log-wp-seo` folder to the `/wp-content/plugins/` folder on your website.
1. Activate the WP Activity Log extension for Yoast SEO plugin from the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Support and Documentation =
Please refer to our [Support & Documentation pages](https://wpactivitylog.com/support/kb/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) for all the technical information and support documentation on the WP Activity Log plugin.

== Screenshots ==

1. The WP Activity Log plugin will alert you to install the Yoast SEO extension when it detects the Yoast SEO plugin on the website.
1. Alternatively, you can install the Yoast SEO activity log extension from the Enable/Disable events > Third party plugins section.
1. Once the extension is installed, thed WP Activity Log plugin will keep a log of the changes you or anyone from your team do in the plugin settings, or on-page SEO details in the Yoast SEO meta box.

== Changelog ==

= 1.3.1 (2023-03-29) =

* **Improvements:**
	* Compatability update for WP Activity Log 4.5.

= 1.3.0 (2022-03-24) =

Release notes: [Yoast SEO, WPForms & Gravity Forms activity log extension updates](https://wpactivitylog.com/extensions-march-2022-update/)

* **New event IDs**
	* 8849: Enabled / Disabled a third party integration.
	* 8850: Changed the Breadcrumb title of a post.
	* 8851: Changed the Page type in the Schema settings of a specific post type.
	* 8852: Changed the Article type in the Schema settings of a specific post type.
	* 8853: Changed the Default Page Type setting in the Content Type Schema settings.
	* 8854: Changed the Default Article Type setting in the Content Type Schema settings.

* **New event IDs for Redirects feature in Yoast SEO**:
	* 8855: Added a new redirect.
	* 8856: Modified a redirect.
	* 8857: Deleted a redirect.
	* 8858: The redirect mothed has been changed.

* **Improvements:**
	* Improved the metadata reported in event ID 8845.
	* Improved the context etc of the events for the Search Appearance changes.
	* Updated code - now using the WordPress coding standard.
	
= 1.2.0 (2021-09-01) =

Release notes: [Activity log extensions for Yoast SEO, WooCommerce & WPForms get a maintenance update](https://wpactivitylog.com/extensions-september-2021-update/)

* **New event IDs**
	* 8844: The setting Add Open Graph meta data in the Facebook settings page was changed.
	* 8845: The Default image in the Facebook settings page was changed.
	* 8846: The setting Add Twitter card meta data in the Twitter settings page was changed.
	* 8847: The Default card type setting in the Twitter settings page was changed.
	* 8848: Changed the Pinterest confirmation meta tag in the Pinterest settings page was changed.
	
* **Improvements**
	* Removed obsolete functions from the extension.
	
* **Bug fix**
	* Event ID 8807 was not reporting the previous focus keyword when changed.

= 1.1.0 (2021-04-28) =

Release notes: [Improved coverage of Yoast SEO plugin multisite settings](https://wpactivitylog.com/yoast-seo-extension-1-1-0/)

* **New functionality**
	* Coverage of multsite network plugin settings changes - new event IDs below.
	
* **New event IDs**
	* 8841: Added / changed / removed a search engine webmaster tools verification code.
	* 8838: Changed the setting of who should have access to the Yoast SEO plugin settings on a multisite network.
	* 8839: Changed the setting from where new sites on the multisite network should inherit the SEO settings.
	* 8840: User has reset the SEO settings of a site on the multisite network to default.
	* 8842: Disabled a plugin feature at multisite network level.
	* 8843: Allowed site administrators to toggle a plugin feature on or off at site level on a multisite network.

* **Improvements**
	* Improved text and readability of some of the events. 
	* Removed obsolete events (Event IDs 8810 and 8811).
	* Events now use the latest event format used in [WP Activity Log](https://wpactivitylog.com).
	* Updated the core to the latest improved core (better performance and more efficient).
	* Extension can now be activated only at network level.
	* Extension name added to plugin's admin notices.
	
* **Bug fixes**
	* Fixed broken backward compatability issue.

= 1.0.1 (20210223) =

* **Improvement**
	* Removed event IDs 8810 & 8811 (settings are obsolete in plugin).
	
* **Bug fix**
	* Fixed a title formatting issue in the Enable/Disable events section.
	
= 1.0 (20201007) =

	*Initial release.
