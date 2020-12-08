<?php

namespace Modules\Sales\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Finance\Dao\Repositories\BankRepository;

class CreateLanggananEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $master;
    public $customer;
    public $forwarder;
    public $detail;
    public $account;

    public function __construct($order)
    {
        $this->master = $order;
        $this->customer = $order->customer;
        $this->detail = $order->order;
        $account = new BankRepository();
        $this->account = $account->dataRepository()->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('create_langganan_email', 'sales'));
    }
}
