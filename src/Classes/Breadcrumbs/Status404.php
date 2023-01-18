<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;

class Status404 extends BreadCrumb {

    public function getTitle() : string
    {
        return wp_get_document_title();
    }

    public function getUrl() : string
    {
        return '';
    }

    public function isCurrent() : bool
    {
        return is_404();
    }
}