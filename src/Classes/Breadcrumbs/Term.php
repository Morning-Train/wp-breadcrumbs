<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;
use WP_Term;

class Term {

    /**
     * @param WP_Term|null $term
     * @return BreadCrumb[]
     */
    public static function getBreadcrumbs(?WP_Term $term = null) : array
    {
        $currentTerm = get_queried_object();

        if(empty($term)) {
            $term = static::getTerm();

            if(empty($term)) {
                return [];
            }
        }

        $parts = static::getAncestorParts($term);

        $parts[] = static::getBreadcrumb($term, $term === $currentTerm);

        return $parts;
    }

    public static function getAncestorParts(WP_Term $term) : array
    {
        $parts = [];

        $parents = get_ancestors($term->term_id, $term->taxonomy, 'taxonomy');

        foreach($parents as $parent) {
            $parent = get_term($parent);

            $parts[] = static::getBreadcrumb($parent);
        }

        return array_reverse($parts);
    }

    public static function getBreadcrumb(WP_Term $term, bool $isCurrent = false) : BreadCrumb
    {
        return new BreadCrumb(
            $term->name,
            get_term_link($term),
            $isCurrent
        );
    }

    protected static function getTerm() : ?WP_Term
    {
        $currentTerm = get_queried_object();

        if(is_a($currentTerm,'WP_Term')) {
            return $currentTerm;
        }

        if(!is_singular()) {
            return null;
        }

        $post = get_post();

        if(empty($post)) {
            return null;
        }

        $taxonomies = get_the_taxonomies($post);

        if(empty($taxonomies) || count($taxonomies) !== 1) {
            return null;
        }

        $taxonomy = array_keys($taxonomies)[0];

        $term = null;

        if(function_exists('yoast_get_primary_term')) {
            $term = get_term(yoast_get_primary_term($taxonomy, $post));
        }

        if(!empty($term)) {
            return $term;
        }

        $terms = get_the_terms($post, $taxonomy);

        if(!empty($terms) && count($terms) === 1) {
            return array_values($terms)[0];
        }

        return null;
    }
}
