<?php

namespace VnCoder\Core\Controllers;
use VnCoder\Core\Models\VnConfig;
use Barryvdh\Debugbar\Facade as Debugbar;

class VnController extends BaseController
{
    protected $metaData;
    protected $setData = array();
    protected $extraHeader = '';
    protected $extraFooter = '';
    protected $extraHeaderCSS = '';
    protected $extraHeaderJS = '';
    protected $extraFooterJS = '';
    protected $bladeNamespace = 'frontend';

    protected $version = TIME_NOW;
    protected $debugbar = false;
    protected $isAdmin = false;

    public function __construct()
    {
        $this->coreInit();
        $this->siteInit();
    }

    protected function coreInit()
    {
        // Khoi tao Meta Data - Default
        $this->metaData = app('VnConfig')->webConfig();
        $this->metaData->baseUrl = url('/').'/';
        $this->metaData->currentUrl = url()->current();
        // Fix Debugbar CSS
        $debugbar = vn_cookie('_debugbar');
        if ($debugbar == 'on') {
            $this->debugbar = true;
            $this->header($this->debugbarStyle());
        }
    }

    protected function debug($object){
        if($this->debugbar){
            DebugBar::info($object);
        }
    }

    protected function siteInit()
    {
    }

    protected function render($bladePath)
    {
        if (view()->exists($bladePath)) {
            $this->setData['metaData'] = $this->metaData;
            $this->setData['extraHeader'] = $this->extraHeader;
            $this->setData['extraHeaderCSS'] = $this->extraHeaderCSS;
            $this->setData['extraHeaderJS'] = $this->extraHeaderJS;
            $this->setData['extraFooter'] = $this->extraFooter;
            $this->setData['extraFooterJS'] = $this->extraFooterJS;
            $this->setData['_version'] = $this->version;
            $this->setData['_currentUrl'] = url()->current();
            return view($bladePath, $this->setData);
        } else {
            die("View: Path $bladePath not exists.");
        }
    }

    protected function views($blade, $bladeLayout = 'default')
    {
        if ($this->isAdmin) {
            $bladeRender = 'backend::'.$blade; // Sử dụng riêng cho phần admin kế thừa
        } else {
            $bladeRender = $this->bladeNamespace.'::pages.'.$blade;
        }
        $this->setData['bladeRender'] = $bladeRender;
        $bladePath = $this->bladeNamespace.'::views.'.$bladeLayout;
        return $this->render($bladePath);
    }

    protected function header($text)
    {
        $this->extraHeader .= $text . "\n";
    }

    protected function footer($text)
    {
        $this->extraFooter .= $text . "\n";
    }

    public function linkCSS($linkFile)
    {
        if (strpos($linkFile, 'http://') === false && strpos($linkFile, 'https://') === false) {
            $linkFile = url( $linkFile) . "?v=" . $this->version;
        }
        $stylesheet = '<link rel="stylesheet" type="text/css" href="' . $linkFile . '">';
        if (strpos($this->extraHeaderCSS, $stylesheet) === false) {
            $this->extraHeaderCSS .= $stylesheet."\n";
        }
    }

    public function linkJS($linkFile, $header = false)
    {
        if (strpos($linkFile, 'http://') === false && strpos($linkFile, 'https://') === false) {
            $linkFile = url($linkFile) . "?v=" . $this->version;
        }
        $script = '<script type="text/javascript" src="' . $linkFile . '"></script>';

        if ($header) {
            if (strpos($this->extraHeaderJS, $script) === false) {
                $this->extraHeaderJS .= $script . "\n";
            }
        } else {
            if (strpos($this->extraFooter, $script) === false) {
                $this->extraFooter .= $script . "\n";
            }
        }
    }

    protected function debugbarStyle()
    {
        return <<<EOF
<style>
    ul.phpdebugbar-widgets-list li.phpdebugbar-widgets-list-item .phpdebugbar-widgets-params{margin:5px !important;}
    ul.phpdebugbar-widgets-timeline table.phpdebugbar-widgets-params .phpdebugbar-widgets-name{width:25% !important;}
    ul.phpdebugbar-widgets-timeline table.phpdebugbar-widgets-params{width:95% !important;}
    ul.phpdebugbar-widgets-list li.phpdebugbar-widgets-list-item .phpdebugbar-widgets-params{width:100% !important;}
    ul.phpdebugbar-widgets-timeline .phpdebugbar-widgets-measure{width:95% !important;}
    @media screen and (max-width: 600px) {
        span.phpdebugbar-indicator{display: none!important;}
    }
</style>
EOF;
    }
}
