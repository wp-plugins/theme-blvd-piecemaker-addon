=== Theme Blvd Piecemaker Addon ===
Contributors: themeblvd
Tags: piecemaker, themeblvd, slider
Requires at least: 3.2
Tested up to: 3.3.1
Stable tag: 1.0.0

Add Piecemaker 2 to slider manager when using a theme with Theme Blvd framework version 2.0.4+.

== Description ==

This plugin will add the Piecemaker 2 Flash slider to the Slider Manager's built-in slider types when using a WordPress theme with the Theme Blvd framework version 2.0.4+.

= Who is this plugin for? =

If you're *not* using a Theme Blvd theme, and you're looking to incorporate Piecemaker into your WordPress site, the following plugin is what you're looking for:

<http://wordpress.org/extend/plugins/the-piecemaker-image-rotator/>

However, if you are using a Theme Blvd WordPress theme, this plugin will allow you to use Piecemaker 2 within the the features of the framework. This means that you can use your theme's current Slider Manager to create Piecemaker sliders. You can then use those sliders in all standard places like within the Layout Builder and via the [slider] shortcode in pages and posts.

= How do I use the plugin? =

After you install this plugin, a new slider type will be added to the current slider types you already have. So, you'll need to go to the *Sliders* page in your WordPress admin panel, and now when you click the "Add New" tab, you'll notice "Piecemaker" has been added to the list of slider types you can choose from. Proceed in creating your slider as you normally would, however you will notice that you obviously have less options for configuring your slides than with the framework's standard slider type.

= Plugin Limitations =

Since the Theme Blvd framework v2.0+ is 100% responsive, this Piecemaker addon obviously comes with its limitations. If it had no limitations, we would have most likely incorporated it into the core sliders of the framework.

**Slider Location:** First of all, because Piecemaker is a Flash/XML slider, it cannot be setup to automatically re-size with the rest of your site. So, this limits you in where you can actually use this slider within your site. The standard slider type that comes with your Theme Blvd theme can be placed essentially anywhere in your site. However when you're using the Piecemaker Addon, it can only be used within a "full-width" area. So this means you can either use it up in the "Featured Area" or in the "Primary Area" only when you have a "Full Width" sidebar layout selected.

**Mobile Devices and Tablets:** Second, also because piecemaker is a Flash/XML slider, it obviously will not work at all on iOS devices (i.e. iPads and iPhones), which provide no support for Flash. Also, because the theme will get scaled down on other mobile and tablet devices that do support Flash anyway, the slider would look bad because your images would be cut off. So, for this plugin what I've done is provide a responsive fallback. When your site is being viewed on any device with a viewport 800px or smaller, the Piecemaker plugin gets hidden, and in its place, you will see all of your slider's images listed out.

= Important Note =

After installing this plugin, you **must** give the "xml" directory within the plugin writeable file permissions (755 or 777 depending on your server). Not doing this will make the plugin impossible to use because the XML files required for your Piecemaker sliders will not be generated.

== Installation ==

1. Upload `theme-blvd-piecemaker-addon` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure the `xml` folder within the plugin folder has been given writeable permissions (755 or 777 depending on your server).

== Screenshots ==

1. When you add a new slider, you can see that now there is an option to select the Piecemaker slider type.
2. For those that are not familiar with the Piecemaker slider, here is a generic example of what you can expect.

== Changelog ==

= 1.0 =

* This is the first release.