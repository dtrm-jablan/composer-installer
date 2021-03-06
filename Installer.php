<?php namespace Determine\Library\Utility\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * Handles installation of Determine apps/ and appli/ packages via composer
 */
class Installer extends LibraryInstaller
{
    //******************************************************************************
    //* Constants
    //******************************************************************************

    /**
     * @var string The prefix of the Determine package type
     */
    const MODULE_APP_PREFIX = 'determine/module-';
    /**
     * @var string The prefix of the Determine package type
     */
    const MODULE_APP_TYPE = 'determine-module';
    /**
     * @var string The path where modules reside
     */
    const MODULE_APP_PATH = '../apps';
    /**
     * @var string The prefix of the Determine tenant type
     */
    const MODULE_TENANT_PREFIX = 'determine/tenant-';
    /**
     * @var string The prefix of the Determine tenant type
     */
    const MODULE_TENANT_TYPE = 'determine-tenant';
    /**
     * @var string The path where tenants reside
     */
    const MODULE_TENANT_PATH = '../appli';

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /** {@inheritDoc} */
    public function getInstallPath(PackageInterface $package)
    {
        static $_cache = null;

        $_prefix = null;
        $_packageName = $package->getPrettyName();

        if (isset($_cache[$_packageName])) {
            return $_cache[$_packageName];
        }

        switch ($_type = $package->getType()) {
            case static::MODULE_APP_TYPE:
                $_prefix = static::MODULE_APP_PREFIX;
                $_pathPrefix = static::MODULE_APP_PATH;
                //$this->io->write('Determine module package installing to ', false);
                break;

            case static::MODULE_TENANT_TYPE:
                $_prefix = static::MODULE_TENANT_PREFIX;
                $_pathPrefix = static::MODULE_TENANT_PATH;
                //$this->io->write('Determine tenant package installing to ', false);
                break;

            default:
                throw new \InvalidArgumentException('This installer cannot deal with "' . $_type . '" packages.');
        }

        if (false === stripos($_packageName, $_prefix)) {
            throw new \InvalidArgumentException('Unable to install package. The package name must start with "' . $_prefix . '"');
        }

        //  Let the world know where we are!
        $GLOBALS['__determine_vendor_dir'] = $this->vendorDir;

        return $_cache[$_packageName] = rtrim($_pathPrefix, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . str_replace($_prefix, null, $_packageName);
    }

    /** {@inheritDoc} */
    public function supports($packageType)
    {
        return in_array($packageType, [static::MODULE_APP_TYPE, static::MODULE_TENANT_TYPE]);
    }
}
