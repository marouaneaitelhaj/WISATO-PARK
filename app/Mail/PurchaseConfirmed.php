<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class PurchaseConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $validated;
    public $jpDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $validated)
    {
        $this->validated = $validated;
        $this->jpDate = Carbon::parse(new \DateTime())->locale('ja_JP')->isoFormat('LL');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(env('APP_NAME', '亀田') . ': 新規購入を確認しました')
                    ->markdown('emails.purchaseConfirmed');
    }
}
