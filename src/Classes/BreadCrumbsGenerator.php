<?php namespace Morningtrain\WP\Breadcrumbs\Classes;

use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Archive;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\FrontPage;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Home;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Search;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Singular;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Status404;
use Morningtrain\WP\Breadcrumbs\Classes\Breadcrumbs\Term;

class BreadCrumbsGenerator {

    protected string $separator = ' > ';
    protected bool $prefixWithFrontPage = true;
    protected bool $hideOnFrontPage = false;

    /**
     * Set separator between each breadcrumb
     * @param  String  $separator
     * @return $this
     */
    public function separator(String $separator) : static
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Hide the Frontpage URL and title as first breadcrumb
     * @return $this
     */
    public function hidePrefixedFrontPagePart() : static
    {
        $this->prefixWithFrontPage = false;

        return $this;
    }

    /**
     * Hide breadcrumps on home
     * @return $this
     */
    public function hideOnFrontPage() : static
    {
        $this->hideOnFrontPage = false;

        return $this;
    }

    /**
     * Get alle Breadcrumbs
     * @return BreadCrumb[]
     */
    public function getBreadcrumbs() : array
    {
        $parts = [];

        // Get Home
        if($this->prefixWithFrontPage) {
            $parts[] = new FrontPage();
        }

        // If is front page, we do not need to display more
        if(is_front_page()) {
            return $parts;
        }

        // If is search page
        if(is_search()) {
            $parts[] = new Search();

            return $parts;
        }

        // If page does not exist
        if(is_404()) {
            $parts[] = new Status404();

            return $parts;
        }

        if(is_home()) {
            $parts[] = new Home();

            return $parts;
        }

        $archive = Archive::getBreadcrumb();

        if(!empty($archive)) {
            $parts[] = $archive;
        }

        $parts = array_merge($parts, Term::getBreadcrumbs());

        if(is_archive()) {
            return $parts;
        }

        // Get Singular parts
        if(is_singular()) {
            $parts = array_merge($parts, Singular::getBreadcrumbs());
        }

        return $parts;
    }

    /**
     * Render HTML
     */
    public function render() : void
    {
        $parts = $this->getBreadcrumbs();
        $htmlParts = [];

        foreach($parts as $part) {
            $htmlParts[] = $part->getHtml();
        }

        echo implode($this->separator, $htmlParts);
    }
}
