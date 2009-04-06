OALiquid
11/27/2007
doc version1.1
module version 1.2

Slightly better documentation is found on the project drupal page: http://drupal.org/project/oaliquid

INSTALL
You'll need to have the Views Module installed: http://drupal.org/project/views
The CCK module is optional:http://drupal.org/project/cck 

The OAInjection module is also optional, but HIGHLY recommended.  You'll need it to 'inject' both css and JS via the OALiquid module: http://drupal.org/project/oainjection

Perform the standard module installation steps.

UNINSTALL
After Disabling the module, run the uninstall process via Modules>Uninstall.  The module directory should likely be removed from your modules folder.

HOW TO USE

These are the rough and dirty directions for now (in hopes they'll mature over time).

Create a View and select one of the two Liquid Options for the “View Type” (applies to either your Page or Block View – or both).
After the view is  created, go to admin>site building>views>liquid layout and first select “Set Layout” (this is your Plugin) and then “Configure” the layout.  After this, check out your View to see how things are looking.Things start to get much more fun when you’re using CCK – especially the CCK “View Field” module.  (E.G. we created tabbed navigation of a group of nodes with this method.  And had a good time doing it.)

HOW TO USE: PLUGINS
Plugins are effectively the means by which layout and styling happen - in this manner, OALiquid serves as the bridge between the Views Module styling mechanism and the Plugins.  4 different Plugins are included with OALiquid, but more can be built and dropped in the OALiquid Plugins Directory.  (For Example, we use a Lightbox AJAX plugin extensively for handling media files.)

1) Freeform:  This is the most 'bare-bones' Plugin allowing the creation of custom layout and styling as well as javascript injection.  OAInjection module is essential to make full use of this Plugin.
2) Liquid:  A pre-set liquid layout with customizable options.
3) Grid:  A pre-set table layout with customizable options.
4) Json:  The grandaddy of all plugins.  Using this your view will output Json, which is what we like to call the 'awesomeness'.  Ajaxians unite!

EXAMPLES:
http://oyoaha.com (list of images, styled + JS injection)
http://oyoaha.com/portfolio (list on nodes, styled)
http://macewan.oyoaha.com (tabs)

- TEH END -

Contact the Authors
www.oyoaha.com
email@oyoaha.com
