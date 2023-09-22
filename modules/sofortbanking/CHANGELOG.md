# Sofort. module

* Version 3.0.2
  * Rebranding
  * Bugfix "wrong configuration data"
  * Bugfix "deleted configuration data in Checkout"
  * Integration PrestUI for compliant backoffice
  * updated translations
  * Banner option removed

* Version 3.0.1

  * Use ssl if ssl is configured
  * Fix illegal offset warning for supported language
  * Replace short with long array syntax for backward compatibility

* Version 3.0.0

  * Updated logos
  * Dropped option customer protection
  * Updated translations
  * Switched to PSR-2 coding style
  * Added sql slave support
  * Dropped support for PS 1.4 (Note payment.php was removed)
  * Use MD for README, CHANGELOG -> README.md, CHANGELOG.md
  * Removed old payment_execution.tpl
  * Updated transaction reason format
  * Cleanup payment controller
  * Fixed check if payment is available
  * Reorder usable order states in module configuration
  * Removed unused config variables and link generator from module configuration
  * Replaced old validation.php with new notification.php
  * Added simple backend configuration warnings for invalid module configuration
  * Replaced Name-Value-Pair API with XML API
  * Removed old configuration SOFORTBANKING_PROJECT_PW, SOFORTBANKING_NOTIFY_PW, SOFORTBANKING_REDIRECT
  * Added sofortlib
  * Set new module version 3.0.0

* Version 258

  * Add backward compatibility for versions lower than PS 1.7
  * Add compatibility for PS 1.7
  * Remove old payment_redirect.tpl
  * Fix success validation
  * Update missing translations
  * Fix change order state
  * Fix validation bug, thx for the feedback to Marek Vavrecan
  * Fix trim white spaces for input hash

* Version 2571

  * Fix trim white spaces for input hash

* Version 257

  * Update translations
  * Fetch front-end images directly from sofort server
  * Remove unused local images

* Version 256

  * Increment...

* Version 255

  * Fix right/left column on payment

* Version 253

  * Update hungarian translation
  * Update module version

* Version 24

  * Increment...

* Version 23

  * Add order state dropdowns for accepted and failed payments
  * Add optional checkbox to ignore status update events
  * Set new default status for payed orders
  * Small fixes for PS coding standards
  * Add order validation by confirmation url
  * Update notification validation.php for failed payments
  * Fix token redirect and authentication check in payment.php for PS compat 1.4
  * Add compats for PS 1.6
  * Add new clear module configuration layout
  * Update translations
  * Add new translations (Slovak, Czech, Hungarian)
  * Fix invalid token in one page checkout
  * Fix urls for multistores

* Version 22

  * Increment...

* Version 21

  * Increment...

* Version 20

  * Remove old Payment tab
  * Replace globals by Tools::getValue()
  * Remove unused code from touchdesign lib
  * Move template files to views
  * Rewrite admin display form for views
  * Cast some user values for "better performances"...
  * Remove some unused code for old backwards
  * Add token for payment.php
  * Code cleanup for PrestaShop coding standards
  * Add backward_compatibility
  * Replace ucfrist with Tools::ucfirst
  * Escape template vars
  * Replace strtolower with Tools::strtolower
  * Add some compatibility fixes for PS 1.4
  * Add extra string for payment button

* Version 19

  * Add currency paramater for CHF,GBP and Euro currencies
  * Add module lang fallback
  * Add new translation for gb
  * Fix translation strings

* Version 18

  * Small fix to grep backend language with or without context
  * Add index.php protection for sub-directories
  * Add some compats in dev_mode for PS 1.5
  * Add controllers and views for PS 1.5
  * Replace spaces by tabs
  * Code cleanup
  * Fix cancellation link for PS 1.5

* Version 17

  * Add backward compatibility for PS 1.4

* Version 16

  * Add compatibility for PS 1.5.4
  * Fix payment tpl {l ...} tag
  * Add multi language support for images
  * Add new translations for es, fr, it, nl and pl
  * Fix module name translation

* Version 15

  * Add compatibility for PS 1.5.3
  * Update translations
  * Switch icon

* Version 14

  * Logo update

* Version 13

  * Add compatibility for PS 1.5

* Version 12

  * Add optional force redirect (usefull for non EU and modified stores)

* Version 11

  * ...

* Version 10

  * Update README
  * Update Translations
  * Update logos
  * Rename sofortueberweisung -> sofortbanking
  * Add secure_key

* Version 09

  * Fix guest checkout
  * Add touchdesign library
  * Fix redirects

* Version 08

  * Small changes for prestashop version 1.4 compatibility
  * Add confirm before payment page
  * Update README
  * Update Translations

* Version 07

  * Update cancel url
  * Add readme/install doc
  * Update translation
  * Add payment block
  * Add success message
  * Add required note
  * Add confirmation page
  * Update order states
  * Code cleanup
  * Add changelog
  * Add customer protection by sofort bank

* Version 06-01

  * Initial release