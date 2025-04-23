<?php

namespace Lareon\Modules\Comment\App\Console\Command;

use Illuminate\Console\Command;
use Lareon\Modules\Comment\App\Models\Comment;

class CleanCommentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear unconfirmed comments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Comment::onlyTrashed()->where('created_at', '<', now()->subMonth())->forceDelete();
        Comment::query()->where('confirmed', 0)->where('created_at', '<', now()->subWeeks(2))->delete();
    }
}
