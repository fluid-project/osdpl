/**
 * $Id: README.txt,v 1.1.2.2 2007/10/26 20:06:55 rconstantine Exp $
 * @package CCK_Taxonomy_SSU
 * @category NeighborForge
 */
This module adds the ability to have several different membership types, each collecting different
data from the user for registration by using custom content types and the combination of nodeprofile 
and pageroute modules. The accounttypes module is recommended but not required.

--CONTENTS--
  REQUIREMENTS
  INSTALL/SETUP
  FEATURES
  USAGE (Example)
  UNINSTALL
  CREDITS
  HELP
  
--REQUIREMENTS--
  CCK - The CCK module must be installed and enabled. There are no submodule dependencies.
  Taxonomy - The Core module Taxonomy must be installed and enabled as well.
  
--INSTALL/SETUP
  Install this module through the standard Drupal means; copy the files to a folder in your modules
  folder, then enable the module in the administration section of your site. CCK will construct the
  required tables.
  
--FEATURES--
  1) The primary feature is a hierarchical listing of your taxonomy with a checkbox next to each to allow
  multiple selection.
  2) Heirarchical freetagging (a first for Drupal). When this feature is enabled, each branch will have a
  textfield where the user can enter in a new term. The page must be saved before the new term(s) become
  available for selection.
  3) Selection of branch terms. An option has been provided to allow users to select branch terms. This
  is most important if you have allowed freetagging as terms that were once leaf terms may become branches.
  Not allowing branch term selection would therefore leave some nodes with terms that are no longer leaf
  terms and no way to later deselect them. Allowing branch term selection also implies that all child terms
  apply, though how you might use that information in your module is beyond the scope of this module.
  4) Hidden, CCK terms. Normally, the terms checked by the user will be stored only in a CCK-built table
  for that purpose. This renders the terms invisible to the taxonomy module, though they will appear as
  content in a list in the node itself.
  5) Tags. An option is provided to include the selected terms as regular tags so the taxonomy module can
  see them as well. This means the terms can be used just like other taxonomy tags and links will appear
  at the bottom of nodes, etc.
  6) Psuedo-alphabetized. I think there is an issue with the top-most level where leaf terms are mixed with
  branch terms, but all children should follow the following behavior:
    - Branch terms (if enabled as checkable) will be listed first and in bold letters.
    - Leaf terms will be listed alphabetically after the parent branch term.
    - Child branch terms will be listed after leaf terms and will be alphabetized themselves.
    
    NOTE: Please take screen shots of any problems you see with the alphabetizing. The firefox plugin
    ScreenGrab! is great and allows you to do entire pages (including what you'd have to scroll to see).
    
  7) Ratings. You may allow users to rate the terms. You must use your imagination here. The ratings are tied
  to the node, not the vocabulary. You can use the ratings as like/dislike, skill level, movie rating, or
  whatever. This was designed for a specific use case, so if you don't need it, don't use it.
    
--USAGE--
  1) You must first create a vocabulary in the usual way, via the categories administrative menu. Please see
  the handbook at Drupal.org for more information. One thing to note that is REQUIRED at this point, you MUST
  allow multiple values for the vocabulary!!! The reason is that the radio button side of this module is not
  completely working, so single selections are not allowed and will throw error messages all over the place.
  2) Once the vocabulary is made, do NOT associate it with the content types you want to use this module with
  as this will simply enable the regular taxonomy interface. And since you are installing this module, you
  don't want that. You can use the vocabulary with other content types however you wish.
  3) Create or edit a content type with CCK. You must have the content module enabled.
  4) Add a field to the content type. You will see a listing of "Taxonomy vocabulary (super select ultra)" as
  a field type. Below it, you will see a list of the vocabularies you have defined. Yes, you can use any
  vocabulary. So if you use vocabulary Aardvark in one content type in the usual way, you can also use the
  same vocabulary in another content type with this module in any way you wish. Select one of the vocabs and
  name the field. Then save it.
  5) Notice on the settings page that the 'widget' is fixed. You must destroy and recreate a field in order to
  change the vocabulary, so choose correctly the first time.
  6) The other 'Widget settings' are standard. Adjust as you see fit.
  7) Require the field or not, it's your choice.
  8) Notice that the multiple values field is determined by the setting from your vocabulary. You SHOULD HAVE
  allowed multiple values. See step 1 above for why.
  9) "Display parent terms as selectable form items" is what feature 3 above is talking about. Use it as you
  wish.
  10) "Add used terms as node tags?" is what feature 5 above is talking about. Use it as you wish.
  11) "Term ratings" is what feature 7 above is talking about. The selections have good descriptions, so fill
  them out as you wish.
  12) Save the settings.
  13) Create a test node of that type to see it in action. 
    
--UNINSTALL--
  Deactivation and uninstallation are both done in the normal Drupal way.
  
--CREDITS--
  This module was put together by Ryan Constantine (Drupal.org ID rconstantine) but was based on two other modules.
  The first module this one is based on is cck_taxonomy. See that project's page for details on its authorship.
  The second module this one is based on is taxonomy_super_select. Again, see that project's page for details.
  This module's author added quite a lot, most particularly infinite depth for the vocabulary.
  
--HELP--
  I bet you thought I was going to tell you how you can get help. Actually, I'm asking for help from you. I haven't
  had time to get the radio button (single term selection) side of this module working yet. Any help there would be
  great. Also, anyone interested in rethemeing this, please do and post your results. For example, the vertical
  spacing between terms could probably be smaller so the whole taxonomy doesn't spread out so much. Also, "Parent"
  and "Add a term" could probably be placed on the same line or otherwise more closely joined. The problem I had
  there was the length of the description for the parent selector. Also with the themeing, perhaps nested branches
  could alternate background colors or something, similar to table entries.
  
  As for you getting help, post an issue to the issue queue per the regular Drupal way.