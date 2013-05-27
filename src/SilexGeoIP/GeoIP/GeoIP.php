<?php
namespace SilexGeoIP\GeoIP;

/**
 * GeoIP wrapper
 */
class GeoIP
{
    /**
     * @var GeoIP
     */
    protected $geoIP;

    /**
     * @param string $includeFile
     * @param string $dbPath
     * @param int    $flags
     */
    public function __construct($includeFile, $dbPath, $flags)
    {
        require_once __DIR__.'/../../../vendor/' . $includeFile;

        $this->geoIP = geoip_open($dbPath, $flags);
    }

    /**
     * @param string $ip
     *
     * @return \geoiprecord|int|null
     */
    public function getRecordByIP($ip)
    {
        return geoip_record_by_addr($this->geoIP, $ip);
    }
}
