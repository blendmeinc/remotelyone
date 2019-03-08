INTRODUCTION
----------------------

Background Image FIeld module allows you to create a field on an entity type. 
It requires responsive images mapping in order to offer the best image quality 
for the device it is rendering on. The field will define the CSS selector to 
attach the background image too and then allow you basic CSS options repeat, 
size, and position so you can define a per 
image solution for your frontend needs.

REQUIREMENTS
------------

-   Token
-   Core: Responsive Images

SIMILAR PROJECTS
----------------

Formatters are used in the process of how fields are rendered. A formatter 
is an addition to how a field works and is not a field itself. Formatters 
can solve global issues while using the base fields configuration. Formatters 
that have similar features as the Background Image Field:

-   [Picture Background Formatter (base formatter)](https://www.drupal.org/project/picture_background_formatter)
-   [Background Images Formatter](https://www.drupal.org/project/bg_image_formatter)
-   [Simple Background Image Formatter](https://www.drupal.org/project/background_image_formatter)

The biggest differences you will notice is that the formatters will apply it 
setting globally to all content that is being rendered with that formatter. 
Using a field-specific solution allows you the control of each 
individual content of the field type per entity type i.e. node, 
paragraph_item, or custom entity. This field type makes your 
background image content more dynamic per page and 
allows more control over how your background image will render. 
Having this as a field also allows you a different way to apply it 
to content, query it in views, custom personalization per item 
created with it.

INSTALLATION
------------

Install as you would any other drupal module. See more information 
[here](https://www.drupal.org/docs/8/extending-drupal-8/installing-drupal-8-modules).

CONFIGURATION
-------------

1.  Create responsive image style /admin/config/media/responsive-image-style
    -   The only responsive image style that will 
    be picked up by the field formatter 
    are the ones that have selected a single image style.
2.  Add the field on an entity type such as node, 
    paragraph_item or, custom entity.

TROUBLESHOOTING
---------------

If you do not see the background image, please make sure to check 
that the CSS selector is actually apart of the HTML. 
The field will not create the selector you choose it already has 
to exist for it to work.

If you don't see any available responsive image styles in the managed 
display setting on the entity type you will most 
likely need to create one following the outline configurations above.

MAINTAINERS
-----------

[The Tombras Group](https://www.drupal.org/the-tombras-group)

Module Development and Maintenance

[Encore Multimedia](https://www.drupal.org/encore-multimedia)

Initial development for the formatter in the Background Image Field
