<?php
namespace  bga\app\validation;

require_once 'FormValidator.php';
require_once 'GameNameInput.php';

class GameFormValidator extends FormValidator
{
    protected function configure()
    {
        // parameters: name/key, label

        return array(
            "name"=> new GameNameInput("name", "Game name")
        );
    }
}
