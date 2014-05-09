<?php

namespace JhInstallerTest\Controller;


use Zend\Console\Request;
use Zend\Http\Request as HttpRequest;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

/**
 * Class InstallControllerTest
 * @package JhFlexiTimeTest\Controller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallControllerTest extends AbstractConsoleControllerTestCase
{
    protected $controller;
    protected $installer;
    protected $moduleManager;
    protected $consoleAdapter;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . "/../../TestConfiguration.php.dist"
        );
        parent::setUp();

        $this->moduleManager    = $this->getMock('Zend\ModuleManager\ModuleManagerInterface');
        $this->installer        = $this->getMock('JhInstaller\Install\Installer', [], [$this->moduleManager]);
        $this->consoleAdapter   = $this->getMock('Zend\Console\Adapter\AdapterInterface');


        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('JhInstaller\Install\Installer', $this->installer);
        $serviceManager->setService('Console', $this->consoleAdapter);
    }

    public function testInstallCommandRunsInstallService()
    {
        $this->installer
            ->expects($this->once())
            ->method('installModules')
            ->with($this->consoleAdapter);

        $this->dispatch(new Request(array('scriptname.php', "install")));

        $this->assertResponseStatusCode(0);
        $this->assertModuleName('jhinstaller');
        $this->assertControllerName('jhinstaller\controller\install');
        $this->assertControllerClass('installcontroller');
        $this->assertActionName('install');
        $this->assertMatchedRouteName('installer');
    }
}
