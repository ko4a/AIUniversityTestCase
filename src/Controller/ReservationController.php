<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Reservation;
use App\Service\ReservationService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @SWG\Tag(name="reservations")
 * @Rest\Route("reservations")
 * @Rest\View(serializerGroups={"reservation:read", "flight:read"})
 */
class ReservationController extends AbstractFOSRestController
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * @Rest\Post("")
     * @SWG\Response(
     *     response=200,
     *     description="created reservation",
     *     @Model(type=Reservation::class, groups={"reservation:read"})
     * )
     * )
     * @Rest\RequestParam(name="seat", requirements=@Assert\Range(min=1, max=150), nullable=false, description="seat number which you want to book")
     * @Rest\RequestParam(name="flight_id",nullable=false, description="flight where you want to book seat")
     */
    public function post(ParamFetcherInterface $paramFetcher): View
    {
        $reservation = $this->reservationService->create($paramFetcher->all());

        return $this->view($reservation, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id"="\d+"})
     * @SWG\Response(
     *     response=204,
     *     description="Resource deleted successfully")
     * )
     * )
     */
    public function delete(Reservation $reservation): View
    {
        $this->reservationService->delete($reservation);

        return $this->view([], Response::HTTP_NO_CONTENT);
    }
}
