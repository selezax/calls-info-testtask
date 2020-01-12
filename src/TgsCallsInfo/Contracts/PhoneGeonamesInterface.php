<?php
namespace TgsCallsInfo\Contracts;


interface PhoneGeonamesInterface
{
    public function parseDataFromFile();
    public function numberCompareContinent(int $number, string $continent):bool;
    public function getPrefixNumber(int $number):string;
}