<?php

namespace JhInstaller;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * Class Module
 * @package JhInstaller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ConsoleUsageProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * @param Console $console
     * @return array|null|string
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'install' => 'Install All Modules which implement "Installable" Interface'
        ];
    }
}
