<?php

namespace App\Console\Commands;

use App\Models\campaign;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RunCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled campaigns';


    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $campaigns = DB::table("campaigns")->whereIn('status', ["pending",  "running"])->where("started_at", "<=", $now)->get();

        foreach ($campaigns as $campaign) {

            $this->info('Running campaign: ' . $campaign->name);


            $contact = DB::table('campaign_contacts')->where("campaign_id", $campaign->id)->where("status", "sending")->orderBy("order", "asc")->first();


            if (!isset($contact)) {

                $contact = DB::table('campaign_contacts')->where("campaign_id", $campaign->id)->where("status", "pending")->orderBy("order", "asc")->first();

                if (isset($contact)) {
                    $this->sendMessage($campaign, $contact);

                    if ($campaign->status == "pending") {
                        DB::table('campaigns')
                            ->where('id', $campaign->id)
                            ->update(['status' => "running"]);
                    }
                } else {

                    DB::table('campaigns')
                        ->where('id', $campaign->id)
                        ->update([
                            'status' => 'complete',
                            'ended_at' => Carbon::now()
                        ]);


                    $this->info('campaign: ' . $campaign->name . " complate ");
                }
            }
        }
    }

    protected function sendMessage($campaign, $contact)
    {
        $from = $campaign->form;
        $to = $campaign->to;
        $delay = rand($from, $to);

        $this->info("Sending message to ({$contact->phone}) in {$delay} seconds");

        try {
            dispatch(new \App\Jobs\SendWhatsAppMessage($campaign , $contact))
                ->delay(now()->addSeconds($delay));

            DB::table('campaign_contacts')
                ->where('id', $contact->id)
                ->update(['status' => "sending"]);
        } catch (\Throwable $th) {
            DB::table('campaign_contacts')
                ->where('id', $contact->id)
                ->update(['status' => "failed"]);
        }
    }
}
