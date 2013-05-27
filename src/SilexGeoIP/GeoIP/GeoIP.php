<?php
namespace SilexGeoIP\GeoIP;

class GeoIP
{
    protected $geoIP;

    public function __construct($includeFile, $dbPath, $flags)
    {
        require_once __DIR__.'../../../vendor/' . $includeFile;

        $this->geoIP = geoip_open($dbPath, $flags);
    }
}
