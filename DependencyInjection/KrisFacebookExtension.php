<?php

namespace Bundle\Kris\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class KrisFacebookExtension extends Extension
{
    protected $resources = array(
        'facebook' => 'facebook.xml',
        'security' => 'security.xml'
    );

    public function load(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $config) {
            $this->doApiLoad($config, $container);
        }
    }

    protected function doApiLoad($config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kris.facebook')) {
            $this->loadDefaults($container);
        }

        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'kris.facebook');
        }

        foreach (array('class', 'file', 'app_id', 'secret', 'cookie', 'domain', 'logging', 'culture') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('kris.facebook.'.$attribute, $config[$attribute]);
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getNamespace()
    {
        return 'http://kriswallsmith.net/schema/dic/facebook';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'kris_facebook';
    }

    /**
     * @codeCoverageIgnore
     */
    protected function loadDefaults($container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load($this->resources['facebook']);
        $loader->load($this->resources['security']);
    }
}
