<?php namespace Determine\Library\Composer\Installer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param \Composer\Composer       $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $_installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($_installer);
    }
}
