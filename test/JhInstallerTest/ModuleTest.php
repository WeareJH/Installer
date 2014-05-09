<?php

namespace JhInstallerTest;

use JhInstaller\Module;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ModuleTest
 * @package JhInstallerTest
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testGetConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getConfig());
        $this->assertSame($module->getConfig(), unserialize(serialize($module->getConfig())), 'Config is serializable');
    }

    public function testGetAutoloaderConfig()
    {
        $module = new Module;
        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }

    public function testConsoleUsage()
    {
        $mockConsole = $this->getMock('Zend\Console\Adapter\AdapterInterface');
        $module = new Module();

        $expected = [
            'install' => 'Install All Modules which implement "Installable" Interface'
        ];
        $this->assertSame($expected, $module->getConsoleUsage($mockConsole));
    }
}
