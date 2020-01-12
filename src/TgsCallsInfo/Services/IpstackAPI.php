<?php
namespace TgsCallsInfo\Services;


use TgsCallsInfo\Contracts\IpstackAPIInterface;

class IpstackAPI implements IpstackAPIInterface
{
    const KEY_API = 'd9f000dbc0237078dfb39bf8033d244c';
    const URL_API = 'http://api.ipstack.com/';
    protected $dataList = [];

    private static $instances = [];

    /**
     * IpstackAPI constructor.
     */
    protected function __construct () {
    }

    private function __clone () {}

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * @return IpstackAPI
     */
    public static function getInstance(): IpstackAPI
    {
        $cls = static::class;
        if (!isset(static::$instances[$cls])) {
            static::$instances[$cls] = new static;
        }

        return static::$instances[$cls];
    }

    /**
     * @param string $ip
     * @return string
     * @throws \Exception
     */
    public function getContinentByIp(string $ip):string {
        try {
            if (!array_key_exists($ip, $this->dataList)) {
                $this->getItemByIp($ip);
            }

            return $this->dataList[$ip]['continent_code'];

        }  catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param $ip
     * @return $this
     * @throws \Exception
     */
    protected function getItemByIp(string $ip){
        try{
            $jsondata = file_get_contents($this->buildURL($ip));
            $this->dataList[$ip] = (array) json_decode($jsondata);
            return $this;

        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param string $ip
     * @return string
     */
    protected function buildURL(string $ip):string {
        return sprintf('%s%s?access_key=%s', self::URL_API, $ip, self::KEY_API);
    }
}