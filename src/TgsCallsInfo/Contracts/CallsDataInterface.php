<?php
namespace TgsCallsInfo\Contracts;

use TgsCallsInfo\Services\Customer;

interface CallsDataInterface
{
    public function parseDataFromRequest(string $fieldName = null);
    public function setData(array $data = []);
    public function getCustomersList():array;
    public function getCustomerById(int $id):Customer;

}