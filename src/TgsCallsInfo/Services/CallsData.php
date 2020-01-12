<?php
namespace TgsCallsInfo\Services;

use TgsCallsInfo\Contracts\CallsDataInterface;

class CallsData implements CallsDataInterface
{
    private $fieldName;
    private $data;
    protected $fieldsCSV = ['CustomerID','CallDate','Duration','PhoneNumber','CustomerIP'];

    public function __construct(string $fieldName = null){
        if($fieldName)
            $this->fieldName = $fieldName;

    }

    /**
     * @param string|null $fieldName
     * @return $this
     * @throws \Exception
     */
    public function parseDataFromRequest(string $fieldName = null){
        if($fieldName)
            $this->fieldName = $fieldName;

        if(!$this->fieldName)
            throw new \Exception('fieldName not defined');

        try{
            $csv = Requests::file($this->fieldName);
            $row = 1;
            $fileCSV = $csv["tmp_name"] ;
            $_data = [];

            if (($handle = fopen($fileCSV, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    $num = count($data);
                    for ($c=0; $c < $num; $c++) {
                        $_data[$row][$this->fieldsCSV[$c]] = $data[$c];
                    }
                    $row++;
                }
                fclose($handle);
            }

            $this->setData($_data);
            unset($_data);
            return $this;

        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data = []){
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomersList():array {
        return array_unique(array_column($this->data, 'CustomerID'));
    }

    /**
     * @param int $id
     * @return Customer
     */
    public function getCustomerById(int $id):Customer{
        $data = array_filter($this->data, function($v) use ($id){
            return $v['CustomerID'] == $id;
        });

        return new Customer($id, $data);
    }


    /**
     * @return array
     */
    public function  __invoke(){
        return $this->data;
    }
}