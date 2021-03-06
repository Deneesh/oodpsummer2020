<?php
/**
 *
 */
require_once 'class.dbobj7.php';
abstract class Setter extends DBObj
{
  function __construct($attributes)
  {
    try {
      foreach ($attributes as $key => $value) {
        $this->__set($key, $value);
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function __get($attribute)
  {
    if(array_key_exists($attribute, $this->_attributes)){
      return $this->_attributes[$attribute];
    }else{
      throw new Exception("No such attribute: ". $attribute );
    }
  }

  public function __set($attribute, $value)
  {
    if(array_key_exists($attribute, $this->_attributes)){
      $function_name = "_set_" . $attribute;
      try {
        $this->$function_name($value);
      } catch (Exception $e) {
        throw $e;
      }
    }else{
      throw new Exception("No such attribute: ". $attribute );
    }
  }

  protected function _set_id($value)
  {
    try {
      $this->_attributes["id"] = $this->_int_validity($value);
    } catch (Exception $e) {
      throw new Exception($e->getMessage() . "id");
    }
  }

  protected function _int_validity($value)
  {
    if( $value >= 0 && ($value === 0 || filter_var($value, FILTER_VALIDATE_INT))){
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }else{
      throw new Exception("Invalid Integer: ");
    }
  }

  protected function _string_validity($value, $length)
  {
    if(is_string($value) && strlen(trim($value)) > 0
                         && strlen(trim($value)) <= $length) {
        return filter_var(trim($value), FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Invalid String");
    }
  }

}


?>
