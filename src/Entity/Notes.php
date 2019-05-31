<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NotesRepository")
 */
class Notes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Students", inversedBy="notes")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero(message="la note doit etre supérieure ou égale à 0")
     * @Assert\LessThan(
     *      value = 21,
     *      message="la note doit etre inférieure ou égale à 20"
     * )
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?Students
    {
        return $this->name;
    }

    public function setName(?Students $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }
}
