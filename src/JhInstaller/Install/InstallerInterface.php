<?php

namespace JhInstaller\Install;

use Zend\Console\Adapter\AdapterInterface;

/**
 * Interface InstallerInterface
 * @package JhInstaller\Install
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
interface InstallerInterface
{
    /**
     * Perform the install
     *
     * @param AdapterInterface $console
     * @return void
     */
    public function install(AdapterInterface $console);

    /**
     * Get An Array of Error Messages
     * which may have occurred during the installation
     *
     * @return array
     */
    public function getErrors();
}
