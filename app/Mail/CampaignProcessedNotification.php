<?php
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignProcessedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;

    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    public function build()
    {
        return $this->view('emails.campaign_processed')->with(['campaign' => $this->campaign]);
    }
}

?>