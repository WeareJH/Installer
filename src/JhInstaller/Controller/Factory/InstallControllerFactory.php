<?php

namespace JhInstaller\Controller\Factory;

use JhInstaller\Controller\InstallController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class InstallControllerFactory
 * @package JhInstaller\Controller\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return InstallController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //get parent locator
        $serviceLocator = $serviceLocator->getServiceLocator();

        return new InstallController(
            $serviceLocator->get('JhInstaller\Install\Installer'),
            $serviceLocator->get('Console')
        );
    }
}
