<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Articulo
 *
 * @ORM\Table(name="articulo")
 * @ORM\HasLifecycleCallbacks
 * @Assert\Callback(methods={"validateFile"})
 * @ORM\Entity()
 */
class Articulo
{

	private $temp;
	private $pathRelative='/uploads/articulos/';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="precio", type="float")
	 * @Assert\Type(type="numeric")
	 * @Assert\NotBlank()
	 */
	private $precio;

	/**
	 * @var UploadedFile
	 *
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
	 */
	private $imagenPath;

	/**
	 * Get file.
	 *
	 * @return UploadedFile
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * Sets file.
	 *
	 * @param UploadedFile $file
	 */
	public function setFile(UploadedFile $file = null)
	{
		$this->file = $file;
		$this->temp = $this->getImagenPath(); //last saved
	}

	public function validateFile(ExecutionContext $context)
	{
		if ($this->file)
		{
			$type = $this->getFile()->guessExtension();

			$arrValidFormats=array('jpg','gif','png','jpeg');

			if (!in_array($type,$arrValidFormats)) {

				$context->addViolation("Formato de archivo invalido ($type), solo 'jpg','gif','png'", array(), null);
			}
		}

	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function upload()
	{

		if (null === $this->getFile()) {
			return;
		}

		$fileName=uniqid().'.'.$this->getFile()->guessExtension();

		//add try catch
		$this->getFile()->move(
			$this->getUploadFullPath(),
			$fileName
		);

		$this->setFile(null);
		$this->setImagenPath($this->pathRelative.$fileName);
		$this->borrarAnteriorImagen();
	}


	/**
	 * @ORM\PreRemove()
	 */
	public function storeFilenameForRemove()
	{
		$this->temp = $this->getImagenPath();
		$this->imagenPath = null;
		$this->borrarAnteriorImagen();
	}

	protected function borrarAnteriorImagen()
	{
		if (isset($this->temp) && $this->temp != $this->imagenPath)
		{
			$tempFullPath = realpath($this->getUploadRootPath().$this->temp);

			if ($tempFullPath && is_file($tempFullPath))
			{
				unlink($tempFullPath);
			}
		}
	}

	protected function getUploadRootPath()
	{
		return __DIR__.'/../../../../web/';
	}

	protected function getUploadFullPath()
	{
		return $this->getUploadRootPath().$this->pathRelative;
	}


    /**
     * @var string
     *
     * @ORM\Column(name="paypal_html", type="text")
     * @Assert\NotBlank()
     */
    private $paypalHtml;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Articulo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set paypalHtml
     *
     * @param string $paypalHtml
     *
     * @return Articulo
     */
    public function setPaypalHtml($paypalHtml)
    {
        $this->paypalHtml = $paypalHtml;
    
        return $this;
    }

    /**
     * Get paypalHtml
     *
     * @return string 
     */
    public function getPaypalHtml()
    {
        return $this->paypalHtml;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Articulo
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

	public function __toString(){
		return $this->nombre;
	}



    /**
     * Set imagenPath
     *
     * @param string $imagenPath
     * @return Articulo
     */
    public function setImagenPath($imagenPath)
    {
        $this->imagenPath = $imagenPath;
    
        return $this;
    }

    /**
     * Get imagenPath
     *
     * @return string 
     */
    public function getImagenPath()
    {
        return $this->imagenPath;
    }
}