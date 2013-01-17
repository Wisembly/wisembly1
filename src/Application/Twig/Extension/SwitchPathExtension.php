<?php

namespace Application\Twig\Extension;

use Silex\Application;
use SilexCMS\Repository\GenericRepository;
use SilexCMS\Application as SilexCMSApplication;

class SwitchPathExtension extends \Twig_Extension
{
    private $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getName() {
        return "SilexCMS_SwitchPath";
    }

    public function getFunctions()
    {
        return array(
            "switch_path"        => new \Twig_Function_Method($this, "switch_path"),
        );
    }

    public function switch_path(SilexCMSApplication $application, $locale)
    {
        $parameters = array();

        $app = new SilexCMSApplication(array(
            'locale'        => $locale,
            'db.options'    => $this->app['silexcms_full_db_options'][$locale],
        ));

        if (isset($application['silexcms.dynamic.route'])) {
            $repository = new GenericRepository($application['db'], $application['silexcms.dynamic.route']['table']);
            $param = $repository->findOneBy($application['silexcms.dynamic.route']['route_params']);

            $repository = new GenericRepository($app['db'], $application['silexcms.dynamic.route']['table']);
            $param = $repository->findOneBy($param['id']);
            $keys = array_keys($application['silexcms.dynamic.route']['route_params']);
            $parameters = array($keys[0] => $param[$keys[0]]);
        } else {
            $parameters = $application['request']->attributes->get('_route_params');
        }

        return str_replace('/'. $application['country'] . '/', '/'. $locale . '/',  $this->app['url_generator']->generate($application['request']->attributes->get('_route'), $parameters, true));
    }
}