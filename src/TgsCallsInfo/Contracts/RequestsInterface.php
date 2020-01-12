<?php
namespace TgsCallsInfo\Contracts;


interface RequestsInterface
{
    public static function get(string $prop, $default = null);
    public function validate(array $validate = []):bool;
    public static function file(string $prop, $default = null);
}