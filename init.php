<?php
namespace Bolt\Extension\FaDoe\SymfonyAsset;

if (isset($app)) {
    $app['extensions']->register(new Extension($app));
}
