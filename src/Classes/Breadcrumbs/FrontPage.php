<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;

class FrontPage extends BreadCrumb {

    public function getTitle() : string
    {
        return get_the_title(get_option('page_on_front'));
    }

    public function getUrl() : string
    {
        return home_url();
    }

    public function isCurrent() : bool
    {
        return is_front_page();
    }
}