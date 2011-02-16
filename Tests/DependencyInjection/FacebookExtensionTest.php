<?php

namespace Bundle\Kris\FacebookBundle\Tests\DependencyInjection;

use Bundle\Kris\FacebookBundle\DependencyInjection\KrisFacebookExtension;

class FacebookExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Bundle\Kris\FacebookBundle\DependencyInjection\KrisFacebookExtension::load
     */
    public function testLoadLoadsDefaults()
    {
        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(false));

        $extension = $this->getMockBuilder('Bundle\\Kris\\FacebookBundle\\DependencyInjection\\KrisFacebookExtension')
            ->setMethods(array('loadDefaults'))
            ->getMock();
        $extension
            ->expects($this->once())
            ->method('loadDefaults')
            ->with($container);

        $extension->load(array(), $container);
    }

    /**
     * @covers Bundle\Kris\FacebookBundle\DependencyInjection\KrisFacebookExtension::load
     */
    public function testLoadDoesNotReloadDefaults()
    {
        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));

        $extension = $this->getMockBuilder('Bundle\\Kris\\FacebookBundle\\DependencyInjection\\KrisFacebookExtension')
            ->setMethods(array('loadDefaults'))
            ->getMock();
        $extension
            ->expects($this->never())
            ->method('loadDefaults');

        $extension->load(array(), $container);
    }

    /**
     * @covers Bundle\Kris\FacebookBundle\DependencyInjection\KrisFacebookExtension::load
     */
    public function testLoadSetsAlias()
    {
        $alias = 'foo';

        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));
        $container
            ->expects($this->once())
            ->method('setAlias')
            ->with($alias, 'kris.facebook');

        $extension = new KrisFacebookExtension();
        $extension->load(array(array('alias' => $alias)), $container);
    }

    /**
     * @covers Bundle\Kris\FacebookBundle\DependencyInjection\KrisFacebookExtension::load
     * @dataProvider parameterNames
     */
    public function testLoadSetParameters($name)
    {
        $value = 'foo';

        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));
        $container
            ->expects($this->once())
            ->method('setParameter')
            ->with('kris.facebook.'.$name, $value);

        $extension = new KrisFacebookExtension();
        $extension->load(array(array($name => $value)), $container);
    }

    public function parameterNames()
    {
        return array(
            array('class'),
            array('app_id'),
            array('secret'),
            array('cookie'),
            array('domain'),
            array('logging'),
            array('culture'),
        );
    }
}
