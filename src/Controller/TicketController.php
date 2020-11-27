<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Ticket;
use App\Service\TicketService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @SWG\Tag(name="tickets")
 * @Rest\Route("tickets")
 * @Rest\View(serializerGroups={"tickets:read", "flight:read"})
 */
class TicketController extends AbstractFOSRestController
{
    private $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @Rest\Post("")
     * @SWG\Response(
     *     response=200,
     *     description="created reservation",
     *     @Model(type=Ticket::class, groups={"reservation:read"})
     * )
     * )
     * @Rest\RequestParam(name="seat", requirements=@Assert\Range(min=1, max=150), nullable=false, description="seat number which you want to buy")
     * @Rest\RequestParam(name="flight_id",nullable=false, description="flight where you want to buy seat")
     */
    public function post(ParamFetcherInterface $paramFetcher): View
    {
        $ticket = $this->ticketService->create($paramFetcher->all());

        return $this->view($ticket, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id"="\d+"})
     * @SWG\Response(
     *     response=204,
     *     description="Resource deleted successfully")
     * )
     * )
     */
    public function delete(Ticket $ticket): View
    {
        $this->ticketService->delete($ticket);

        return $this->view([], Response::HTTP_NO_CONTENT);
    }
}
