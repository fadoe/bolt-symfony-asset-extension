<?php
namespace Bolt\Extension\FaDoe\SymfonyAsset\Twig;

use Symfony\Component\Asset\Packages;

/**
 * Twig extension for the Symfony Asset component.
 *
 */
class AssetExtension extends \Twig_Extension
{
    private $packages;

    /**
     * @param Packages $packages
     */
    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('asset', array($this, 'getAssetUrl')),
            new \Twig_SimpleFunction('asset_version', array($this, 'getAssetVersion')),
        );
    }

    /**
     * Returns the public url/path of an asset.
     *
     * If the package used to generate the path is an instance of
     * UrlPackage, you will always get a URL and not a path.
     *
     * @param string $path        A public path
     * @param string $packageName The name of the asset package to use
     *
     * @return string The public path of the asset
     */
    public function getAssetUrl($path, $packageName = null)
    {
        return $this->packages->getUrl($path, $packageName);
    }

    /**
     * Returns the version of an asset.
     *
     * @param string $path        A public path
     * @param string $packageName The name of the asset package to use
     *
     * @return string The asset version
     */
    public function getAssetVersion($path, $packageName = null)
    {
        return $this->packages->getVersion($path, $packageName);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'asset';
    }
}
