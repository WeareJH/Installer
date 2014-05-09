<?php

namespace JhInstallerTest\Install\Factory;

use JhInstaller\Install\Factory\InstallerFactory;

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

        $serviceLocator
            ->expects($this->once())
            ->method('get')
            ->with('ModuleManager')
            ->will($this->returnValue($this->getMock('Zend\ModuleManager\ModuleManagerInterface')));

        $factory = new InstallerFactory();
        $this->assertInstanceOf('JhInstaller\Install\Installer', $factory->createService($serviceLocator));
    }
} 