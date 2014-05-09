<?php

namespace JhInstaller\Install;

/**
 * Interface HubInstallable
 * @package JhInstaller\Install
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
interface Installable
{
    /**
     * @return string
     */
    public function getInstallService();
}
