<?php

namespace App\Tests;

use App\Entity\Flight;
use Codeception\Module\Asserts;
use Codeception\Util\HttpCode;
use DateTime;

class CallbackCest
{
    public function tryToCallWithInvalidKey(ApiTester $I): void
    {
        $data = [
            'data' => [
                'flight_id' => 1,
                'triggered_at' => (new DateTime())->getTimestamp(),
                'event' => 'flight_ticket_sales_completed',
                'secret_key' => '11111111111111111111111',
            ],
        ];

        $I->sendPost('callbacks', $data);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function tryToCallSalesCompleted(ApiTester $I): void
    {
        $data = [
            'data' => [
                'flight_id' => 1,
                'triggered_at' => (new DateTime())->getTimestamp(),
                'event' => 'flight_ticket_sales_completed',
                'secret_key' => '22',
            ],
        ];

        $I->sendPost('callbacks', $data);
        $I->seeResponseCodeIs(HttpCode::OK);

        $flight = $I->grabEntityFromRepository(Flight::class, ['id' => 1]);

        Asserts::assertTrue($flight->isSalesCompleted());

    }
}
