<?php

namespace Marlene\ActasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Marlene\ActasBundle\Entity\Comentarios;
use Marlene\ActasBundle\Form\ComentariosType;

use Marlene\ActasBundle\Entity\Actas;

/**
 * Comentarios controller.
 *
 * @Route("/actas/comentarios")
 */
class ComentariosController extends Controller
{

    /**
     * Lists all Comentarios entities.
     *
     * @Route("/", name="actas_comentarios")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MarleneActasBundle:Comentarios')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Comentarios entity.
     *
     * @Route("/", name="actas_comentarios_create")
     * @Method("POST")
     *
     */
    public function createAction(Request $request)
    {
        /*$entity = new Comentarios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();


            //return $this->redirect($this->generateUrl('actas_comentarios_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );*/
        $entity = new Comentarios();
        $now = new \DateTime('now',new \DateTimeZone('America/Argentina/Buenos_Aires'));
        $now->format('d-m-Y H:i:s');    

        $em = $this->getDoctrine()->getManager();
        
       // $entity->setCreador($request->request->get('creador'));
        $entity->setCreador($this->container->get('security.context')->getToken()->getUser());
        $entity->setFechaHora($now);
        $entity->setTexto($request->request->get('texto'));

        $acta = $em->getRepository('MarleneActasBundle:Actas')->find($request->request->get('actaId'));
        $acta->addComentario($entity);

        $em->persist($entity);
        $em->flush();

        $em->persist($acta);
        $em->flush();


        return $this->redirect($this->generateUrl('actas'));
        
    }

    /**
     * Creates a form to create a Comentarios entity.
     *
     * @param Comentarios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Comentarios $entity)
    {
        $form = $this->createForm(new ComentariosType(), $entity, array(
            'action' => $this->generateUrl('actas_comentarios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Comentarios entity.
     *
     * @Route("/new", name="actas_comentarios_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Comentarios();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Comentarios entity.
     *
     * @Route("/{id}", name="actas_comentarios_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Comentarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentarios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        );
    }

    /**
     * Displays a form to edit an existing Comentarios entity.
     *
     * @Route("/{id}/edit", name="actas_comentarios_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Comentarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentarios entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Comentarios entity.
    *
    * @param Comentarios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comentarios $entity)
    {
        $form = $this->createForm(new ComentariosType(), $entity, array(
            'action' => $this->generateUrl('actas_comentarios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Comentarios entity.
     *
     * @Route("/{id}", name="actas_comentarios_update")
     * @Method("PUT")
     * @Template("MarleneActasBundle:Comentarios:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Comentarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comentarios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('actas_comentarios_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Comentarios entity.
     *
     * @Route("/{id}", name="actas_comentarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MarleneActasBundle:Comentarios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comentarios entity.');
            }

            $actaId = $request->request->get('actaId');
            $acta = $em->getRepository('MarleneActasBundle:Actas')->find($actaId);
            $acta->removeComentario($entity);
            $em->persist($acta);
            $em->flush();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('actas_show',array('id'=>$actaId)));
    }

    /**
     * Creates a form to delete a Comentarios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actas_comentarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
