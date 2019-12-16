<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nom_fournisseur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom_fournisseur;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $address_fournisseur;

    /**
     * @ORM\Column(type="string", length=155)
     */
    private $email_fournisseur;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel_fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="fournisseur")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nom_fournisseur;
    }

    public function setNomFournisseur(string $nom_fournisseur): self
    {
        $this->nom_fournisseur = $nom_fournisseur;

        return $this;
    }

    public function getPrenomFournisseur(): ?string
    {
        return $this->prenom_fournisseur;
    }

    public function setPrenomFournisseur(string $prenom_fournisseur): self
    {
        $this->prenom_fournisseur = $prenom_fournisseur;

        return $this;
    }

    public function getAddressFournisseur(): ?string
    {
        return $this->address_fournisseur;
    }

    public function setAddressFournisseur(?string $address_fournisseur): self
    {
        $this->address_fournisseur = $address_fournisseur;

        return $this;
    }

    public function getEmailFournisseur(): ?string
    {
        return $this->email_fournisseur;
    }

    public function setEmailFournisseur(string $email_fournisseur): self
    {
        $this->email_fournisseur = $email_fournisseur;

        return $this;
    }

    public function getTelFournisseur(): ?int
    {
        return $this->tel_fournisseur;
    }

    public function setTelFournisseur(int $tel_fournisseur): self
    {
        $this->tel_fournisseur = $tel_fournisseur;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setFournisseur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getFournisseur() === $this) {
                $commande->setFournisseur(null);
            }
        }

        return $this;
    }
}
