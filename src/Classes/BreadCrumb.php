<?php namespace Morningtrain\WP\Breadcrumbs\Classes;

class BreadCrumb {

    /**
     * Construct BreadCrumb
     * @param  string  $title
     * @param  string  $url
     * @param  bool  $isCurrent is BreadCrumb current displayed page?
     */
    public function __construct(protected string $title = '', protected string $url = '', protected bool $isCurrent = false)
    {
    }

    /**
     * Get BreadCrumb title
     * @return string
     */
    public function getTitle() : string
    {
        if(isset($this->title)) {
            return $this->title;
        }

        return '';
    }

    /**
     * Get BreadCrumb URL
     * @return string
     */
    public function getUrl() : string
    {
        if(isset($this->url)) {
            return $this->url;
        }

        return '';
    }

    /**
     * Is BreadCrumb current displayed page?
     * @return bool
     */
    public function isCurrent() :bool
    {
        return $this->isCurrent;
    }

    /**
     * Get HTML
     * @return string
     */
    public function getHtml() : string
    {
        if($this->isCurrent()) {
            return "<span class='current' aria-current='page'>{$this->getTitle()}</span>";
        }

        if(empty($this->getUrl())) {
            return "<span>{$this->getTitle()}</span>";
        }

        return "<a href='{$this->getUrl()}'>{$this->getTitle()}</a>";
    }
}
