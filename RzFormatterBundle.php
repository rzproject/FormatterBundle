<?php

/*
 * This file is part of the RzFormatterBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
