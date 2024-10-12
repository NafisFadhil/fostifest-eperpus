<?php

namespace App\Console\Commands;

use App\Models\History;
use App\Models\Level;
use App\Models\Season;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class ResetSeason extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-season';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activeSeason = Season::where('start_date', now())->first();
        if ($activeSeason) {
            $season = Season::where('status', true)->first();
            if ($season) {
                $season->update(['status' => false]);
            }
            $history = History::where('season_id', $season->id)->get();
            foreach ($history as $item) {
                $level = Level::where('id', $item->level_id)->first();
                $item->update(['point' => $item->point - $level?->reset_poin]);
                History::create([
                    'id' => Uuid::uuid7(),
                    'user_id' => $item->user_id,
                    'level_id' => $item->level_id,
                    'season_id' => $activeSeason->id,
                    'point' => $item->point,
                    'created_at' => now(),
                ]);
            }

            $activeSeason->update(['status' => true]);
        }
    }
}
