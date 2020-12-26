<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CallbackSecretKeyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CallbackSecretKeyRepository::class)
 */
class CallbackSecretKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $key;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additinalInfo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getAdditinalInfo(): ?string
    {
        return $this->additinalInfo;
    }

    public function setAdditinalInfo(?string $additinalInfo): self
    {
        $this->additinalInfo = $additinalInfo;

        return $this;
    }
}
