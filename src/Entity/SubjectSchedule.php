<?php

namespace App\Entity;

use App\Repository\SubjectScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectScheduleRepository::class)]
class SubjectSchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'integer')]
    private $slot;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'subjectSchedules')]
    private $student;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: 'subjectSchedules')]
    private $subject;

    #[ORM\ManyToOne(targetEntity: ClassFGW::class, inversedBy: 'subjectSchedules')]
    private $class;

    #[ORM\ManyToOne(targetEntity: Teacher::class, inversedBy: 'subjectSchedules')]
    private $teacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSlot(): ?int
    {
        return $this->slot;
    }

    public function setSlot(int $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getClass(): ?ClassFGW
    {
        return $this->class;
    }

    public function setClass(?ClassFGW $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }
}
