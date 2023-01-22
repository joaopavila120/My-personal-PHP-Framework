<?php

namespace app\core;

/**
 * its abstract to avoid creating instances of this class, to force create instances of subclasses
 * @author joao.avila
 * @package app\core
 */
abstract class Model
{
  public const RULE_REQUIRED = "required"; //required fields
  public const RULE_EMAIL    = "email";    //rule to valid email
  public const RULE_MIN      = "min";      //min and max length
  public const RULE_MAX      = "max";
  public const RULE_MATCH    = "match";  //password match

  public array $errors = [];

  public function loadData($data)
  {
    //taking the data and assigning to the properties of the model
    foreach ($data as $key => $value)
      if (property_exists($this, $key))
        $this->{$key} = $value;
  }

  abstract public function rules(): array;

  public function validate()
  {

    //here im iterating the rules arrays, and than iterating each individual attribute
    foreach ($this->rules() as $attribute => $rules)
    {
      $value = $this->{$attribute};

      foreach ($rules as $rule)
      {
        $ruleName = $rule;
        //test if it is an array
        if (!is_string($ruleName))
          $ruleName = $rule[0];

        //ex: this case is like the firstname is not providad from the user 
        if ($ruleName === self::RULE_REQUIRED && !$value)
          $this->addErrors($attribute, self::RULE_REQUIRED);

        if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
          $this->addErrors($attribute, self::RULE_EMAIL);
        
        if ($ruleName === self::RULE_MIN && strlen($value) < $rule["min"])
          $this->addErrors($attribute, self::RULE_MIN, $rule);

        if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"])
          $this->addErrors($attribute, self::RULE_MAX, $rule);

        if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule["match"]})
          $this->addErrors($attribute, self::RULE_MATCH, $rule);
      }
    }

    //if array of errors is empty must return true, wthich means there are no errors
    return empty($this->errors);
  }

  public function addErrors(string $attribute, string $rule, $params = [])
  {
    $message = $this->errorMessages()[$rule] ?? "";

    //replace "min" and "max" on error message for the values set in the controller
    foreach ($params as $key => $value)
      $message = str_replace("{{$key}}", $value, $message);

    $this->errors[$attribute][] = $message;
  }

   public function errorMessages()
   {
    return [
      self::RULE_REQUIRED => "This field is required",
      self::RULE_EMAIL    => "This field must be a valid email address",
      self::RULE_MIN      => "Min length of this field must be {min}",
      self::RULE_MAX      => "Max length of this field must be {max}",
      self::RULE_MATCH    => "This field must be the same as {match}"
    ];
   }

   /**
    * test if html field has error
    */
   public function hasError($attribute)
   {
    //if inside errors exist something for attributes
    return $this->errors[$attribute] ?? false;
   }

   public function getFirstError($attribute)
   {
    return $this->errors[$attribute][0] ?? false;
   }
}
