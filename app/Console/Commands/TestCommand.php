<?php

namespace App\Console\Commands;

use ReflectionClass;
use App\Http\Classes\TestClass;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-attributes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $reflectionClass = new ReflectionClass(TestClass::class);
        $attributes = $reflectionClass->getAttributes();

        dd($attributes[0]->newInstance()->getUpperCasedMyArgument());
    }
}