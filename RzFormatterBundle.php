<?php

namespace Rz\FormatterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RzFormatterBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataFormatterBundle';
    }
}
