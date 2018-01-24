<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use AncaRebeca\FullCalendarBundle\Model\Event as BaseEvent;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarEventRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projeto", cascade={"merge"}, inversedBy="calendarEvents")
     **/
    protected $projeto;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipamento", cascade={"merge"}, inversedBy="calendarEvents")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\CalendarEventHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    public function __construct($title = null, \DateTime $start = null)
    {
        $this->title = $title;
        $this->startDate = $start;
        $this->equipamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historicos = new \Doctrine\Common\Collections\ArrayCollection();
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
            $this->title = "#".mt_rand(0, 999).date("H").date("i").date("s").date("d").date("m").date("y");
        }
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     * @return CalendarEvent
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add equipamentos
     *
     * @param \App\Entity\Equipamento $equipamentos
     * @return CalendarEvent
     */
    public function addEquipamento(\App\Entity\Equipamento $equipamentos)
    {
        $this->equipamentos[] = $equipamentos;

        return $this;
    }

    /**
     * Remove equipamentos
     *
     * @param \App\Entity\Equipamento $equipamentos
     */
    public function removeEquipamento(\App\Entity\Equipamento $equipamentos)
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
     * @param \App\Entity\Projeto $projeto
     * @return CalendarEvent
     */
    public function setProjeto(\App\Entity\Projeto $projeto = null)
    {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * Get projeto
     *
     * @return \App\Entity\Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\CalendarEventHistorico $historicos
     * @return CalendarEvent
     */
    public function addHistorico(\App\Entity\CalendarEventHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\CalendarEventHistorico $historicos
     */
    public function removeHistorico(\App\Entity\CalendarEventHistorico $historicos)
    {
        $this->historicos->removeElement($historicos);
    }

    /**
     * Get historicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricos()
    {
        return $this->historicos;
    }
}
