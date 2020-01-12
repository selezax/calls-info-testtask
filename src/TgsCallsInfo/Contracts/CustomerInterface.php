<?php
namespace TgsCallsInfo\Contracts;


interface CustomerInterface
{
    public function calculatingByContinent():array;
    public function getTotalNumberAllCalls():int;
    public function getTotalDurationAllCalls():int;
    public function convertSecondToFullTime(int $time):string;

}