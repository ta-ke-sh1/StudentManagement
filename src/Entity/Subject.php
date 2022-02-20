<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\ManyToMany(targetEntity: ClassFGW::class, mappedBy: 'subjects')]
    private $classFGWs;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Grade::class)]
    private $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->classFGWs = new ArrayCollection();
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
     * @return Collection<int, ClassFGW>
     */
    public function getClassFGWs(): Collection
    {
        return $this->classFGWs;
    }

    public function addClassFGW(ClassFGW $classFGW): self
    {
        if (!$this->classFGWs->contains($classFGW)) {
            $this->classFGWs[] = $classFGW;
            $classFGW->addSubject($this);
        }

        return $this;
    }

    public function removeClassFGW(ClassFGW $classFGW): self
    {
        if ($this->classFGWs->removeElement($classFGW)) {
            $classFGW->removeSubject($this);
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
            $grade->setSubject($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getSubject() === $this) {
                $grade->setSubject(null);
            }
        }

        return $this;
    }
}
