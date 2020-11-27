<?php

namespace App\Tests;

use App\Entity\Reservation;
use App\Entity\Ticket;
use Codeception\Module\Asserts;
use Codeception\Util\HttpCode;

class TicketCest
{
    public function tryToPostFreeSeat(ApiTester $I): void
    {
        $I->sendPost('/tickets', [
            'seat' => 20,
            'flight_id' => 1,
        ]);

        $resp = json_decode($I->grabResponse(), true);

        $I->seeResponseCodeIs(HttpCode::CREATED);

        $ticket = $I->grabEntityFromRepository(Ticket::class, ['id' => $resp['id']]);

        Asserts::assertNotNull($ticket);
    }

    public function tryToPostNotFreeSeat(ApiTester $I): void
    {
        $I->sendPost('/tickets', [
            'seat' => 2,
            'flight_id' => 1,
        ]);

        $resp = json_decode($I->grabResponse(), true);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function tryToDelete(ApiTester $I): void
    {
        $I->sendDelete('/tickets/1');

        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->cantSeeInRepository(Ticket::class, [
            'id' => 1,
        ]);
    }
}
