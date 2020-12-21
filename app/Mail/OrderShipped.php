<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    protected $order;
    protected $status;

    /**
     * Create a new message instance.
     *
     * OrderShipped constructor.
     * @param Order $order
     */
    public function __construct(Order $order, String $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = Auth::user()->email;
        if ($this->status === 'create') {
            $this->to('new@vipimport.ru')
                ->from('order@vipimport.ru', 'Заказ № Z' . $this->order->id . ' - vipimport.ru')
                ->markdown('emails.orders.shipped', [
                    'order' => $this->order
                ]);
        }
        return $this->to($email)
            ->from('order@vipimport.ru', 'Заказ № Z' . $this->order->id . ' - vipimport.ru')
            ->markdown('emails.orders.shipped', [
                'order' => $this->order
            ]);
    }
}
