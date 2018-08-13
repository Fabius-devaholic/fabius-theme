# Fabius Theme
[Wordpress](https://wordpress.org) is an online, open source website creation tool written in PHP. People say that it's probably the easiest and most powerful blogging and website content management system (or CMS) in existence today.

This is a simple wordpress theme based on [_ theme](https://underscores.me). This theme is included:
- acf (_`inc/acf.php`_)
- api (_`inc/api.php`_)
- custom post types (_`inc/post-types.php`_)
- custom taxonomies (_`inc/taxonomies.php`_)
- shortcodes (_`inc/shortcodes.php`_)
- simple theme settings (_`inc/settings.php`_)
- automate build tool (_`webpack/`_)

If you don't want to use any of the above items, you can comment its line in _`functions.php`_. To check how it works, you should take a look at _`page-templates/page-readme.php`_.

### ACF
It is the best plugin for custom field at current. You can find out more [here](https://www.advancedcustomfields.com). It is recommended that you register custom fields in one file.

### API
Wordpress has an [api](http://v2.wp-api.org) that supporting developers pretty much. In case you may want to create a custom api endpoint. Please read [here](https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints) before you go further in creating your own awesome api.

### Custom Post Types
WP has some default [post types](https://developer.wordpress.org/themes/basics/post-types) such as post, page, etc. You want more? There are good plugins lets you do it like [Custom Post Type UI](https://wordpress.org/plugins/custom-post-type-ui). An event custom post type is already registered in _`inc/post-types.php`_. Enjoy!

### Custom Taxonomies
Like post type, you can create custom taxonomies in _`inc/taxonomies.php`_.

### Shortcodes
Shortcode let you define a specific tag in your copies. A shortcode returns some HTML code that it suppose to do.

### Theme settings
You better use acf for this choice, but you also can create some simple fields.

### Automate build tool
Install
```
yarn
```
Watch file changes (webpack-dev-server)
```
yarn watch    # A server will be created and listen on port 8000.
```
Build production file
```
yarn build    # all built files are in dist directory
```
