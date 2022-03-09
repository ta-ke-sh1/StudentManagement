<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $dob;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: SubjectSchedule::class)]
    private $subjectSchedules;

    public function __construct()
    {
        $this->subjectSchedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, SubjectSchedule>
     */
    public function getSubjectSchedules(): Collection
    {
        return $this->subjectSchedules;
    }

    public function addSubjectSchedule(SubjectSchedule $subjectSchedule): self
    {
        if (!$this->subjectSchedules->contains($subjectSchedule)) {
            $this->subjectSchedules[] = $subjectSchedule;
            $subjectSchedule->setTeacher($this);
        }

        return $this;
    }

    public function removeSubjectSchedule(SubjectSchedule $subjectSchedule): self
    {
        if ($this->subjectSchedules->removeElement($subjectSchedule)) {
            // set the owning side to null (unless already changed)
            if ($subjectSchedule->getTeacher() === $this) {
                $subjectSchedule->setTeacher(null);
            }
        }

        return $this;
    }
}
