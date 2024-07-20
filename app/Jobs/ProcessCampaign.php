<?php
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CampaignEmail;
use App\Mail\CampaignProcessedNotification;

class ProcessCampaign implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        $csvData = array_map('str_getcsv', file(storage_path('app/' . $this->campaign->csv_path)));

        foreach ($csvData as $row) {
            $email = $row[1];
            $username = $row[0];

            Mail::to($email)->send(new CampaignEmail($username));
        }

        // Notify user
        Mail::to($this->campaign->user->email)->send(new CampaignProcessedNotification($this->campaign));
    }
}
?>