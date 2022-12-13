<?php

namespace App\Console\Commands\Search;

use App\Models\Post;
use Illuminate\Console\Command;
use MeiliSearch\Client;

class SetupSearchFilters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:filters
		{index : The index you want to work with.}
	';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register filters against a search index.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
        $index = $this->argument(
            key: 'index',
        );

        $model = match ($index) {
            'posts_index' => Post::class,
        };

        try {
            $this->info(
                string: "Updating filterable attributes for [$model] on index [$index]",
            );
            $client->index(
                uid: $index,
            )->updateFilterableAttributes(
                filterableAttributes: $model::getSearchFilterAttributes(),
            );
        } catch (ApiException $exception) {
            $this->warn(
                string: $exception->getMessage(),
            );
            return self::FAILURE;
        }
        return 0;
    }
}
