<?php
namespace AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AncaRebeca\FullCalendarBundle\Model\Event as BaseEvent;

/**
 * @ORM\Entity(repositoryClass="AlmoxarifadoBundle\Entity\CalendarEventRepository")
 * @ORM\Table(name="almoxarifado_calendar_events")
 * @ORM\HasLifecycleCallbacks()
 */
class CalendarEvent extends BaseEvent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=24, unique=true)
     **/
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="RealizacaoBundle\Entity\Projeto", cascade={"merge"}, inversedBy="calendarEvents")
     **/
    protected $projeto;

    /**
     * @ORM\ManyToMany(targetEntity="AlmoxarifadoBundle\Entity\Equipamento", cascade={"merge"}, inversedBy="calendarEvents")
     **/
    protected $equipamentos;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $startDate;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $endDate;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $createdIn;

    /**
     * @ORM\Column(type="datetime")
     **/
    protected $updatedIn;


    public function __construct($title = null, \DateTime $start = null)
    {
        $this->title = $title;
        $this->startDate = $start;
        $this->equipamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title
     *
     * @param integer $title
     * @return CalendarEvent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return integer
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
    * @ORM\PrePersist
    */
    public function setTitleValue()
    {
        if(!$this->getTitle()) {
            $this->title = "#".substr(uniqid(rand(), true), 0, 3).date("H").date("i").date("s").date("d").date("m").date("y");
        }
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return CalendarEvent
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add equipamentos
     *
     * @param \AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     * @return CalendarEvent
     */
    public function addEquipamento(\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos[] = $equipamentos;

        return $this;
    }

    /**
     * Remove equipamentos
     *
     * @param \AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     */
    public function removeEquipamento(\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos->removeElement($equipamentos);
    }

    /**
     * Get equipamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate = null)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate = null)
    {
        $this->endDate = $endDate;
    }

    /**
     * Set projeto
     *
     * @param \RealizacaoBundle\Entity\Projeto $projeto
     * @return CalendarEvent
     */
    public function setProjeto(\RealizacaoBundle\Entity\Projeto $projeto = null)
    {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * Get projeto
     *
     * @return \RealizacaoBundle\Entity\Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     * Set createdIn
     *
     * @param \DateTime $createdIn
     *
     * @return CalendarEvent
     */
    public function setCreatedIn($createdIn)
    {
        $this->createdIn = $createdIn;

        return $this;
    }

    /**
     * Get createdIn
     *
     * @return \DateTime
     */
    public function getCreatedIn()
    {
        return $this->createdIn;
    }

    /**
     * Set updatedIn
     *
     * @param \DateTime $updatedIn
     *
     * @return CalendarEvent
     */
    public function setUpdatedIn($updatedIn)
    {
        $this->updatedIn = $updatedIn;

        return $this;
    }

    /**
     * Get updatedIn
     *
     * @return \DateTime
     */
    public function getUpdatedIn()
    {
        return $this->updatedIn;
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedInValue()
    {
        $this->createdIn = new \DateTime();
    }

    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setUpdatedInValue()
    {
        $this->updatedIn = new \DateTime();
    }
}
