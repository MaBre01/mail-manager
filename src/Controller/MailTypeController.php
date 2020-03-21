<?php

namespace App\Controller;

use App\Entity\MailType;
use App\Form\MailTypeType;
use App\Repository\MailTypeRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MailTypeController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/settings/mail-types"
     * }, name="mail-type_list")
     */
    public function list(MailTypeRepository $mailTypeRepository): Response
    {
        $mailTypes = $mailTypeRepository->findAllOrdered();

        return $this->render('mail_type/list.html.twig', [
            'mailTypes' => $mailTypes
        ]);
    }

    /**
     * @Route({
     *     "en": "/settings/mail-types/add"
     * }, name="mail-type_add")
     */
    public function add(Request $request, MailTypeRepository $mailTypeRepository, TranslatorInterface $translator): Response
    {
        $mailType = new MailType();
        $form = $this->createForm(MailTypeType::class, $mailType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $mailTypeRepository->save($mailType);
                $this->addFlash('success', $translator->trans('mail_type.added', [], 'mail-type'));

                return $this->redirectToRoute('mail-type_list');
            } catch (ORMException $e) {
                $this->addFlash('error', $translator->trans('error.save'));
            }
        }

        return $this->render('mail_type/add.html.twig', [
            'addForm' => $form->createView()
        ]);
    }

    /**
     * @Route({
     *     "en": "/settings/mail-types/{id}/edit"
     * }, name="mail-type_edit")
     */
    public function edit(MailType $mailType, Request $request, MailTypeRepository $mailTypeRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(MailTypeType::class, $mailType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $mailTypeRepository->save($mailType);
                $this->addFlash('success', $translator->trans('mail_type.edited', [], 'mail-type'));

                return $this->redirectToRoute('mail-type_list');
            } catch (ORMException $e) {
                $this->addFlash('error', $translator->trans('error.save'));
            }
        }

        return $this->render('mail_type/edit.html.twig', [
            'mailType' => $mailType,
            'editForm' => $form->createView()
        ]);
    }

    /**
     * @Route({
     *     "en": "/settings/mail-types/{id}/delete"
     * }, name="mail-type_delete")
     */
    public function delete(MailType $mailType, MailTypeRepository $mailTypeRepository, TranslatorInterface $translator): Response
    {
        try {
            $mailTypeRepository->delete($mailType);
            $this->addFlash('success', $translator->trans('mail_type.deleted', [], 'mail-type'));

        } catch (ORMException $e) {
            $this->addFlash('error', $translator->trans('error.delete'));
        }

        return $this->redirectToRoute('mail-type_list');
    }
}
