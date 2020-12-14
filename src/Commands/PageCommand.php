<?php

namespace Code95\Page\Commands;

use Illuminate\Console\Command;

class PageCommand extends Command
{
    public $signature = 'pages';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
