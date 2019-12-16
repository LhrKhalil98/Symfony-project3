<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Email est déjà utilisé" 
 * ) 
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 8,      
     *      minMessage = "Votre mot de passe doit etre {{ limit }} characters long",
     * )
     * @Assert\EqualTo(
     * propertyPath="confirm_password",
     * message = "mot de passe n'est pas identique "
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45 , nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=45 , nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
    private $num_tel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="client")
     */
    private $commandes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme" )
     */
    private $direction;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="commentaires" )
     */
    private $article_commente;

    public $confirm_password ; 

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->direction = new ArrayCollection();
        $this->article_commente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getDirection(): Collection
    {
        return $this->direction;
    }

    public function addDirection(Theme $direction): self
    {
        if (!$this->direction->contains($direction)) {
            $this->direction[] = $direction;
        }

        return $this;
    }

    public function removeDirection(Theme $direction): self
    {
        if ($this->direction->contains($direction)) {
            $this->direction->removeElement($direction);
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleCommente(): Collection
    {
        return $this->article_commente;
    }

    public function addArticleCommente(Article $articleCommente): self
    {
        if (!$this->article_commente->contains($articleCommente)) {
            $this->article_commente[] = $articleCommente;
            $articleCommente->addCommentaire($this);
        }

        return $this;
    }

    public function removeArticleCommente(Article $articleCommente): self
    {
        if ($this->article_commente->contains($articleCommente)) {
            $this->article_commente->removeElement($articleCommente);
            $articleCommente->removeCommentaire($this);
        }

        return $this;
    }
}
