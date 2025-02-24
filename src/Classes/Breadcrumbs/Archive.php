<?php namespace Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs;

use Morningtrain\WP\Breadcrumbs\Classes\BreadCrumb;
use WP_Post_Type;

class Archive {

    public static function getBreadcrumb(WP_Post_Type $postType = null, array $excludedPostTypeArchives = []) : ?BreadCrumb
    {
        if(empty($postType)) {
            $postType = static::getPostType();

            if(empty($postType)) {
                return null;
            }
        }

        if (in_array($postType, $excludedPostTypeArchives)) {
            return null;
        }

        $postTypeObject = get_post_type_object($postType);

        $archiveLink = get_post_type_archive_link($postType);

        // If no archive link
        if(empty($archiveLink) || empty($postTypeObject)) {
            return null;
        }

        $title = $postTypeObject->labels->name ?? $postType;

        // If post type is post, then get the title from the post archive page
        if($postType === 'post') {
            $pageForPosts = get_option('page_for_posts');

            $frontPage = get_option('page_on_front');

            if($pageForPosts === $frontPage) {
                return null;
            }

            if(!empty($pageForPosts)) {
                $_title = get_the_title($pageForPosts);

                if(!empty($_title)) {
                    $title = $_title;
                }
            }
        }

        $title = apply_filters('post_type_archive_title', $title, $postType);

        if(empty($title)) {
            return null;
        }

        return new BreadCrumb(
            $title,
            $archiveLink,
            is_post_type_archive($postType)
        );
    }

    protected static function getPostType() : ?string
    {
        $postType = get_post_type();

        if(!empty($postType)) {
            return $postType;
        }

        // If is term
        $currentTerm = get_queried_object();

        if(!is_a($currentTerm, 'WP_Term')) {
            return null;
        }

        $taxonomy = get_taxonomy($currentTerm->taxonomy);

        if(!empty($taxonomy->object_type) && count($taxonomy->object_type) === 1) {
            return array_values($taxonomy->object_type)[0];
        }

        return null;
    }
}
