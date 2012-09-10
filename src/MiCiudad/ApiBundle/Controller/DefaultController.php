<?php

namespace MiCiudad\ApiBundle\Controller;

use MiCiudad\ModeloBundle\Entity\SolicitudEstado;

use MiCiudad\ModeloBundle\Entity\Solicitud;

use Imagine\Gd\Imagine;

use MiCiudad\ModeloBundle\Entity\Dispositivo;

use Symfony\Component\Validator\Constraints\Length;

use Doctrine\Common\Annotations\Annotation\Required;

use MiCiudad\ApiBundle\Form\ComentarioType;
use MiCiudad\ModeloBundle\Form\DispositivoType;

use Symfony\Component\Form\Form;

use MiCiudad\ApiBundle\Entity\Comentario;
use MiCiudad\ModeloBundle\Entity\TipoSolicitud;

use JMS\SerializerBundle\Annotation\Type;

use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/*
 * @Type("Rest")
 * 
 */

class DefaultController extends Controller
{
    /**
     * @Route("/test.{_format}")
     * @Template("index.html.twig")
     */
    public function indexAction()
    {
        //return array('name' => $name);
    	
    	$request = $this->getRequest();
    	
    	$comentario = new Comentario();
    	
    	echo "(" . $request->request->get("descripcion") . ")";
    	
    	$form = $this->createFormBuilder($comentario, array(
							            'data_class'        => 'MiCiudad\ApiBundle\Entity\Comentario',
							            'csrf_protection'   => false,
							        )
    	)  ->add('descripcion', 'text', array("required" => true))
    		->getForm();
    	
    	if ($request->getMethod() == 'PUT'){
    		$form->bind(array());
    		 
    		if ($form->isValid()){
    			echo "Valido";
    			print_r($form->getErrors());
    		
    			$em = $this->get('doctrine')->getEntityManager();
    		
    			
    			print_r($comentario);
    			
    			$em->persist($comentario);
    			$em->flush();
    		
    		}
    		else {
    			echo "Invalido";
    			print_r($form->getErrors());
    		
    		}
    		 
    		echo "<pre>";
    		print_r($this->getRequest()->request);
    		echo "</pre>";
    		 
    		die("FIN");
    		
    	}
    	

        
    }
    
    /**
     * @Route("/dispositivo")
     * @Template("index.html.twig")
     * @Method("PUT")
     */
    public function dispositivoAction()
    {
    	$dispositivosAceptados = array(
    									"AndroidTelefono" => "AndroidTelefono",
    									"AndroidTablet" => "AndroidTablet",
    									"iPhone" => "iPhone",
    									"iPad" => "iPad",
    								);
    	
    	$request = $this->getRequest(); 
    	
    	$descripcion = $request->request->get("descripcion");
    	$version = $request->request->get("version");
    	$detalle = $request->request->get("detalle");
    	
    	$errors = array();
    	
    	if (strlen($descripcion) == 0){
    		$errors["descripcion"] = "Descripcion es un dato requerido";  	
    	} else if (array_key_exists($descripcion, $dispositivosAceptados) == false) {
    		$errors["descripcion"] = $descripcion . " no es un valor válido para Descripcion";
    	}

    	if (strlen($version) == 0){
    		$errors["version"] = "Version es un dato requerido";
    	}
    	
    	if (strlen($detalle) == 0){
    		$errors["detalle"] = "Detalle es un dato requerido";
    	}
    	
    	if (count($errors) == 0){
    		
    		$dispositivo = new Dispositivo();

    		$dispositivo->setDescripcion($descripcion);
    		$dispositivo->setVersion($version);
    		$dispositivo->setDetalle($detalle);
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($dispositivo);
    		$em->flush();
    		
    		$return = new Response(json_encode(array("id" => $dispositivo->getId())), 201, array("Content-Type" => "application/json")); 
    	}
    	else
    	{
    		$return = new Response(json_encode($errors), 502, array("Content-Type" => "application/json"));
    	}
    	
    	return $return;
    }
    
    /**
     * @Route("/tiposolicitud")
     * @Template("ModeloBundle:Default:index.html.twig")
     * @Method("GET")
     */
    public function tipoSolicitudAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $request = $this->getRequest();
       
        $tiposSolicitudes = $em->getRepository('ModeloBundle:TipoSolicitud')->findBy(array("tipoSolicitudPadre" => null));
        
        $anchoIcono = $request->query->get("anchoIcono", 0);
        $altoIcono = $request->query->get("altoIcono", 0);
        $largoTitulo = $request->query->get("largoTitulo", 0);
        $largoDescripcion = $request->query->get("largoDescripcion", 0);
        
        $i = 0;
        $result = array();
        foreach ($tiposSolicitudes as $tipoSolicitud) {
        	$result[$i] = $this->generarArrayRecursivo($tipoSolicitud, $anchoIcono, $altoIcono, $largoTitulo, $largoDescripcion);
        }
        
        $serializer = $this->container->get('serializer');
        $report = $serializer->serialize($result, 'json');
                
        return new Response($report);	
    }
    
   	private function generarArrayRecursivo(TipoSolicitud $tipoSolicitud, $anchoIcono, $altoIcono, $largoTitulo, $largoDescripcion){
		
   		$tipoSolicitudHijas = $tipoSolicitud->getTipoSolicitudHijas();

   		$result["id"] = $tipoSolicitud->getId();
   		$result["titulo"] = ($largoTitulo > 0) ? substr($tipoSolicitud->getTitulo(), 0, $largoTitulo) : $tipoSolicitud->getTitulo();
   		$result["descripcion"] = ($largoDescripcion > 0) ? substr($tipoSolicitud->getDescripcion(), 0, $largoDescripcion) : $tipoSolicitud->getDescripcion();
   		$result["icono"] = $this->generarThumbnailTipoSolicitud($tipoSolicitud, $anchoIcono, $altoIcono);
   		if (count($tipoSolicitudHijas) == 0){
			$result["datos_extendidos"] = $this->generarDatosExtendidos($tipoSolicitud);
			$result["tipo_solicitud_hijas"] = array();
   		} else {
   			$i = 0;
   			foreach ($tipoSolicitudHijas as $tipoSolicitudHija) {
				$result["tipo_solicitud_hijas"][$i] = $this->generarArrayRecursivo($tipoSolicitudHija, $anchoIcono, $altoIcono, $largoTitulo, $largoDescripcion);
   				$i++;
   			} 
   		}
   		
   		return $result;
   	}
   	
   	private function generarThumbnailTipoSolicitud(TipoSolicitud $tipoSolicitud, $ancho, $alto){
   		
   		$id = $tipoSolicitud->getId();
   		$archivo = $tipoSolicitud->getIcono();

   		$pathArchivo = $this->container->getParameter('directorio.uploads');
   		$pathArchivo = $pathArchivo . $archivo;
   		
   		$archivoCache = substr("00000000" . $id, -8) . "_" . substr("00000000" . $ancho, -8) . "_" . substr("00000000" . $alto, -8) . ".png";
   		
   		$pathArchivoCache = $this->container->getParameter('directorio.uploads.cache') . "tiposolicitud/" . $archivoCache;

   		if (file_exists($pathArchivoCache) == false){
   			if (file_exists($pathArchivo) == true){
   				
   				if (($ancho > 0) && ($alto > 0)){
   					$imagine = new \Imagine\Gd\Imagine();
   					$size    = new \Imagine\Image\Box($ancho, $alto);
   					$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
   					
   					$imagenResultado = $imagine->create($size, new \Imagine\Image\Color('000', 100));
   					
   					$thumbnail = $imagine->open($pathArchivo)->thumbnail($size, $mode);
   					
   					$offsetX = (int)(($ancho - $thumbnail->getSize()->getWidth()) / 2);
   					$offsetY = (int)(($alto - $thumbnail->getSize()->getHeight()) / 2);
   					
   					$imagenResultado->paste($thumbnail, new \Imagine\Image\Point($offsetX, $offsetY));   					
   					
   					$imagenResultado->save($pathArchivoCache);
   				} else {
   					$imagine = new \Imagine\Gd\Imagine();
   					$imagine->open($pathArchivo)->save($pathArchivoCache);
   				}
   				
   			}
   			else
   			{
   				$archivoCache = null;
   			}
   		}
   		
   		$urlArchivoCache = "";
   		if ($archivoCache != null){
   			$request = $this->getRequest();
   			
   			$scheme = $request->getScheme();
   			$host = $request->getHost();
   			$uriArchivosCache = $this->container->getParameter('uri.uploads.cache');
   			
   			$urlArchivoCache = $scheme . "://" . $host . $uriArchivosCache . "tiposolicitud/" . $archivoCache;     			
   		}

   		return $urlArchivoCache;
   	}
   	
   	private function generarDatosExtendidos(TipoSolicitud $tipoSolicitud){
   		
   		$resultado = array();

   		$i = 0;
   		
   		while($tipoSolicitud != null){
   		
   			$formulario = $tipoSolicitud->getFormulario();
   			
   			if ($formulario != null){
   		
				foreach ($formulario->getCamposExtendidos() as $datoExtendido) {
					
					$resultado[$i]["id"] = $datoExtendido->getId();
					$resultado[$i]["descripcion"] = $datoExtendido->getDescripcion();
					$resultado[$i]["tipoControl"] = $datoExtendido->getTipoControl()->getDescripcion();
					$resultado[$i]["tipoDato"] = $datoExtendido->getTipoDato()->getDescripcion();
					
					if ($datoExtendido->getTipoControl()->getDescripcion() == "Radio"){

						$j = 0;
						foreach ($datoExtendido->getCampoExtendidoOpciones() as $opcion) {
							$opciones[$j]["id"] = $opcion->getId();
							$opciones[$j]["descripcion"] = $opcion->getDescripcion();
							
							$j++;
						}
								
					}
					else{
						$opciones = array();
					}
					
					$resultado[$i]["opciones"] = $opciones;
					
					$i++;
				}   				
   			}
   			
   			$tipoSolicitud = $tipoSolicitud->getTipoSolicitudPadre();
   		} 
   		
   		return $resultado;
   		
   	}
   	
   	/**
   	 * @Route("/tiposolicitud/ultimaactualizacion")
   	 * @Template("ModeloBundle:Default:index.html.twig")
   	 * @Method("GET")
   	 */
   	public function tipoSolicitudUltimaActualizacionAction()
   	{
   		$request = $this->getRequest();
   		
   		$errors = null;
   		if ($request->query->has("zona") == false){
   			$errors = "zona es un parametro requerido";
   		} else {
   			$zona = $request->query->get("zona");
   			
   			if (preg_match("[\d]", $zona) == false || ((int)$zona < -10) || ((int)$zona > 13)){
   				$errors = "zona debe ser un entero entre -10 y +13";
   			}
   		} 
   		
   		if ($errors == null){    		
	   		$now = new \DateTime();
	   		$zonaServer =($now->getTimezone()->getOffset($now) / 60 / 60);
	   			   		
	   		$zonaDispositivo = $request->query->get("zona");
	   		
	   		$diferencia = $zonaDispositivo - $zonaServer;
	   		
	   		$em = $this->getDoctrine()->getManager();
	   		
	   		$qb = $em->createQueryBuilder();
	   		
	   		$qb->select('ts')
	   			->from('ModeloBundle:TipoSolicitud', 'ts')
	   			->orderBy('ts.fechaUltimaActualizacion', 'DESC')
				->setFirstResult(0)
	   			->setMaxResults(1);
	   		
	   		$query = $qb->getQuery();
	
	   		$tipoSolicitud = $query->getSingleResult();
	   		
	   		$fecha = $tipoSolicitud->getFechaUltimaActualizacion();
	   		
	   		$fecha->modify($diferencia . ' hours');
	   			
	   		$result = array (
	   							"fecha" => $fecha->format('Y-m-d H:i:s')
	   						);
	   		
	   		$serializer = $this->container->get('serializer');
	   		$report = $serializer->serialize($result, 'json');
	   		
	   		return new Response($report);
   		} else {
   			$serializer = $this->container->get('serializer');
   			$report = $serializer->serialize($errors, 'json');

   			return new Response($report, 502);
   		}
   	}
   	
   	private function validarVacios($arrayKeys){
   		
   		$request = $this->getRequest();
   		
   		$errors = array();
   		
   		foreach ($arrayKeys as $key) {
   			if (strlen($request->request->get($key)) == 0){
   				$errors[$key] = $key . " es un dato requerido";
   			}
   		}
   		
		return $errors;   		
   	}
   	

   	/**
   	 * @Route("/solicitud")
   	 * @Template("index.html.twig")
   	 * @Method("PUT")
   	 */
   	public function solicitudAction()
   	{
		$errors = $this->validarVacios(array ('tipoSolicitudId', 'descripcion', 'foto', 'latitud',
								 'longitud', 'direccion', 'direccionValidada', 'dispositivoId', 'idiomaId'));

   		$em = $this->getDoctrine()->getManager();
   		
   		$request = $this->getRequest();
   			
   		$tipoSolicitudId = $request->request->get("tipoSolicitudId");
   		$descripcion = $request->request->get("descripcion");
   		$foto = $request->request->get("foto");
   		$latitud = $request->request->get("latitud");
   		$longitud = $request->request->get("longitud");
   		$direccion = $request->request->get("direccion");
   		$direccionValidada = $request->request->get("direccionValidada");
   		$dispositivoId = $request->request->get("dispositivoId");
   		$idiomaId = $request->request->get("idioma");

   		
   		$tipoSolicitud = $em->getRepository('ModeloBundle:TipoSolicitud')->findById($tipoSolicitudId);
   		if ((array_key_exists('tipoSolicitudId', $errors) == false) && ($tipoSolicitud == null)){
   			$errors['tipoSolicitudId'] = $tipoSolicitudId . " es un valor invalido para tipoSolicitudId";
   		}
   		    		   		
   		$dispositivo = $em->getRepository('ModeloBundle:Dispositivo')->findById($dispositivoId);
   		if ((array_key_exists('dispositivoId', $errors) == false) && ($dispositivo == null)){
   			$errors['dispositivoId'] = $dispositivoId . " es un valor invalido para dispositivoId";
   		}
   		
   		$dispositivo = $em->getRepository('ModeloBundle:Idioma')->findByCodigo($idiomaId);
   		if ((array_key_exists('idioma', $errors) == false) && ($idiomaId == null)){
   			$errors['idioma'] = $idiomaId . " es un valor invalido para idioma";
   		}
   		
   		if (count($errors) == 0){
			
   			$foto = base64decode($foto);
   			$estado = $em->getRepository('ModeloBundle:Estado')->findById(1);
   			$zona = $em->getRepository('ModeloBundle:Zona')->findById(1);
   			$solicitante = $em->getRepository('ModeloBundle:Solicitante')->findById(1);

   			$now = new \DateTime();
   			$fechaFormateada = $now->format('Y-m-d H:i:s');
   			$tipoSolicitudFormateada = substr("00000000" . $tipoSolicitudId, -8);
   			$dispositivoFormateado = substr("00000000" . $dispositivoId, -8);
   			
   			$archivoFoto =  $fechaFormateada . "_ " . $tipoSolicitudFormateada . "_" . $dispositivoFormateado . ".jpg";
   			$pathFoto = $this->container->getParameter('directorio.uploads') . "solicitud/temp/" . $archivoFoto;

   			file_put_contents($pathFoto, $foto);

   			$solicitud = new Solicitud();
   			
   			$solicitud->setDescripcion($descripcion);
   			$solicitud->setFoto($pathFoto);
   			$solicitud->setDireccion($direccion);
   			$solicitud->setLatitud($latitud);
   			$solicitud->setLongitud($longitud);
   			$solicitud->setDireccionValidada($direccionValidada);
   			$solicitud->setDispositivo($dispositivo);
   			$solicitud->setIdioma($idioma);
   			$solicitud->setZona($zona);
   			
   			$solicitudEstado = new SolicitudEstado();
   			$solicitudEstado->setEstado($estado);
   			$solicitudEstado->setFecha(new \DateTime());
   			
   			$solicitud->getSolicitudEstados()->Add($solicitudEstado);
   			   			
   			$em->persist($solicitud);
   			$em->flush();
   			
   			$id = $solicitud->getId();
   			$idFormateado = substr("00000000" . $id);
   			   			
   			$carpeta = (int)($id / 1000);
   			
   			$carpetaFormateada = substr("00000000" . $carpeta . "000", -8); 
   			
   			mkdir($this->container->getParameter('directorio.uploads') . "solicitud/" . $carpetaFormateada . "/" . $idFormateado, 777, true);
   			$pathFotoDestino = "solicitud/" . $carpetaFormateada . "/" . $idFormateado . "/" . $idFormateado . ".jpg";
  			   			
   			rename($pathFoto, $this->container->getParameter('directorio.uploads') . $pathFotoDestino);
   			
   			$solicitud = $em->getRepository('ModeloBundle:TipoSolicitud')->findById($id);
   			
   			$solicitud->setFoto($pathFotoDestino);
   			
   			$em->persist($solicitud);
   			$em->flush();
 			
   			
   		}
   	}
}
