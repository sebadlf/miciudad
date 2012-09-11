<?php

namespace MiCiudad\ApiBundle\Controller;

use MiCiudad\ModeloBundle\Entity\Solicitante;

use MiCiudad\ModeloBundle\Entity\DatoPersonal;

use MiCiudad\ModeloBundle\Entity\DatoExtendido;

use MiCiudad\ModeloBundle\Entity\CampoExtendido;

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
					$resultado[$i]["requerido"] = $datoExtendido->getRequerido();
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
		$errors = $this->validarVacios(array ('tipoSolicitudId', 'descripcion', 'direccion', 'direccionValidada', 'dispositivoId', 'idioma'));
		$errors_datosPersonales = array();
				
   		$em = $this->getDoctrine()->getManager();
   		
   		$request = $this->getRequest();
   			
   		$tipoSolicitudId = $request->request->get("tipoSolicitudId", 0);
   		$descripcion = $request->request->get("descripcion");
   		$foto = $request->request->get("foto", null);
   		$latitud = $request->request->get("latitud", null);
   		$longitud = $request->request->get("longitud", null);
   		$direccion = $request->request->get("direccion");
   		$direccionValidada = $request->request->get("direccionValidada");
   		$dispositivoId = $request->request->get("dispositivoId", 0);
   		$idiomaId = $request->request->get("idioma", "");
   		$datosExtendidos = $request->request->get("datos_extendidos");
   		$datosPersonales = $request->request->get("datos_personales", array());

   		$tipoSolicitud = $em->getRepository('ModeloBundle:TipoSolicitud')->find($tipoSolicitudId);
   		if ((array_key_exists('tipoSolicitudId', $errors) == false) && ($tipoSolicitud == null)){
   			$errors['tipoSolicitudId'] = $tipoSolicitudId . " es un valor invalido para tipoSolicitudId";
   		}
   		    		   		
   		$dispositivo = $em->getRepository('ModeloBundle:Dispositivo')->find($dispositivoId);
   		
   		if ((array_key_exists('dispositivoId', $errors) == false) && ($dispositivo == null)){
   			$errors['dispositivoId'] = $dispositivoId . " es un valor invalido para dispositivoId";
   		}
   		
   		$idioma = $em->getRepository('ModeloBundle:Idioma')->findByCodigo($idiomaId);
   		if (array_key_exists('idioma', $errors) == false) {
	   		if (($idioma == null) || (count($idioma) == 0)){
	   			$errors['idioma'] = $idiomaId . " es un valor invalido para idioma";
	   		} else {
	   			$idioma = $idioma[0];
	   		}
   		}
   		
   		if ($tipoSolicitud != null){
   			$errors = $this->validarDatosExtendidos($tipoSolicitud, $datosExtendidos, $errors);
   		}

		$errors_datosPersonales = $this->validarDatosPersonales($datosPersonales);
   		   		
   		if ((count($errors) == 0) && (count($errors_datosPersonales) == 0)){
			
   			if ($foto != null){
   				$foto = base64_decode($foto);
   			}
   			
   			$estado = $em->getRepository('ModeloBundle:Estado')->find(1);
   			$zona = $em->getRepository('ModeloBundle:Zona')->find(1);
   			$solicitante = $this->procesarDatosPersonales($datosPersonales);

   			$now = new \DateTime();
   			$fechaFormateada = $now->format('Y-m-d_H-i-s');
   			$tipoSolicitudFormateada = substr("00000000" . $tipoSolicitudId, -8);
   			$dispositivoFormateado = substr("00000000" . $dispositivoId, -8);
   			
   			$pathFoto = null;
   			if ($foto != null){
	   			$archivoFoto =  $fechaFormateada . "_" . $tipoSolicitudFormateada . "_" . $dispositivoFormateado . ".jpg";
	   			$pathFoto = "solicitud/temp/" . $archivoFoto;
	
	   			file_put_contents($this->container->getParameter('directorio.uploads') . $pathFoto, $foto);
   			}
   			
   			$solicitud = new Solicitud();
   			
   			$solicitud->setTipoSolicitud($tipoSolicitud);   			
   			$solicitud->setNumeroSolicitud(-1);
   			$solicitud->setDescripcion($descripcion);
   			$solicitud->setFoto($pathFoto);
   			$solicitud->setDireccion($direccion);
   			$solicitud->setLatitud($latitud);
   			$solicitud->setLongitud($longitud);
   			$solicitud->setDireccionValidada($direccionValidada);
   			$solicitud->setDispositivo($dispositivo);
   			$solicitud->setSolicitante($solicitante);
   			$solicitud->setIdioma($idioma);
   			$solicitud->setZona($zona);
   			
   			
   			$solicitudEstado = new SolicitudEstado();
   			$solicitudEstado->setSolicitud($solicitud);
   			$solicitudEstado->setEstado($estado);
   			$solicitudEstado->setFecha(new \DateTime());
   			
   			$solicitud->getSolicitudEstados()->Add($solicitudEstado);

   			//Si es un array asociativo guardo los datos extendidos
   			if (((is_array($datosExtendidos) == true)) && (array_keys($datosExtendidos) !== range(0, count($datosExtendidos) - 1)))
   			{
	   			foreach ($datosExtendidos as $key => $value) {
	   				
	   				$campoExtendido = $em->getRepository('ModeloBundle:CampoExtendido')->find($key);
	   				
	   				if ($campoExtendido != null)
	   				{
		   				$datoExtendido = new DatoExtendido();
	   				
	   					$datoExtendido->setSolicitud($solicitud);
	   					$datoExtendido->setCampoExtendido($campoExtendido);
	   					$datoExtendido->setValor($value);
	   				
	   					$solicitud->getDatosExtendidos()->Add($datoExtendido);
	   				}
	   			}
   			}	   			
   			
   			$em->persist($solicitud);
   			$em->flush();

   			$id = $solicitud->getId();
   			$idFormateado = substr("00000000" . $id, -8);
   			
   			$solicitud->setNumeroSolicitud($idFormateado);

   			//Carpeta de la solicitud
   			$carpeta = (int)($id / 1000);
   			
   			$carpetaFormateada = substr("00000000" . $carpeta . "000", -8); 
   			
   			if (file_exists($this->container->getParameter('directorio.uploads') . "solicitud/" . $carpetaFormateada) == false){
   				mkdir($this->container->getParameter('directorio.uploads') . "solicitud/" . $carpetaFormateada);
   			}
   			
   			mkdir($this->container->getParameter('directorio.uploads') . "solicitud/" . $carpetaFormateada . "/" . $idFormateado);
   			$pathFotoDestino = "solicitud/" . $carpetaFormateada . "/" . $idFormateado . "/" . $idFormateado . ".jpg";
  			   			
   			if ($foto != null){
   				rename($this->container->getParameter('directorio.uploads') . $pathFoto, $this->container->getParameter('directorio.uploads') . $pathFotoDestino);
   				$solicitud->setFoto($pathFotoDestino);
   			}
   			
   			$em->persist($solicitud);
   			$em->flush();
   			   				
   			$result = array(
   								"status" => "ok", 
   								"id" => $solicitud->getId(), 
   								"numeroSolicitud" => $solicitud->getNumeroSolicitud()
   							);
   			
   			
   			$serializer = $this->container->get('serializer');
   			$report = $serializer->serialize($result, 'json');
   			
   			return new Response($report, 201);
   			
   		} else {
   			
   			$responseErrors["status"] = "invalid";
   			
   			if (count($errors_datosPersonales) > 0){
   				$error = "Existen errores en sus datos personales";
   			} else {
   				$error = "Existen errores en su solicitud";
   			}
   			
   			$responseErrors["form"] = array($error);
   			$responseErrors["datos"] = $errors;
   			$responseErrors["datos_personales"] = $errors_datosPersonales;
   			
   			$serializer = $this->container->get('serializer');
   			$report = $serializer->serialize($responseErrors, 'json');
   		
   			return new Response($report, 502);
   		}
   	}
   	
   	private function validarDatosExtendidos (\MiCiudad\ModeloBundle\Entity\TipoSolicitud $tipoSolicitud, $datosExtendidos, $errors)
   	{
   		while($tipoSolicitud != null){
   			 
   			$formulario = $tipoSolicitud->getFormulario();
   		
   			if ($formulario != null){
   				 
   				foreach ($formulario->getCamposExtendidos() as $campoExtendido) {
   						
   					$campoExtendido->getId();
   					$campoExtendido->getDescripcion();
   					//$campoExtendido->getTipoDato()->getDescripcion();
   					   					
					if ($campoExtendido->getRequerido() == true){
					   	if ((is_array($datosExtendidos) == false) || (strlen($datosExtendidos[$campoExtendido->getId()] ) == 0)){
   							$errors[$campoExtendido->getId()] = $campoExtendido->getDescripcion() . " es un dato requerido";
   						}
					}
   				}
   			}
   		
   			$tipoSolicitud = $tipoSolicitud->getTipoSolicitudPadre();
   		}   		
   		
   		
   		return $errors;
   	}
   	
   	private function validarDatosPersonales($datosPersonales){
  		
   		$errors = array();
   		
   		$em = $this->getDoctrine()->getManager();
   		 
   		$keys = array("requerido" => true);
   		
   		$datosRequeridos = $em->getRepository('ModeloBundle:DatoPersonalSolicitante')->findBy($keys);
   		 
   		foreach ($datosRequeridos as $datoPersonal) {
   			   			
   			$valor = $this->datoPersonalObtenerValor($datosPersonales, $datoPersonal->getCodigo());
   			
   			if (empty($valor) == true){
   				$errors[$datoPersonal->getCodigo()] = $datoPersonal->getDescripcion() . " es un dato requerido";
   			}
  		}
  		
   		return $errors;
   	}
   	
   	private function procesarDatosPersonales($datosPersonales){
   		
   		$em = $this->getDoctrine()->getManager();
   		
   		$datosPersonalesClave = $em->getRepository('ModeloBundle:DatoPersonalSolicitante')->findByClave(true);
   		$datosPersonalesSistema = $em->getRepository('ModeloBundle:DatoPersonalSolicitante')->findByRequerido(true);
   		
   		$arrayClaves = array();
   		foreach ($datosPersonalesClave as $datoPersonalClave) {
   			$arrayClaves[$datoPersonalClave->getCodigo()] = $this->datoPersonalObtenerValor($datosPersonales, $datoPersonalClave->getCodigo());  
   		}   		
   		
   		$solicitantes = $em->getRepository('ModeloBundle:Solicitante')->findBy($arrayClaves);
   		   		   		
   		$solicitante = null;
   		if (count($solicitantes) > 0){
   			$solicitante = $solicitantes[0];
   		} else {
   			$solicitante = new Solicitante();
   		}
   		
   		$solicitante->setNombre($this->datoPersonalObtenerValor($datosPersonales, "nombre"));
   		$solicitante->setApellido($this->datoPersonalObtenerValor($datosPersonales, "apellido"));
   		$solicitante->setEmail($this->datoPersonalObtenerValor($datosPersonales, "email"));
   		$solicitante->setDni($this->datoPersonalObtenerValor($datosPersonales, "dni"));
   		$solicitante->setCuit($this->datoPersonalObtenerValor($datosPersonales, "cuit"));
   		$solicitante->setCpf($this->datoPersonalObtenerValor($datosPersonales, "cpf"));
   		$solicitante->setFechaNacimiento($this->datoPersonalObtenerValor($datosPersonales, "fechaNacimiento"));
   		$solicitante->setTelefono($this->datoPersonalObtenerValor($datosPersonales, "telefono"));
   		$solicitante->setCelular($this->datoPersonalObtenerValor($datosPersonales, "celular"));
   		
   		$sexoStr = $this->datoPersonalObtenerValor($datosPersonales, "sexo");
   		
   		$sexos = $em->getRepository('ModeloBundle:Sexo')->findByCodigo($sexoStr);
   		
   		$sexo = null;
   		if (count($sexo) > 0){
   			$sexo = $sexos[0];
   		}
   		
   		$solicitante->setSexo($sexo);
   		
   		return $solicitante;
   	} 
   	
   	private function datoPersonalObtenerValor($datosPersonales, $key){
   		
   		$result = null;
   		
   		if (array_key_exists($key, $datosPersonales) == true){
   			$result = trim($datosPersonales[$key]);
   			
   			if (strlen($result) == 0){
   				$result = null;
   			}
   		}
   		   		
   		return $result; 
   	}
   	
}
