<?php
namespace Bolt\Extension\FaDoe\SymfonyAsset\Tests;

use Bolt\Tests\BoltUnitTest;
use Bolt\Extension\FaDoe\SymfonyAsset\Extension;

/**
 * Ensure that the ExtensionName extension loads correctly.
 *
 */
class ExtensionTest extends BoltUnitTest
{
    public function testExtensionRegister()
    {
        $app = $this->getApp();
        $extension = new Extension($app);
        $app['extensions']->register( $extension );
        $name = $extension->getName();
        $this->assertSame($name, 'SymfonyAsset');
        $this->assertSame($extension, $app["extensions.$name"]);
    }
}
