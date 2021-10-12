<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="roles")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already being used."
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Role
{
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->users = new ArrayCollection();
    }

    /**
     * @var integer|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer")
     */
    private ?int $id;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Name should not be empty")
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private ?string $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="role")
     */
    private Collection $users;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_by", type="datetime")
     */
    private \DateTime $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_by", type="datetime")
     */
    private \DateTime $updatedBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private ?\DateTime $deletedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedBy(): \DateTime
    {
        return $this->createdBy;
    }

    /**
     * @param \DateTime $createdBy
     *
     * @ORM\PrePersist()
     */
    public function setCreatedBy(): void
    {
        $this->createdBy = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedBy(): \DateTime
    {
        return $this->updatedBy;
    }

    /**
     * @param \DateTime $updatedBy
     *
     * @ORM\PrePersist()
     */
    public function setUpdatedBy(): void
    {
        $this->updatedBy = new \DateTime();
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(): void
    {
        $this->deletedAt = new \DateTime();
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function addUsers(User $user): void
    {
        $this->users[] = $user;
    }

}
