<?php

namespace Dumplie\Test\Integration\Application\InMemory\CustomerService;

use Dumplie\Application\Command\CustomerService\AcceptOrder;
use Dumplie\Application\Command\CustomerService\AcceptOrderHandler;
use Dumplie\Application\Command\CustomerService\CancelOrder;
use Dumplie\Application\Command\CustomerService\CancelOrderHandler;
use Dumplie\Application\Command\CustomerService\PayOrder;
use Dumplie\Application\Command\CustomerService\PayOrderHandler;
use Dumplie\Application\Command\CustomerService\PrepareOrder;
use Dumplie\Application\Command\CustomerService\PrepareOrderHandler;
use Dumplie\Application\Command\CustomerService\RefundOrder;
use Dumplie\Application\Command\CustomerService\RefundOrderHandler;
use Dumplie\Application\Command\CustomerService\RejectOrder;
use Dumplie\Application\Command\CustomerService\RejectOrderHandler;
use Dumplie\Application\Command\CustomerService\SendOrder;
use Dumplie\Application\Command\CustomerService\SendOrderHandler;
use Dumplie\Domain\CustomerService\Order;
use Dumplie\Domain\CustomerService\Orders;
use Dumplie\Domain\CustomerService\OrderState\Accepted;
use Dumplie\Domain\CustomerService\OrderState\Cancelled;
use Dumplie\Domain\CustomerService\OrderState\Paid;
use Dumplie\Domain\CustomerService\OrderState\Prepared;
use Dumplie\Domain\CustomerService\OrderState\Refunded;
use Dumplie\Domain\CustomerService\OrderState\Rejected;
use Dumplie\Domain\CustomerService\OrderState\Sent;
use Dumplie\Infrastructure\InMemory\CustomerService\InMemoryOrders;
use Dumplie\Infrastructure\InMemory\Transaction\Factory;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Factory
     */
    private $transactionFactory;

    function setUp()
    {
        $this->order = new Order();
        $this->orders = new InMemoryOrders([$this->order]);
        $this->transactionFactory = new Factory();
    }

    function test_pay_order()
    {
        $command = new PayOrder($this->order->id());
        $handler = new PayOrderHandler($this->orders, $this->transactionFactory);

        $handler->handle($command);
    }

    function test_cancel_order()
    {
        $command = new CancelOrder($this->order->id());
        $handler = new CancelOrderHandler($this->orders, $this->transactionFactory);

        $handler->handle($command);
    }

    function test_accept_order()
    {
        $payCommand = new PayOrder($this->order->id());
        $payHandler = new PayOrderHandler($this->orders, $this->transactionFactory);
        $payHandler->handle($payCommand);

        $acceptCommand = new AcceptOrder($this->order->id());
        $acceptHandler = new AcceptOrderHandler($this->orders, $this->transactionFactory);
        $acceptHandler->handle($acceptCommand);
    }

    function test_reject_order()
    {
        $payCommand = new PayOrder($this->order->id());
        $payHandler = new PayOrderHandler($this->orders, $this->transactionFactory);
        $payHandler->handle($payCommand);

        $rejectCommand = new RejectOrder($this->order->id());
        $rejectHandler = new RejectOrderHandler($this->orders, $this->transactionFactory);
        $rejectHandler->handle($rejectCommand);
    }

    function test_prepare_order()
    {
        $payCommand = new PayOrder($this->order->id());
        $payHandler = new PayOrderHandler($this->orders, $this->transactionFactory);
        $payHandler->handle($payCommand);

        $acceptCommand = new AcceptOrder($this->order->id());
        $acceptHandler = new AcceptOrderHandler($this->orders, $this->transactionFactory);
        $acceptHandler->handle($acceptCommand);

        $prepareCommand = new PrepareOrder($this->order->id());
        $prepareHandler = new PrepareOrderHandler($this->orders, $this->transactionFactory);
        $prepareHandler->handle($prepareCommand);
    }

    function test_refund_order()
    {
        $payCommand = new PayOrder($this->order->id());
        $payHandler = new PayOrderHandler($this->orders, $this->transactionFactory);
        $payHandler->handle($payCommand);

        $acceptCommand = new AcceptOrder($this->order->id());
        $acceptHandler = new AcceptOrderHandler($this->orders, $this->transactionFactory);
        $acceptHandler->handle($acceptCommand);

        $refundCommand = new RefundOrder($this->order->id());
        $refundHandler = new RefundOrderHandler($this->orders, $this->transactionFactory);
        $refundHandler->handle($refundCommand);
    }

    function test_send_order()
    {
        $payCommand = new PayOrder($this->order->id());
        $payHandler = new PayOrderHandler($this->orders, $this->transactionFactory);
        $payHandler->handle($payCommand);

        $acceptCommand = new AcceptOrder($this->order->id());
        $acceptHandler = new AcceptOrderHandler($this->orders, $this->transactionFactory);
        $acceptHandler->handle($acceptCommand);

        $prepareCommand = new PrepareOrder($this->order->id());
        $prepareHandler = new PrepareOrderHandler($this->orders, $this->transactionFactory);
        $prepareHandler->handle($prepareCommand);

        $sendCommand = new SendOrder($this->order->id());
        $sendHandler = new SendOrderHandler($this->orders, $this->transactionFactory);
        $sendHandler->handle($sendCommand);
    }
}