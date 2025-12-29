<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialRequestMail;

class SendMaterialRequestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $vendorEmail;
    public $mailData;

    /**
     * Create a new job instance.
     *
     * @param string $vendorEmail
     * @param array $mailData
     */
    public function __construct($vendorEmail, $mailData)
    {
        $this->vendorEmail = $vendorEmail;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->vendorEmail)->send(new MaterialRequestMail($this->mailData));
    }
}
