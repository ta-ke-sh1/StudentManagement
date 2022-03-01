<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'grades')]
    private $student;

    #[ORM\ManyToOne(targetEntity: ClassFGW::class, inversedBy: 'grades')]
    private $classFGW;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: 'grades')]
    private $subject;

    #[ORM\Column(type: 'string', length: 10)]
    private $letterGrade;

    #[ORM\Column(type: 'float')]
    public $numberGrade;

    #[ORM\Column(type: 'string', length: 50)]
    private $semester;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClassFGW(): ?ClassFGW
    {
        return $this->classFGW;
    }

    public function setClassFGW(?ClassFGW $classFGW): self
    {
        $this->classFGW = $classFGW;

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

    public function getLetterGrade(): ?string
    {
        return $this->letterGrade;
    }

    public function setLetterGrade(string $letterGrade): self
    {
        $this->letterGrade = $letterGrade;

        return $this;
    }

    public function getNumberGrade(): ?float
    {
        return $this->numberGrade;
    }

    public function setNumberGrade(float $numberGrade): self
    {
        $this->numberGrade = $numberGrade;

        return $this;
    }

    public function getSemester(): ?string
    {
        return $this->semester;
    }

    public function setSemester(string $semester): self
    {
        $this->semester = $semester;

        return $this;
    }
}
