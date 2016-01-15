=== Plugin Name ===
Contributors: jeffreyvr, jekrikken
Tags: multisite, members, roles, synchronize
Requires at least: 4.3
Tested up to: 4.4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a simple Multisite add-on for Justin Tadlock's Members plugin, which synchronizes user (multiple) roles on all network sites.

== Description ==

This is a simple Multisite add-on for Justin Tadlock's Members plugin, which synchronizes user (multiple) roles on all network sites.

== Installation ==

By installing this plugin we assume you use WordPress Multisite and have Justin Tadlock's Members plugin installed.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress Multisite plugins screen directly.
2. Network activate the plugin through the Multisite 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= Where is the settings page for this plugin? =

There is none. You simply activate it and it will work right away.

= Is there a function to add a role to a user programmaticly? =

Yes, there is. See this example code:

`<?php
$members_mu_user_roles_sync = Members_Mu_User_Roles_Sync();
$members_mu_user_roles_sync->add_role(
  $user_id, // user you want to add role to
  $roles = array(), // input array is needed
  $all_sites = TRUE
);
?>`

== Links ==

*	[Members](https://nl.wordpress.org/plugins/members/)

== Changelog ==

= 0.0.1 =
* Init release.
