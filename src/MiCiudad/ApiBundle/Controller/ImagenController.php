<?php

namespace MiCiudad\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MiCiudad\ModeloBundle\Entity\TipoSolicitud;
use MiCiudad\ModeloBundle\Form\TipoSolicitudType;

use Symfony\Component\HttpFoundation\Response;

/**
 * Imagen controller.
 *
 * @Route("/imagen")
 */
class ImagenController extends Controller
{
	private function generarImagen($origen, $destino, $ancho, $alto, $inset, $llenarTodo,$rotarAuto)
	{
   		if (file_exists($destino) == false){
   			if (file_exists($origen) == true){
   	
   				try {
   					if (($ancho > 0) && ($alto > 0)){
   						$mode = null;
   							
   						$imagine = new \Imagine\Gd\Imagine();
   						$size    = new \Imagine\Image\Box($ancho, $alto);
  						
   						if ($inset == true){
   							$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
   						} else {
   							$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
   						}

   						$imagenOrigen = $imagine->open($origen);
   						
   						if ($rotarAuto == true){
							$esOrigenHorizontal = ($imagenOrigen->getSize()->getWidth() > $imagenOrigen->getSize()->getHeight());
							$esMedidaHorizontal = $ancho > $alto; 
   							
							if ($esOrigenHorizontal != $esMedidaHorizontal){
								$aux = $ancho;
								$ancho = $alto;
								$alto = $aux;
							}
   						}
   						
   						if (($inset == true) && ($llenarTodo == true)){
   							$imagenResultado = $imagine->create($size, new \Imagine\Image\Color('000', 100));
   							
   							$thumbnail = $imagenOrigen->thumbnail($size, $mode);
   								
   							$offsetX = (int)(($ancho - $thumbnail->getSize()->getWidth()) / 2);
   							$offsetY = (int)(($alto - $thumbnail->getSize()->getHeight()) / 2);
   								
   							$imagenResultado->paste($thumbnail, new \Imagine\Image\Point($offsetX, $offsetY));
   						} else {
   							$imagenResultado = $imagenOrigen->thumbnail($size, $mode);
   						}
   						
   						$imagenResultado->save($destino);
   						
   					} else {
   						$imagine = new \Imagine\Gd\Imagine();
   						$imagine->open($pathArchivo)->save($destino);
   					}
   				} catch (\Imagine\Exception\InvalidArgumentException $ex) {
   					$imagenResultado = null;
   				}
   			}
   			else
   			{
   				$imagenResultado = null;
   			}
   		}
   		
   		//echo "(" . file_exists($destino) . ")";
   		
   		$result = null;
   		if (file_exists($destino) == true){
   			$result = file_get_contents($destino);
   		}
  	
   		//echo $result;
   		
   		return $result;
	}
	
	/**
	 * @Route("/hola")
	 * @Method("GET")
	 */
	public function holaAction()
	{
		echo "chau";
		die();
	}
	
	/**
	 * 
	 * @Route("/tiposolicitud/{tiposolicitudId}/{origen}/{ancho}/{alto}")
	 * @Template()
	 */
	public function tiposolicitudAction($tiposolicitudId, $origen, $ancho, $alto)
	{
		$origen = base64_decode($origen);
		$destino = substr("00000000" . $tiposolicitudId, -8) . "_" . substr("00000000" . $ancho, -8) . "_" . substr("00000000" . $alto, -8) . ".png";
		
		$origen = $this->container->getParameter('directorio.uploads') . $origen;
		$destino = $this->container->getParameter('directorio.uploads.cache') . "tiposolicitud/" . $destino;
		
		//echo "(" . $origen . ")";
		//echo "(" . $destino . ")";
		
		return new Response($this->generarImagen($origen, $destino, $ancho, $alto, true, true, false), 200, array("Content-Type: image/png"));
	}
	
		
	
}