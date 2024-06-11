<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $phone;
    protected $device_id;
    protected $message_id;
    protected $contactId;

    protected $campaignId;


    /**
     * Create a new job instance.
     */
    public function __construct($campaign, $contact)
    {
        $this->device_id = $campaign->device_id;
        $this->message_id = $campaign->message_id;
        $this->phone = $contact->phone;
        $this->contactId = $contact->id;
        $this->campaignId = $campaign->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        try {

            if (!campaign_can_send($this->campaignId)) {

                $this->updateContactStatus('pending');
                $this->delete();
            } else {


                $device = DB::table("devices")->where("id", $this->device_id)->first();

                $message = DB::table("messages")->where("id", $this->message_id)->first();

                $response = sendMessage($device->token, $this->phone, $message->message);


                if ($response["status"] == "success") {
                    $this->updateContactStatus('success');
                } else {
                    $this->updateContactStatus('failed');
                }
            }
        } catch (\Throwable $th) {
            $this->updateContactStatus('failed');
        }

        Log::info("Message sent to {$this->phone}");
    }

    function updateContactStatus($status)
    {
        DB::table('campaign_contacts')
            ->where('id', $this->contactId)
            ->update(['status' => $status]);
    }
}
