<?php

namespace Marlene\ActasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Marlene\ActasBundle\Entity\Actas;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MarleneActasBundle:Default:index.html.twig');
    }
    public function crearActaAction()
    {
        //Insertar acta
        $cliente = (object) array('nombre' => 'Fernando Asulay', 'edad' => 24);
        $now=new \DateTime(date('Y-m-d'));
        $acta = new Actas();
        $acta-> setCliente($cliente);
        $acta-> setDetalle('un detalle');
        $acta-> setFecha($now);
        $acta-> setAbogado($cliente);
        $acta-> setCreador($cliente);

        //como obtener el entityManager
        $em=$this->getDoctrine()->getManager();
        //sincroniza: controla que este todo bien antes de guardar en la BD
        $em->persist($acta);
        //guarda en la BD lo que tenga el entitymanager sincronizando en ese momento
        $em->flush();

        return $this->redirect($this->generateUrl('marlene_actas_listadoActas'));
    }
    public function listarActasAction()
    {
        $repository = $this->getDoctrine()->getRepository("MarleneActasBundle:Actas");//clase especifica de una entidad que nos ayuda a obtener los objetos mas facil
        $actas = $repository->findAll();

        /*$actas = array(
    		array("carpeta"=>1, "cliente"=>"Fernando Asualy"),
    		array("carpeta"=>2, "cliente"=>"Gabriel lezcano"),
    		array("carpeta"=>3, "cliente"=>"Lupe carnevale"),
    	);*/
    	return $this->render('MarleneActasBundle:Default:actas.html.twig', array('actas'=>$actas));
    }
}
