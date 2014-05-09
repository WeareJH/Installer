<?php

namespace JhInstaller\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use JhInstaller\Install\Installer;

/**
 * Class InstallController
 * @package JhInstaller\Controller
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class InstallController extends AbstractActionController
{
    /**
     * @var Installer
     */
    protected $installer;

    /**
     * @var AdapterInterface
     */
    protected $console;

    /**
     * @param Installer $installer
     * @param AdapterInterface $console
     */
    public function __construct(Installer $installer, AdapterInterface $console)
    {
        $this->installer   = $installer;
        $this->console     = $console;
    }

    /**
     * Run the install service
     */
    public function installAction()
    {
        $this->console->writeLine("Starting Installation", ColorInterface::GREEN);
        $this->installer->installModules($this->console);
        $this->console->writeLine("Finished!", ColorInterface::GREEN);
    }
}
