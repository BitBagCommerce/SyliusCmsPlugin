<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller\Action\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RetrievePackageInfoAction
{
    public function __invoke(Request $request): Response
    {
        try {
            file_get_contents(\sprintf(
                "https://intranet.bitbag.shop/retrieve-package-info?packageName='%s'&url='%s'",
                'bitbag/cms-plugin',
                \sprintf('%s://%s', $request->getScheme(), $request->getHttpHost()),
            ));
        } catch (\Exception) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        return new Response();
    }
}
