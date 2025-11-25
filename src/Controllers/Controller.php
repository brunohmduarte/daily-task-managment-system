<?php

namespace Application\Controllers;

class Controller
{
    public $cssExternal = [];
    public $jsExternal = [];

    protected $linkCssExternal = '<link href="%s" rel="stylesheet" type="text/css" />';
    protected $linkJsExternal = '<script src="%s" type="text/javascript"></script>';

    public function __construct()
    {
    }

    /**
     * Set an external CSS file to be linked in the page.
     * 
     * @param string $filepath The path to the CSS file.
     */
    public function setCssExternal(string $filepath): void 
    {
        $this->cssExternal[] = $filepath;
    }

    /**
     * Set an external JavaScript file to be linked in the page.
     * 
     * @param string $filepath The path to the JavaScript file.
     */
    public function setJsExternal(string $filepath): void 
    {
        $this->jsExternal[] = $filepath;
    }

    /**
     * Return a string of HTML links to all external CSS files that were set using setCssExternal.
     * 
     * @return string
     */
    public function getCssExternal() 
    {
        $links = '';
        foreach ($this->cssExternal as $link) {
            $links .= sprintf($this->linkCssExternal, dirname(__DIR__, 2).'/'.ltrim($link));
        }

        return $links;
    }

    /**
     * Return a string of HTML links to all external JavaScript files that were set using setJsExternal.
     * 
     * @return string A string of HTML links to all external JavaScript files.
     */
    public function getJsExternal() 
    {
        $links = '';
        foreach ($this->jsExternal as $link) {
            $links .= sprintf($this->linkJsExternal, dirname(__DIR__, 2).'/'.ltrim($link));
        }

        return $links;
    }
}