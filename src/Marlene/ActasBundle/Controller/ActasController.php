<?php

namespace Marlene\ActasBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Marlene\ActasBundle\Entity\Actas;
use Marlene\ActasBundle\Form\ActasType;
use Marlene\ActasBundle\Form\ActasFilterType;

use Marlene\ActasBundle\Entity\Cliente;
use Marlene\ActasBundle\Form\ClienteType;
use Marlene\ActasBundle\Form\ClienteFilterType;

use Marlene\ActasBundle\Entity\Abogado;
use Marlene\ActasBundle\Form\AbogadoType;
use Marlene\ActasBundle\Form\AbogadoFilterType;


/**
 * Actas controller.
 *
 * @Route("/actas")
 */
class ActasController extends Controller
{
    /**
     * Lists all Actas entities.
     *
     * @Route("/", name="actas")
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
        $filterForm = $this->createForm(new ActasFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('MarleneActasBundle:Actas')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('ActasControllerFilter');
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
                $session->set('ActasControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ActasControllerFilter')) {
                $filterData = $session->get('ActasControllerFilter');
                $filterForm = $this->createForm(new ActasFilterType(), $filterData);
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
            return $me->generateUrl('actas', array('page' => $page));
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
     * Creates a new Actas entity.
     *
     * @Route("/", name="actas_create")
     * @Method("POST")
     * @Template("MarleneActasBundle:Actas:new.html.twig")
     */
    public function createAction(Request $request)
    {
        //Request-request->get('nombre del div que contiene esa parte del form')->["campo del formulario"] para obtener el valor
        if($request->request->get("marlene_actasbundle_actas")["cliente"]=="")
        {
            $cliente  = new Cliente();
            $formCli = $this->createForm(new ClienteType(), $cliente);
            $formCli->bind($request);
            if ($formCli->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cliente);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'flash.create.success');
            }
        }
        if($request->request->get("marlene_actasbundle_actas")["abogadoContraparte"]=="")
        {
            $abogado  = new Abogado();
            $formAb = $this->createForm(new AbogadoType(), $abogado);
            $formAb->bind($request);
            if ($formAb->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($abogado);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'flash.create.success');
            }
        }
        $acta  = new Actas();
        $form = $this->createForm(new ActasType(), $acta);
        $form->bind($request);

        if ($form->isValid()) {
            var_dump($acta);
            if($request->request->get("marlene_actasbundle_actas")["cliente"]=="")
            {
                $acta->setCliente($cliente);
            }
            if($request->request->get("marlene_actasbundle_actas")["abogadoContraparte"]=="")
            {
                $acta->setAbogadoContraparte($abogado);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($acta);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('actas_show', array('id' => $acta->getId())));
        }
        return array(
            'entity' => $acta,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Actas entity.
     *
     * @Route("/new", name="actas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {

        $actasType = new ActasType();
        $entity = new Actas();
        $form   = $this->createForm($actasType, $entity);

        $cliente = new Cliente();
        $formCli   = $this->createForm(new ClienteType(), $cliente);

        $abogadoCp = new Abogado();
        $formAb   = $this->createForm(new AbogadoType(), $abogadoCp);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'cliente'=> $cliente,
            'formCli'=> $formCli->createView(),
            'abogadoCp'=> $abogadoCp,
            'formAb' => $formAb->createView()
        );
    }

    /**
     * Finds and displays a Actas entity.
     *
     * @Route("/{id}", name="actas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Actas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Actas entity.
     *
     * @Route("/{id}/edit", name="actas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Actas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actas entity.');
        }

        $editForm = $this->createForm(new ActasType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Actas entity.
     *
     * @Route("/{id}", name="actas_update")
     * @Method("PUT")
     * @Template("MarleneActasBundle:Actas:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MarleneActasBundle:Actas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ActasType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('actas_edit', array('id' => $id)));
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
     * Deletes a Actas entity.
     *
     * @Route("/{id}", name="actas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MarleneActasBundle:Actas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Actas entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('actas'));
    }

    /**
     * Creates a form to delete a Actas entity by id.
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
