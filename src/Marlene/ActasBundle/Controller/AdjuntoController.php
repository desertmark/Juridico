<?php

namespace Marlene\ActasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Marlene\ActasBundle\Entity\Adjunto;
use Marlene\ActasBundle\Form\AdjuntoType;
use Marlene\ActasBundle\Form\AdjuntoFilterType;

use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Adjunto controller.
 *
 * @Route("/documentos")
 */
class AdjuntoController extends Controller
{
    /**
     * Lists all Adjunto entities.
     *
     * @Route("/", name="documentos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new AdjuntoFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MarleneActasBundle:Adjunto')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('AdjuntoControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('AdjuntoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('AdjuntoControllerFilter')) {
                $filterData = $session->get('AdjuntoControllerFilter');
                $filterForm = $this->createForm(new AdjuntoFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('documentos', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new Adjunto entity.
     *
     * @Route("/", name="documentos_create")
     * @Method("POST")
     * @Template("MarleneActasBundle:Adjunto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Adjunto();
        $form = $this->createForm(new AdjuntoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $file = $form['path']->getData();
            $confirm = $entity->guardarAdjunto($file);
            if ($confirm==='ok') {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Archivo guardado correctamente');

                return $this->redirect($this->generateUrl('documentos_show', array('id' => $entity->getId())));
            }
            else
            {
                $this->get('session')->getFlashBag()->add('error', $confirm);
                return $this->redirect($this->generateUrl('documentos'));
            }

            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Adjunto entity.
     *
     * @Route("/new", name="documentos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Adjunto();
        $form   = $this->createForm(new AdjuntoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Adjunto entity.
     *
     * @Route("/{id}", name="documentos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Adjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Adjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Adjunto entity.
     *
     * @Route("/{id}/edit", name="documentos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Adjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Adjunto entity.');
        }

        $editForm = $this->createForm(new AdjuntoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Adjunto entity.
     *
     * @Route("/{id}", name="documentos_update")
     * @Method("PUT")
     * @Template("MarleneActasBundle:Adjunto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Adjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Adjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AdjuntoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('documentos_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Adjunto entity.
     *
     * @Route("/{id}", name="documentos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MarleneActasBundle:Adjunto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Adjunto entity.');
            }
            $entity->borrarAdjunto();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Adjunto eliminado');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('documentos'));
    }

    /**
     * Creates a form to delete a Adjunto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
