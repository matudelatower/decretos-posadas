<?php

namespace App\Controller;

use App\Entity\Decreto;
use App\Form\BuscarDecretoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class WebController extends AbstractController {
	/**
	 * @Route("/", name="web_index")
	 */
	public function index( Request $request ) {
		$em = $this->getDoctrine();

		$decretos           = [];
		$decretosDestacados = $em->getRepository( Decreto::class )->findBy( [
			'destacado' => true,
			'activo'    => true
		] );

		$form = $this->createForm( BuscarDecretoType::class,
			[],
			[ 'method' => 'GET', 'attr' => [ 'role' => 'search' ] ] );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$data = $form->getData();


			$resultados = $em->getRepository( Decreto::class )->buscarDecretos( $data );

			$decretos = $resultados->getQuery()
			                       ->getResult();
		}

		return $this->render( 'web/index.html.twig',
			[
				'titulo'             => 'Inicio',
				'form'               => $form->createView(),
				'decretos'           => $decretos,
				'decretosDestacados' => $decretosDestacados,
			] );
	}

	/**
	 * @Route("/ver_decreto/{decreto}", name="web_ver_decreto")
	 */
	public function verDecreto( Decreto $decreto ) {

		if ( ! $decreto->getActivo() ) {
			return $this->redirectToRoute( 'web_decreto_no_encontrado' );
		}

		$titulo = 'Decreto Nº ' . $decreto->getNumero();

		$archivo = new \SplFileInfo( $decreto->getArchivo() );


		return $this->render( 'web/ver_decreto.html.twig',
			[
				'titulo'  => $titulo,
				'decreto' => $decreto,
				'archivo' => $archivo
			] );
	}

	/**
	 * @Route("/decreto_no_encontrado/{decreto}",defaults={"decreto": null}, name="web_decreto_no_encontrado")
	 */
	public function decretoInactivo() {

		$titulo = 'Decreto No Encontrado ';

		return $this->render( 'web/decreto_inactivo.html.twig',
			[
				'titulo' => $titulo,
			] );
	}

	/**
	 * @Route("/descargar_decreto/{decreto}", name="web_descargar_decreto")
	 */
	public function descargarDecreto( Decreto $decreto, DownloadHandler $downloadHandler ) {

		if ( ! $decreto->getActivo() ) {
			return $this->redirectToRoute( 'web_decreto_no_encontrado' );
		}

		return $downloadHandler->downloadObject( $decreto,
			$fileField = 'decretoFile',
			$objectClass = null,
			$fileName = null,
			$forceDownload = true );
	}

}
