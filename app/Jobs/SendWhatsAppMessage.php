<?php

namespace App\Jobs;

use App\Models\device;
use App\Models\message;
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

    /**
     * Create a new job instance.
     */
    public function __construct($device_id, $message_id, $phone, $id)
    {
        $this->device_id = $device_id;
        $this->message_id = $message_id;
        $this->phone = $phone;
        $this->contactId = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            $device = DB::table("devices")->where("id", $this->device_id)->first();

            $message = DB::table("messages")->where("id", $this->message_id)->first();

            $response = sendMessage($device->token, $this->phone, $message->message);


            if ($response["status"] == "success") {
                $this->updateContactStatus('success');
            } else {
                $this->updateContactStatus('failed');
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
