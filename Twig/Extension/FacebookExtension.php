<?php

namespace Bundle\Kris\FacebookBundle\Twig\Extension;

use Bundle\Kris\FacebookBundle\Twig\TokenParser\FacebookTokenParser;

/**
 *
 */
class FacebookExtension extends \Twig_Extension
{
    protected $appId;

    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'facebook_connect_button' => new \Twig_Function_Method($this, 'renderConnectButton', array('is_safe' => array('html'))),
        );
    }

    public function renderConnectButton()
    {
        return sprintf(<<<EOF
<fb:login-button autologoutlink="true"></fb:login-button>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: %s, status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.src = document.location.protocol +
      '//connect.facebook.net/fr_FR/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
EOF
        , $this->appId);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'facebook';
    }
}
