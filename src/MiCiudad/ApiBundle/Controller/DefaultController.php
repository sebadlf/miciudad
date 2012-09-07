<?php

namespace MiCiudad\ApiBundle\Controller;

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
   		$result["titulo"] = ($largoTitulo > 0) ? substr($tipoSolicitud->getTitulo(), $largoTitulo) : $tipoSolicitud->getTitulo();
   		$result["descripcion"] = ($largoDescripcion > 0) ? substr($tipoSolicitud->getDescripcion(), $largoDescripcion) : $tipoSolicitud->getDescripcion();
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
}
