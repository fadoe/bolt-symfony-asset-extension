<?php
namespace Bolt\Extension\FaDoe\SymfonyAsset\Asset;

use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PackageFactory
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * PackageFactory constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param string|null $version
     * @param string|null $versionFormat
     * @param string|null $basePath
     * @param array|null  $baseUrls
     *
     * @return PackageInterface
     */
    public function createService($version = null, $versionFormat = null, $basePath = null, array $baseUrls = null)
    {
        $strategy = $this->createStrategy($version, $versionFormat);
        $package = $this->createPackage($strategy, $basePath, $baseUrls);

        return $package;
    }

    /**
     * @param string $version
     * @param string $versionFormat
     *
     * @return VersionStrategyInterface
     */
    private function createStrategy($version, $versionFormat)
    {
        if (null === $version) {
            $strategy = new EmptyVersionStrategy();
        } else {
            $strategy = new StaticVersionStrategy($version, $versionFormat);
        }

        return $strategy;
    }

    /**
     * @param VersionStrategyInterface $strategy
     *
     * @param string|null              $basePath
     * @param array                    $baseUrls
     *
     * @return PackageInterface
     */
    private function createPackage(VersionStrategyInterface $strategy, $basePath = null, array $baseUrls = null)
    {
        $context = new RequestStackContext($this->requestStack);

        if (null !== $basePath) {
            $package = new PathPackage($basePath, $strategy, $context);
        } elseif (null !== $baseUrls) {
            $package = new UrlPackage($baseUrls, $strategy, $context);
        } else {
            $package = new Package($strategy, $context);
        }

        return $package;
    }
}
