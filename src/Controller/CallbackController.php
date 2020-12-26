<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CallbackRequestDTO;
use App\Security\Voter\CallbackVoter;
use App\Service\CallbackService;
use App\Validator\CallbackRequestConstraint;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @SWG\Tag(name="callbacks")
 * @Rest\Route("callbacks")
 * @Rest\View
 */
class CallbackController extends AbstractFOSRestController
{
    private CallbackService $callbackService;

    public function __construct(CallbackService $callbackService)
    {
        $this->callbackService = $callbackService;
    }

    /**
     * @Rest\Post("")
     * @SWG\Response(
     *     response=200,
     *     description="event is in proccess"
     *  )
     *
     * @SWG\Parameter(name="body", in="body", required=true,
     *      @SWG\Schema(
     *       type="object",
     *       @SWG\Property(
     *          property="data",
     *          type="object",
     *          @SWG\Property(
     *            property="flight_id",
     *            type="integer"
     *       ),
     *          @SWG\Property(
     *              property="triggered_at",
     *              type="integer"
     *      ),
     *          @SWG\Property(
     *           property="event",
     *           type="string",
     *           enum={"flight_ticket_sales_completed", "flight_canceled"}
     *      ),
     *          @SWG\Property(
     *           property="secret_key",
     *           type="string"
     *      ),
     *    )
     *  )
     *)
     * @Rest\RequestParam(name="data", requirements=@CallbackRequestConstraint)
     */
    public function call(ParamFetcherInterface $paramFetcher): View
    {
        $dto = new CallbackRequestDTO($paramFetcher->all());

        $this->denyAccessUnlessGranted(CallbackVoter::CALLBACK, $dto->getSecretKey());

        $this->callbackService->call($dto);

        return $this->view([], JsonResponse::HTTP_OK);
    }
}
