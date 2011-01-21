<?php

namespace Bundle\Kris\FacebookBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KrisFacebookBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
