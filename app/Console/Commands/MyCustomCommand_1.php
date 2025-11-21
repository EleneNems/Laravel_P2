<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyCustomCommand_1 extends Command
{
    protected $signature = 'say:hello_1 {name : სახელი} {lastname : გვარი}';
    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');
        $lastname = $this->argument('lastname');
        
        $this->info("Hello {$name} {$lastname}!");
    }
}
