<?php

namespace Rz\FormatterBundle\Admin;

use Sonata\FormatterBundle\Admin\CkeditorAdminExtension as AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Adds browser and upload routes to the Admin.
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class CkeditorAdminExtension extends AdminExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection)
    {
        $collection->add('ckeditor_browser', 'ckeditor_browser', array(
            '_controller' => 'RzFormatterBundle:CkeditorAdmin:browser',
        ));

        $collection->add('ckeditor_upload', 'ckeditor_upload', array(
            '_controller' => 'RzFormatterBundle:CkeditorAdmin:upload',
        ));
    }
}
