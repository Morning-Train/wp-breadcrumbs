<?php namespace Morningtrain\WP\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumbsGenerator;

class Breadcrumbs {

    /**
     * Initialize a new breadcrump generator
     * @return BreadCrumbsGenerator
     */
    public static function compose() : BreadCrumbsGenerator
    {
        return new BreadCrumbsGenerator();
    }
}
