<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class MyFirstAttribute
{
    public function __construct(
        public string $myArgument,
        public string $mySecondArgument = '',
        public string $myThirdArgument = '',
    ) {
    }

    public function getUpperCasedMyArgument(): string
    {
        return strtoupper($this->myArgument);
    }
}