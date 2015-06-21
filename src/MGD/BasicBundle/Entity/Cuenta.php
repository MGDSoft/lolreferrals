<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Cuenta
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="cuenta")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\CuentaRepository")
 */
class Cuenta extends AbstractPrice
{

    private $temp;
    private $pathRelative = '/uploads/cuentas/';

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
     * @ORM\Column(name="title_template", type="string", length=200)
     * @Assert\NotBlank()
     */
    private $titleTemplate="Cuenta nivel %nivel%";

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="float")
     * @Assert\NotBlank()
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="influence_points", type="integer")
     * @Assert\NotBlank()
     */
    private $influencePoints;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     * @Assert\NotBlank()
     */
    private $descripcion='

    <div><b>IP:</b> %ip%</div>
    <div><b>RP:</b> Replace</div>
    <div><b>RANKED DIVISION:</b> Replace</div>
    <div><b>SERVER:</b> Replace</div>
    <div style="margin-top: 20px"><b>EXTRA:</b></div>
    <div>Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que</div>
';

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="integer")
     * @Assert\NotBlank()
     */
    private $level=30;

    /**
     * @var \MGD\BasicBundle\Entity\PaypalAccount
     *
     * @ORM\ManyToOne(targetEntity="MGD\BasicBundle\Entity\PaypalAccount")
     * @ORM\JoinColumn(name="paypal_account_id", referencedColumnName="id", nullable=false)
     */
    private $paypalAccount;

    /**
     * @var \MGD\BasicBundle\Entity\CuentaUsuario
     *
     * @ORM\ManyToMany(targetEntity="MGD\BasicBundle\Entity\CuentaUsuario",cascade={"persist"})
     * @ORM\JoinTable(name="cuenta_has_cuenta_usuarios")
     */
    private $cuentaUsuarios;


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

    private $form;

    function __construct()
    {
        $this->cuentaUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
        if ($this->file) {
            $type = $this->getFile()->guessExtension();

            $arrValidFormats = array('jpg', 'gif', 'png', 'jpeg');

            if (!in_array($type, $arrValidFormats)) {

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

        $fileName = uniqid() . '.' . $this->getFile()->guessExtension();

        //add try catch
        $this->getFile()->move(
            $this->getUploadFullPath(),
            $fileName
        );

        $this->setFile(null);
        $this->setImagenPath($this->pathRelative . $fileName);
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
        if (isset($this->temp) && $this->temp != $this->imagenPath) {
            $tempFullPath = realpath($this->getUploadRootPath() . $this->temp);

            if ($tempFullPath && is_file($tempFullPath)) {
                unlink($tempFullPath);
            }
        }
    }

    protected function getUploadRootPath()
    {
        return __DIR__ . '/../../../../web/';
    }

    protected function getUploadFullPath()
    {
        return $this->getUploadRootPath() . $this->pathRelative;
    }

    /**
     * @return mixed
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * @param mixed $temp
     * @return mixed $temp
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;
        return $this->temp;
    }

    /**
     * @return string
     */
    public function getPathRelative()
    {
        return $this->pathRelative;
    }

    /**
     * @param string $pathRelative
     * @return string $pathRelative
     */
    public function setPathRelative($pathRelative)
    {
        $this->pathRelative = $pathRelative;
        return $this->pathRelative;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitleTemplate()
    {
        return $this->titleTemplate;
    }

    /**
     * @param string $titleTemplate
     * @return string $titleTemplate
     */
    public function setTitleTemplate($titleTemplate)
    {
        $this->titleTemplate = $titleTemplate;
        return $this->titleTemplate;
    }

    /**
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param string $precio
     * @return string $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
        return $this->precio;
    }

    /**
     * @return string
     */
    public function getInfluencePoints()
    {
        return $this->influencePoints;
    }

    /**
     * @param string $influencePoints
     * @return string $influencePoints
     */
    public function setInfluencePoints($influencePoints)
    {
        $this->influencePoints = $influencePoints;
        return $this->influencePoints;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     * @return string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this->level;
    }

    /**
     * @return string
     */
    public function getImagenPath()
    {
        return $this->imagenPath;
    }

    /**
     * @param string $imagenPath
     * @return string $imagenPath
     */
    public function setImagenPath($imagenPath)
    {
        $this->imagenPath = $imagenPath;
        return $this->imagenPath;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param mixed $form
     * @return mixed $form
     */
    public function setForm($form)
    {
        $this->form = $form;
        return $this->form;
    }

    /**
     * @return string
     */
    public function getStock()
    {
        $i =0;

        foreach ($this->getCuentaUsuarios() as $cuentaUsuario)
        {
            if (!$cuentaUsuario->isUsado())
                $i++;
        }

        return $i;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this->descripcion;
    }

    /**
     * @return mixed
     */
    public function getPaypalAccount()
    {
        return $this->paypalAccount;
    }

    /**
     * @param mixed $paypalAccount
     * @return mixed $paypalAccount
     */
    public function setPaypalAccount($paypalAccount)
    {
        $this->paypalAccount = $paypalAccount;
        return $this->paypalAccount;
    }


    /**
     * Add cuentaUsuarios
     *
     * @param \MGD\BasicBundle\Entity\CuentaUsuario $cuentaUsuarios
     * @return Cuenta
     */
    public function addCuentaUsuario(\MGD\BasicBundle\Entity\CuentaUsuario $cuentaUsuarios)
    {
        $this->cuentaUsuarios[] = $cuentaUsuarios;
    
        return $this;
    }

    /**
     * Remove cuentaUsuarios
     *
     * @param \MGD\BasicBundle\Entity\CuentaUsuario $cuentaUsuarios
     */
    public function removeCuentaUsuario(\MGD\BasicBundle\Entity\CuentaUsuario $cuentaUsuarios)
    {
        $this->cuentaUsuarios->removeElement($cuentaUsuarios);
    }

    /**
     * Get cuentaUsuarios
     *
     * @return \MGD\BasicBundle\Entity\CuentaUsuario[]
     */
    public function getCuentaUsuarios()
    {
        return $this->cuentaUsuarios;
    }

    /**
     * @param CuponDescuento $cuponDescuento
     * @return string
     */
    public function getCalculatedPrice(CuponDescuento $cuponDescuento = null)
    {
        return parent::calculateRealPrice(null, 0, $this, $cuponDescuento);
    }

    public function getPrimeraCuentaUsuarioNoUsada()
    {
        foreach ($this->getCuentaUsuarios() as $cuentaUsuario)
        {
            if ($cuentaUsuario->isUsado())
                return $cuentaUsuario;
        }

        return null;
    }
}