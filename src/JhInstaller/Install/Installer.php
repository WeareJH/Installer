<?php

namespace JhInstaller\Install;

use Zend\Console\ColorInterface as Color;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JhInstaller\Install\Exception as InstallException;

/**
 * Class Installer
 * @package JhInstaller\Install
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Installer implements ServiceLocatorAwareInterface
{

    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @param ModuleManagerInterface $moduleManager
     */
    public function __construct(ModuleManagerInterface $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @param AdapterInterface $console
     */
    public function installModules(AdapterInterface $console)
    {

        //create array of installable modules
        $installableModules = array_filter($this->moduleManager->getLoadedModules(false), function ($module) {
            return $module instanceof Installable;
        });

        //return early if no modules require installing
        if (!count($installableModules)) {
            $console->writeLine("No Modules Require installing", Color::MAGENTA);
            return;
        }

        foreach ($installableModules as $module) {
            $console->writeLine(
                sprintf("Attempting to install: %s", substr(get_class($module), 0, -7)),
                Color::GREEN
            );

            $installerService = $module->getInstallService();

            if (!$this->serviceLocator->has($installerService)) {
                $console->writeLine(
                    sprintf(
                        "Could Not find Installer Service: %s For Module %s. Skipping.",
                        $installerService,
                        substr(get_class($module), 0, -7)
                    ),
                    Color::RED
                );
                continue;
            }

            $moduleInstaller = $this->serviceLocator->get($installerService);

            if (!$moduleInstaller instanceof InstallerInterface) {
                $console->writeLine(
                    sprintf(
                        "Installer Service Must Implement: %s For Module %s. Skipping.",
                        'JhInstaller\Install\InstallerInterface',
                        substr(get_class($module), 0, -7)
                    ),
                    Color::RED
                );
                continue;
            }

            //run module installer
            try {
                $moduleInstaller->install($console);
            } catch (InstallException $e) {
                //catch fatal errors, so it doesn't continue
            }

            //if there were any errors
            if ($moduleInstaller->getErrors()) {
                $console->writeLine("Errors Occured: ", Color::RED);

                foreach ($moduleInstaller->getErrors() as $error) {
                    $console->writeLine($error, Color::RED);
                }
            }
        }
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
