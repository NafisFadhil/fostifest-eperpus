<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Level;
use Ramsey\Uuid\Uuid;
use App\Models\Season;
use App\Models\History;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $activeSeason = Season::whereDate('start_date', Carbon::now())->first();
            if ($activeSeason) {
                $season = Season::where('status', true)->first();
                if ($season) {
                    $season->update(['status' => false]);
                }
                $history = History::where('season_id', $season->id)->get();
                foreach ($history as $item) {
                    $level = Level::where('id', $item->level_id)->first();
                    $new_poin =$item->poin - ($level?->reset_point ?? 0);
                    History::create([
                        'id' => Uuid::uuid7(),
                        'user_id' => $item->user_id,
                        'level_id' => $item->level_id,
                        'season_id' => $activeSeason->id,
                        'poin' => $new_poin,
                        'created_at' => now(),
                    ]);
                }

                $activeSeason->update(['status' => true]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
