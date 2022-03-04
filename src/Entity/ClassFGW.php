<?php

namespace App\Entity;

use App\Repository\ClassFGWRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassFGWRepository::class)]
class ClassFGW
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'classFGWs')]
    private $subjects;

    #[ORM\OneToMany(mappedBy: 'classFGW', targetEntity: Grade::class)]
    private $grades;

    #[ORM\OneToMany(mappedBy: 'classFGW', targetEntity: Student::class)]
    private $students;

    #[ORM\OneToMany(mappedBy: 'class', targetEntity: SubjectSchedule::class)]
    private $subjectSchedules;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->students = new ArrayCollection();
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

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        $this->subjects->removeElement($subject);

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->setClassFGW($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getClassFGW() === $this) {
                $grade->setClassFGW(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setClassFGW($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getClassFGW() === $this) {
                $student->setClassFGW(null);
            }
        }

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
            $subjectSchedule->setClass($this);
        }

        return $this;
    }

    public function removeSubjectSchedule(SubjectSchedule $subjectSchedule): self
    {
        if ($this->subjectSchedules->removeElement($subjectSchedule)) {
            // set the owning side to null (unless already changed)
            if ($subjectSchedule->getClass() === $this) {
                $subjectSchedule->setClass(null);
            }
        }

        return $this;
    }
}
