<?php
namespace Bolt\Extension\FaDoe\SymfonyAsset;

use Bolt\BaseExtension;
use Bolt\Extension\FaDoe\SymfonyAsset\Asset\PackageFactory;
use Bolt\Extension\FaDoe\SymfonyAsset\Twig\AssetExtension;
use Symfony\Component\Asset\Packages;

class Extension extends BaseExtension
{
    public function initialize()
    {
        /**
         * @var \Twig_Environment $twig
         */
        $twig = $this->app['twig'];

        $packages = $this->getPackages();

        $this->app['twig'] = $this->app->share(
            $this->app->extend('twig', function () use ($twig, $packages) {
                    $twig->addExtension(new AssetExtension($packages));

                    return $twig;
                }
            )
        );
    }

    public function getName()
    {
        return "SymfonyAsset";
    }

    /**
     * @return Packages
     */
    private function getPackages()
    {
        $version = $this->config['version'];
        $versionFormat = $this->config['version_format'];
        $baseUrl = $this->config['base_url'];
        $basePath = $this->config['base_path'];
        $packages = new Packages();

        $defaultPackage = $this->getPackageFactory()->createService($version, $versionFormat, $basePath, $baseUrl);

        $packages->setDefaultPackage($defaultPackage);

        foreach ($this->config['packages'] as $name => $packageConfig) {
            $version = $packageConfig['version'];
            $versionFormat = $packageConfig['version_format'];
            $baseUrl = $packageConfig['base_url'];
            $basePath = $packageConfig['base_path'];

            $package = $this->getPackageFactory()->createService($version, $versionFormat, $baseUrl, $basePath);

            $packages->addPackage($name, $package);
        }

        return $packages;
    }

    private function getPackageFactory()
    {
        $requestStack = $this->app['request_stack'];

        return new PackageFactory($requestStack);
    }
}
