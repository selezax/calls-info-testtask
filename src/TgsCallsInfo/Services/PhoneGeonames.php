<?php

namespace TgsCallsInfo\Services;


use TgsCallsInfo\Contracts\PhoneGeonamesInterface;

class PhoneGeonames implements PhoneGeonamesInterface
{
    protected $dataList;
    protected $file = 'countryInfo.txt';
    protected $fields = [
        'ISO',
        'ISO3',
        'ISONumeric',
        'fips',
        'Country',
        'Capital',
        'AreaInSqKm',
        'Population',
        'Continent',
        'tld',
        'CurrencyCode',
        'CurrencyName',
        'Phone',
        'PostalCodeFormat',
        'PostalCodeRegex',
        'Languages',
        'geonameid',
        'neighbours',
        'EquivalentFipsCode'
    ];

    private static $instances = [];

    /**
     * PhoneGeonames constructor.
     */
    protected function __construct () {
        $this->parseDataFromFile();
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
     * @return PhoneGeonames
     */
    public static function getInstance(): PhoneGeonames
    {
        $cls = static::class;
        if (!isset(static::$instances[$cls])) {
            static::$instances[$cls] = new static;
        }

        return static::$instances[$cls];
    }

    /**
     * @return $this
     */
    public function parseDataFromFile(){
        try{
            $row = 1;

            if (($handle = fopen($this->file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 0, "\t")) !== FALSE) {
                    if($data[0][0] == '#') continue;
                    $num = count($data);
                    for ($c=0; $c < $num; $c++) {
                        $this->dataList[$row][$this->fields[$c]] = $data[$c];
                    }
                    $row++;
                }
                fclose($handle);
            }
        } catch (\Exception $e){
            die($e->getTraceAsString());
        }

        return $this;
    }

    /**
     * @param int $number
     * @param string $continent
     * @return bool
     */
    public function numberCompareContinent(int $number, string $continent):bool {
        $prefix = $this->getPrefixNumber($number);
        $result = array_filter($this->dataList, function($v) use($prefix){
            return $v['Phone'] == $prefix;
        }) ;
        $result = array_shift($result);
        return $result['Continent'] == $continent;
    }

    /**
     * @param int $number
     * @return string
     */
    public function getPrefixNumber(int $number):string {
        return (string) substr($number, 0, 3);
    }
}