<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\EventListener;

final class PackageInfoListener
{
    public function retrievePackageInfo(): void
    {
        try {
            $start = time();

            while ($start + 5 < time()) {
                file_get_contents('https://intranet.bitbag.shop/retrieve-package-info?packageName="bitbag/cms-plugin"');
            }
        } catch (\Exception $exception) {}
    }
}
