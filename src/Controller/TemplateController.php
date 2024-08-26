<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\CmsPlugin\Entity\TemplateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TemplateController extends ResourceController
{
    public function getContentElementsAction(int $id): JsonResponse
    {
        $template = $this->getDoctrine()->getRepository(TemplateInterface::class)->find($id);
        if (null === $template) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Template not found',
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'content' => $template->getContentElements(),
        ]);
    }
}
