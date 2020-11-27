<?php

namespace App\Tests;

use App\Entity\Reservation;
use Codeception\Module\Asserts;
use Codeception\Util\HttpCode;

class ReservationCest
{
    public function tryToPostFreeSeat(ApiTester $I): void
    {
        $I->sendPost('/reservations', [
            'seat' => 25,
            'flight_id' => 1,
        ]);

        $resp = json_decode($I->grabResponse(), true);

        $I->seeResponseCodeIs(HttpCode::CREATED);

        $ticket = $I->grabEntityFromRepository(Reservation::class, ['id' => $resp['id']]);

        Asserts::assertNotNull($ticket);
    }

    public function tryToPostNotFreeSeat(ApiTester $I): void
    {
        $I->sendPost('/reservations', [
            'seat' => 3,
            'flight_id' => 1,
        ]);

        $resp = json_decode($I->grabResponse(), true);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function tryToDelete(ApiTester $I): void
    {
        $I->sendDelete('/reservations/1');

        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->cantSeeInRepository(Reservation::class, [
            'id' => 1,
        ]);
    }
}
