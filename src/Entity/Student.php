<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Null_;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $dob;

    #[ORM\Column(type: 'string', length: 50)]
    private $major;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Grade::class)]
    private $grades;

    #[ORM\ManyToOne(targetEntity: ClassFGW::class, inversedBy: 'students')]
    private $classFGW;

    #[ORM\Column(type: 'float')]
    private $gpa;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
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

    public function getMajor(): ?string
    {
        return $this->major;
    }

    public function setMajor(string $major): self
    {
        $this->major = $major;

        return $this;
    }

    public function getImage() // Doi type tu string -> object
    {
        return $this->image;
    }

    public function setImage($image)
    {
        // Neu ng dung update anh thi ms update
        if ($image != null) {
            $this->image = $image;
        }

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
            $grade->setStudent($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getStudent() === $this) {
                $grade->setStudent(null);
            }
        }

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

    public function getGpa(Grade $grade): ?float
    {
        $sum = 0;
        $count = 0;
        if(count($this->grades)>0){
            foreach ($this->grades as $grade) {
                $sum += $grade->getLetterGrade();
                $count++;
            }
        }
        else return 0;
        $this->gpa = $sum / $count;
        return $this->gpa;
    }

    public function setGpa(float $gpa): self
    {
        $this->gpa = $gpa;

        return $this;
    }
}
