<?php

namespace JhInstallerTest;
use JhInstaller\Install\Installer;
use Zend\ServiceManager\ServiceManager;

/**
 * Class InstallerTest
 * @package JhInstallerTest
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallerTest extends \PHPUnit_Framework_TestCase
{

    protected $serviceLocator;

    protected $moduleManager;

    protected $adapter;

    protected $installer;

    public function setUp()
    {
        $this->serviceLocator   = new ServiceManager();
        $this->moduleManager    = $this->getMock('Zend\ModuleManager\ModuleManagerInterface');
        $this->adapter          = $this->getMock('Zend\Console\Adapter\AdapterInterface');
        $this->installer        = new Installer($this->moduleManager);
        $this->installer->setServiceLocator($this->serviceLocator);
    }

    public function testIfModuleNotInstanceOfInstallableNoInstallPerformed()
    {
        $mockModule = $this->getMock('JhInstaller\Module');

        $this->moduleManager
             ->expects($this->once())
             ->method('getLoadedModules')
             ->with(false)
             ->will($this->returnValue([$mockModule]));

        $mockModule
            ->expects($this->never())
            ->method('getInstallService');

        $this->installer->installModules($this->adapter);

    }

    public function testModuleIsSkippedIfInstallServiceNotValid()
    {
        $mockModule = $this->getMock('JhInstaller\Install\Installable');
        $mockInstallService = $this->getMock('JhInstaller\Install\InstallerInterface');
        $this->moduleManager
            ->expects($this->once())
            ->method('getLoadedModules')
            ->with(false)
            ->will($this->returnValue([$mockModule]));

        $mockModule
            ->expects($this->once())
            ->method('getInstallService')
            ->will($this->returnValue('someService'));

        $mockInstallService
            ->expects($this->never())
            ->method('install');

        $this->installer->installModules($this->adapter);
    }

    public function testModuleIsSkippedIfInstallerDoesNotImplementInstaller()
    {
        $mockModule = $this->getMock('JhInstaller\Install\Installable');
        $mockInstallService = $this->getMock('JhInstaller\Install\InstallerInterface');
        $this->moduleManager
            ->expects($this->once())
            ->method('getLoadedModules')
            ->with(false)
            ->will($this->returnValue([$mockModule]));

        $mockModule
            ->expects($this->once())
            ->method('getInstallService')
            ->will($this->returnValue('someService'));

        $this->serviceLocator->setService('someService', new \StdClass);

        $mockInstallService
            ->expects($this->never())
            ->method('install');

        $this->installer->installModules($this->adapter);
    }

    public function testModuleIsInstalledIfServiceImplementsCorrectInterface()
    {
        $mockModule = $this->getMock('JhInstaller\Install\Installable');
        $mockInstallService = $this->getMock('JhInstaller\Install\InstallerInterface');

        $this->moduleManager
            ->expects($this->once())
            ->method('getLoadedModules')
            ->with(false)
            ->will($this->returnValue([$mockModule]));

        $mockModule
            ->expects($this->once())
            ->method('getInstallService')
            ->will($this->returnValue('someService'));

        $this->serviceLocator->setService('someService', $mockInstallService);

        $mockInstallService
            ->expects($this->once())
            ->method('install');

        $this->installer->installModules($this->adapter);
    }

    public function testErrorsAreReportedIfTheyExist()
    {
        $mockModule = $this->getMock('JhInstaller\Install\Installable');
        $mockInstallService = $this->getMock('JhInstaller\Install\InstallerInterface');

        $this->moduleManager
            ->expects($this->once())
            ->method('getLoadedModules')
            ->with(false)
            ->will($this->returnValue([$mockModule]));

        $mockModule
            ->expects($this->once())
            ->method('getInstallService')
            ->will($this->returnValue('someService'));

        $this->serviceLocator->setService('someService', $mockInstallService);

        $mockInstallService
            ->expects($this->once())
            ->method('install');

        $mockInstallService
            ->expects($this->exactly(2))
            ->method('getErrors')
            ->will($this->returnValue(['error1']));

        $this->adapter
            ->expects($this->at(1))
            ->method('writeLine')
            ->with('Errors Occured: ', 2);

        $this->adapter
            ->expects($this->at(2))
            ->method('writeLine')
            ->with('error1', 2);

        $this->installer->installModules($this->adapter);
    }

    public function testGetServiceLocator()
    {
        $this->assertSame($this->serviceLocator, $this->installer->getServiceLocator());
    }


} 