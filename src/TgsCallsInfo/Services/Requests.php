<?php
namespace TgsCallsInfo\Services;

use TgsCallsInfo\Contracts\RequestsInterface;

class Requests implements RequestsInterface
{
    /**
     * @param string $prop
     * @param null $default
     * @return null
     * @throws \Exception
     */
    public static function file(string $prop, $default = null){
        try {
            if ( isset($_FILES[$prop]))
                return $_FILES[$prop];

            else
                return  $default;

        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param string $prop
     * @param null $default
     * @return null
     * @throws \Exception
     */
    public static function get(string $prop, $default = null){
        try {

            if (isset($_REQUEST[$prop]))
                $_prop = $_REQUEST[$prop];
            else
                $_prop = $default;

            return $_prop;

        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param array $validate
     * @return bool
     */
    public function validate(array $validate = []):bool {
        try {
            $fieldsResult = count($validate);
            if (!$fieldsResult)
                return false;

            foreach ($validate as $field => $rules) {
                $fieldsResult -= $this->fieldRules($field, $rules);
            }

            return (bool) !$fieldsResult;

        } catch (\Exception $e){
            die($e->getTraceAsString());
        }
    }

    /**
     * @param string $field
     * @param array $rules
     * @return int
     */
    protected function fieldRules(string $field, array $rules = []):int {
        $valid = count($rules);

        foreach ($rules as $rule){
            $r = explode('|', $rule)[0];
            $nameF = $r . 'Validate';
            $valid -= $this->$nameF($field, $rule);
        }

        return $valid;
    }

    protected function requiredValidate($field):int {
        return (int) !empty($_REQUEST[$field]);
    }

    protected function fileValidate($field):int {
        return (int) !empty($_FILES[$field]);
    }

    protected function mimeValidate($field, $rule):int {
        $v = false;
        if(!empty($_FILES[$field])){
            $r = explode('|', $rule)[1];
            $v = $_FILES[$field]['type'] == $r;
        }

        return (int) $v;
    }
}