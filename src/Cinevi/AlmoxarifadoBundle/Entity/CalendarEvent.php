<?php
namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AncaRebeca\FullCalendarBundle\Model\Event as BaseEvent;

/**
 * @ORM\Entity(repositoryClass="Cinevi\AlmoxarifadoBundle\Entity\CalendarEventRepository")
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
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\RealizacaoBundle\Entity\Projeto", cascade={"merge"})
     **/
    protected $projeto;

    /**
     * @ORM\ManyToMany(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\Equipamento", cascade={"merge"}, inversedBy="calendarEvents")
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
     * @param \Cinevi\SecurityBundle\Entity\User $user
     * @return CalendarEvent
     */
    public function setUser(\Cinevi\SecurityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cinevi\SecurityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add equipamentos
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     * @return CalendarEvent
     */
    public function addEquipamento(\Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos[] = $equipamentos;

        return $this;
    }

    /**
     * Remove equipamentos
     *
     * @param \Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos
     */
    public function removeEquipamento(\Cinevi\AlmoxarifadoBundle\Entity\Equipamento $equipamentos)
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
     * @param \Cinevi\RealizacaoBundle\Entity\Projeto $projeto
     * @return CalendarEvent
     */
    public function setProjeto(\Cinevi\RealizacaoBundle\Entity\Projeto $projeto = null)
    {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * Get projeto
     *
     * @return \Cinevi\RealizacaoBundle\Entity\Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }
}
