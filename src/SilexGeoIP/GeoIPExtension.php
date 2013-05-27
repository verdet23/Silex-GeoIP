<?php
namespace SilexGeoIP;

use Silex\Application;
use Silex\ServiceProviderInterface;
use SilexGeoIP\GeoIP\GeoIP;

/**
 * Sphinx search extension for Silex
 */
class GeoIPExtension implements ServiceProviderInterface
{
    /**
     * @param \Silex\Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param \Silex\Application $app
     * @throws \Exception
     */
    public function register(Application $app)
    {
        $app['geoip.default_options'] = array(
            'include_file' => 'geoip.inc',
            'db_path' => '/usr/local/share/GeoIP/GeoIP.dat',
            'flags' => 0
        );

        $app['geoip.options.initializer'] = $app->protect(
            function () use ($app) {
                static $initialized = false;

                if ($initialized) {
                    return;
                }

                $initialized = true;


                $tmp = $app['geoip.options'];

                foreach ($tmp as $name => &$options) {
                    if (isset($app['geoip.default_options'][$name])) {
                        $options = array_replace($app['geoip.default_options'][$name], $options);
                    }

                }

                if (!file_exists($tmp['db_path'])) {
                    throw new \Exception("DB file not exist!");
                }

                $app['geoip.options'] = $tmp;
            }
        );

        $app['geoip'] = $app->share(
            function ($app) {
                $app['geoip.options.initializer']();

                $options = $app['geoip.options'];

                $geoIP = new GeoIP($options['include_file'], $options['db_path'], $options['flags']);

                return $geoIP;
            }
        );
    }
}
