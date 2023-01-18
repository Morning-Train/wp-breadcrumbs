<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;
use WP_Post;

class Singular {

    /**
     * @return BreadCrumb[]
     */
    public static function getBreadcrumbs() : array
    {
        $parts = [];

        if(!is_singular()) {
            return $parts;
        }

        $post_type = get_post_type();

        if(is_post_type_hierarchical($post_type)) {
            $parts = array_merge($parts, static::getAncestorParts(get_post()));
        }

        $singularPart = static::getBreadcrumb();

        if(!empty($singularPart)) {
            $parts[] = $singularPart;
        }

        return $parts;
    }

    public static function getBreadcrumb() : ?BreadCrumb
    {
        if(!is_singular()) {
            return null;
        }

        return new BreadCrumb(
            get_the_title(),
            get_the_permalink(),
            true
        );
    }

    public static function getAncestorParts(WP_Post $post) : array
    {
        $parts = [];

        while($post = get_post_parent($post)) {
            $parts[] = new BreadCrumb(
                get_the_title($post),
                get_the_permalink($post),
            );
        }

        return array_reverse($parts);
    }
}
