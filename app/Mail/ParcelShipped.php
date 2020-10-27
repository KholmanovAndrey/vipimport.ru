<?php

namespace App\Mail;

use App\Parcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ParcelShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Parcel
     */
    protected $parcel;

    /**
     * Create a new message instance.
     *
     * ParcelShipped constructor.
     * @param Parcel $parcel
     */
    public function __construct(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $email = Auth::user()->email;
        $email = 'andrekho@mail.ru';
        return $this->to($email)
            ->from('order@vipimport.ru', 'Посылка № P' . $this->parcel->id . ' - vipimport.ru')
            ->markdown('emails.parcels.shipped', [
                'parcel' => $this->parcel
            ]);
    }
}
