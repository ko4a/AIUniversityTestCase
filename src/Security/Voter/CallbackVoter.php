<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Repository\CallbackSecretKeyRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CallbackVoter extends Voter
{
    public const CALLBACK = 'CALLBACK';

    private $secretKeyRepository;

    public function __construct(CallbackSecretKeyRepository $secretKeyRepository)
    {
        $this->secretKeyRepository = $secretKeyRepository;
    }

    protected function supports($attribute, $subject): bool
    {
        return self::CALLBACK === $attribute && is_string($subject);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return null !== $this->secretKeyRepository->findOneBy(['key' => $subject]);
    }
}
