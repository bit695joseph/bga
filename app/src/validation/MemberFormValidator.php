<?php
namespace  bga\app\validation;

require_once 'FormValidator.php';
require_once 'NameInput.php';
require_once 'EmailInput.php';
require_once 'PhoneInput.php';

class MemberFormValidator extends FormValidator
{
    protected function configure()
    {
        // parameters: name/key, label

        return array(
            "first_name"=> new NameInput("first_name", "First name"),
            "last_name"=> new NameInput("last_name", "Last name"),
            "email" => new EmailInput("email", "Email address"),
            "phone" => new PhoneInput("phone", "Phone number")
        );
    }
}
