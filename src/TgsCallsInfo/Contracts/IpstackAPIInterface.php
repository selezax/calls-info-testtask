<?php
namespace TgsCallsInfo\Contracts;


interface IpstackAPIInterface
{
    public function getContinentByIp(string $ip):string;
}