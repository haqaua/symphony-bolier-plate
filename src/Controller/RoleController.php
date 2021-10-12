<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/role")
 */
class RoleController extends AbstractController
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @Route("/", name="role_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $query = $request->get('find');
        $status = $request->get('status') ?? 'active';

        $roles = $this->roleRepository->filterRoles($query, $status);

        return $this->render('role/index.html.twig', [
            'roles' => $roles,
        ]);
    }

    /**
     * @Route("/new", name="role_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $role = new Role('');
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->roleRepository->save($role);

            return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/new.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="role_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Role $role): Response
    {
        if ($role->getName() === 'Administrator') {
            $this->addFlash('danger', 'Administrator role cannot be edit!');
            return $this->redirectToRoute('role_index');
        }
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->roleRepository->save($role);

            return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/edit.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{name}/copy", name="role_copy", methods={"GET","POST"})
     */
    public function copy(Request $request, string $name): Response
    {
        if ($name === 'Administrator') {
            $this->addFlash('danger', 'Administrator role cannot be duplicated!');
            return $this->redirectToRoute('role_index');
        }
        $role = new Role($name);
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->roleRepository->save($role);

            return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/copy.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="role_delete", methods={"POST"})
     */
    public function delete(Request $request, Role $role): Response
    {
        if ($role->getName() === 'Administrator') {
            $this->addFlash('danger', 'Administrator role cannot be deleted!');
        }
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token')) && $role->getName() !== 'Administrator') {
            $this->roleRepository->softDelete($role);
        }

        return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
    }
}
