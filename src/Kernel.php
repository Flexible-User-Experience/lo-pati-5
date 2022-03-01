<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public const PROD_ENV = 'prod';
    public const DEV_ENV = 'dev';
    public const PUBLIC_DIR = 'public';
}
