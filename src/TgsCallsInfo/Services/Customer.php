<?php
namespace TgsCallsInfo\Services;


use TgsCallsInfo\Contracts\CustomerInterface;

class Customer implements CustomerInterface
{
    private $data;
    private $id;
    protected $phoneInfo;
    protected $IpStack;


    public function __construct(int $id, array $data = []){
        $this->id = $id;
        $this->data = $data;
        $this->phoneInfo = PhoneGeonames::getInstance();
        $this->IpStack = IpstackAPI::getInstance();
    }

    /**
     * @return array
     */
    public function calculatingByContinent():array {
        $result = [];
        foreach ($this->data as $item){
            $continent = $this->IpStack->getContinentByIp($item['CustomerIP']);
            if($this->phoneInfo->numberCompareContinent($item['PhoneNumber'], $continent)){
                if(isset($result[$continent])){
                    $result[$continent]['number']++;
                    $result[$continent]['duration'] += $item['Duration'];
                }
                else{
                    $result[$continent]['number'] = 1;
                    $result[$continent]['duration'] = $item['Duration'];
                }
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getTotalNumberAllCalls():int {
        return (int) count($this->data);
    }

    /**
     * @return int
     */
    public function getTotalDurationAllCalls():int {
        $data = array_sum(array_column($this->data, 'Duration'));
        return (int) $data;
    }

    /**
     * @param int $time
     * @return string
     */
    public function convertSecondToFullTime(int $time):string {
        return (string) sprintf('%sh %smin %ssec',gmdate('H', $time),gmdate('i', $time),gmdate('s', $time));
    }

    /**
     * @param $name
     * @return int|string
     */
    public function __get($name)
    {
        switch ($name){

            case 'totalNumberAllCalls':
                return $this->getTotalNumberAllCalls();

            case 'totalDurationAllCalls':
                return $this->getTotalDurationAllCalls();

            default:
                return $name . ' Not Defined';
        }
    }

    /**
     * @return array
     */
    public function  __invoke(){
        return $this->data;
    }
}