<?php

namespace Application\Twig\Extension;

use Silex\Application;

class StrReplaceExtension extends \Twig_Extension
{
    private $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getName() {
        return "SilexCMS_StrReplace";
    }

    public function getFunctions()
    {
        return array(
            "str_replace"        => new \Twig_Function_Method($this, "str_replace"),
        );
    }

    public function str_replace($needle, $haystack, $string)
    {
        return str_replace($needle, $haystack, $string);
    }
}