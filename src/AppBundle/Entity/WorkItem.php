<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="work_item")
*/

class WorkItem
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	* @ORM\Column(type="text")
	*/
	private $description;

	/**
	* @ORM\Column(type="string")
	*/
	private $user;

	/**
	* @ORM\Column(type="string", options={"default": "active"})
	*/
	private $status;

    /**
    * @ORM\Column(type="datetime")
    */
    private $created_at;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $doc_title;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $file_type;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return WorkItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return WorkItem
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return WorkItem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return WorkItem
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set docTitle
     *
     * @param string $docTitle
     *
     * @return WorkItem
     */
    public function setDocTitle($docTitle)
    {
        $this->doc_title = $docTitle;

        return $this;
    }

    /**
     * Get docTitle
     *
     * @return string
     */
    public function getDocTitle()
    {
        return $this->doc_title;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     *
     * @return WorkItem
     */
    public function setFileType($fileType)
    {
        $this->file_type = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string
     */
    public function getFileType()
    {
        return $this->file_type;
    }
}
