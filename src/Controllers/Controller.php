<?php

namespace Application\Controllers;

class Controller
{
    public $cssExternal = [];
    public $jsExternal = [];
    public $action = 'list';

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
    public function getCssExternal(bool $urlDefault = true) 
    {
        $links = '';
        // $domain = dirname(__DIR__, 2).'/';
        $domain = URL_BASE;

        foreach ($this->cssExternal as $link) {
            $url = ($urlDefault) ? $domain .'/'. ltrim($link) : $link;
            $links .= sprintf($this->linkCssExternal, $url);
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
        $domain = URL_BASE;
        foreach ($this->jsExternal as $link) {
            $links .= sprintf($this->linkJsExternal, $domain .'/'. ltrim($link));
        }

        return $links;
    }

    public function defineAction(): void
    {
        if (isset($_GET['action'])) {
            $this->action = $_GET['action'];
        } 
    }
}