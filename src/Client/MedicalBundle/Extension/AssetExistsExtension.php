<?php

namespace Client\MedicalBundle\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class AssetExistsExtension extends \Twig_Extension
{
    private $kernel;

    public function __construct(KernelInterface $kernel) {
        $this->kernel = $kernel;
    }

    public function getFunctions() {
        return array('asset_exists' => new \Twig_Function_Method($this, 'asset_exists'));
    }

    public function asset_exists($path) {
        $webRoot = realpath($this->kernel->getRootDir() . '/web/');
        $toCheck = realpath($webRoot . $path);
        if (!is_file($toCheck)) {
            return false;
        }
        if (strncmp($webRoot, $toCheck, strlen($webRoot)) !== 0) {
            return false;
        }

        return true;
    }

    public function getName() {
        return 'asset_exists';
    }

}

