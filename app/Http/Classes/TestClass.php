<?php

namespace App\Http\Classes;

use App\Attributes\MyFirstAttribute;

#[MyFirstAttribute('my-value', myThirdArgument: "Third Arg")]
class TestClass
{

}