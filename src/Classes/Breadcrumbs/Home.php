<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;

class Home extends BreadCrumb {

    public function getTitle() : string
    {
        return get_the_title(get_option('page_for_posts'));
    }

    public function getUrl() : string
    {
        return get_post_type_archive_link('post');
    }

    public function isCurrent() : bool
    {
        return is_home();
    }
}