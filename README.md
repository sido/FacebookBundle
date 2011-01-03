Installation
============

  1. Add this bundle and the Facebook PHP SDK to your project as Git submodules:

          $ git submodule add git://github.com/kriswallsmith/KrisFacebookBundle.git src/Bundle/Kris/FacebookBundle
          $ git submodule add git://github.com/facebook/php-sdk.git src/vendor/facebook

  2. Add this bundle to your application's kernel:

          // application/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Bundle\Kris\FacebookBundle\KrisFacebookBundle(),
                  // ...
              );
          }

  3. Configure the `facebook` service in your config:

          # application/config/config.yml
          facebook.api:
              file:   %kernel.root_dir%/../src/vendor/facebook/src/facebook.php
              alias:  facebook
              app_id: 123456879
              secret: s3cr3t
              cookie: true

          # application/config/config.xml
          <facebook:api
              file="%kernel.root_dir%/../src/vendor/facebook/src/facebook.php"
              alias="facebook"
              app_id="123456879"
              secret="s3cr3t"
              cookie="true"
          />

     If you do not include a `file` value in the config you will have to
     configure your application to autoload the `Facebook` class.

  4. Add this configuration if you want to use the `security component`:

          # application/config/config.yml
          security.config:
              providers:
                  facebook:
                    id: facebook.auth

              firewalls:
                  public:
                      pattern:   /.*
                      facebook:  true
                      anonymous: true
                      stateless: true
                      security:  true

              access_control:
                  - { path: /.*, role: [ROLE_USER, IS_AUTHENTICATED_ANONYMOUSLY] }

Setting up the JavaScript SDK
-----------------------------

A templating helper is included for loading the Facebook JavaScript SDK and
initializing it with parameters from your service container. To setup the
Facebook JavaScript environment, add the following to your layout just after
the opening `body` tag:

      <body>
          <!-- inside a php template -->
          <?php echo $view['facebook']->initialize(array('xfbml' => true)) ?>
          <!-- inside a twig template -->
          {{ _view.facebook.initialize(['xfbml': true])|raw }}

If you will be adding XFBML markup to your site you must also declare the
namespace, perhaps in the opening `html` tag:

      <html xmlns:fb="http://www.facebook.com/2008/fbml">

Include the login button in your templates
------------------------------------------

Just add the following code in one of your templates:

      {% facebook_connect_button %}
