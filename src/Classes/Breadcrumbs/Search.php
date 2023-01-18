<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;

class Search extends BreadCrumb {

    public function getTitle() : string
    {
        return wp_get_document_title();
    }

    public function getUrl() : string
    {
        return get_search_link();
    }

    public function isCurrent() : bool
    {
        return is_search();
    }
}