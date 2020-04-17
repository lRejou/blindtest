<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReportRepository")
 */
class Report
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idvideo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdvideo(): ?int
    {
        return $this->idvideo;
    }

    public function setIdvideo(int $idvideo): self
    {
        $this->idvideo = $idvideo;

        return $this;
    }
}
