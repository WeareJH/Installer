<?php

namespace JhInstallerTest\Controller\Factory;

use JhInstaller\Controller\Factory\InstallControllerFactory;
use Zend\Mvc\Controller\PluginManager;

/**
 * Class InstallerControllerFactoryTest
 * @package JhInstallerTest\Controller\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallerControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $installer = $this->getMockBuilder('JhInstaller\Install\Installer')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator
            ->expects($this->at(0))
            ->method('get')
            ->with('JhInstaller\Install\Installer')
            ->will($this->returnValue($installer));

        $serviceLocator
            ->expects($this->at(1))
            ->method('get')
            ->with('Console')
            ->will($this->returnValue($this->getMock('Zend\Console\Adapter\AdapterInterface')));





        $controllerPluginManager = new PluginManager();
        $controllerPluginManager->setServiceLocator($serviceLocator);

        $factory = new InstallControllerFactory();
        $this->assertInstanceOf('JhInstaller\Controller\InstallController', $factory->createService($controllerPluginManager));
    }
} 