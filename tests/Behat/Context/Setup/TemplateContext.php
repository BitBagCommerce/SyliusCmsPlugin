<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

final class TemplateContext implements Context
{
    private Filesystem $filesystem;
    private $tempConfigFile;
    private $tempTemplateFile;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * @Given there is an existing template with :template value
     */
    public function thereIsAnExistingTemplateWithValue($template)
    {
        $this->tempConfigFile = __DIR__ . '/../../../Application/config/packages/sylius_cms_test.yaml';
        $config = [
            'sylius_cms' => [
                'templates' => [
                    'pages' => [$template]
                ],
            ],
        ];

        $this->filesystem->dumpFile($this->tempConfigFile, Yaml::dump($config));

        $this->tempTemplateFile = $this->getTemplateFilePath($template);
        $dummyTemplateContent = "<div class='custom-layout'>This is a test template for: $template</div>";

        $this->filesystem->dumpFile($this->tempTemplateFile, $dummyTemplateContent);
    }

    /**
     * Get the real template file path from the given template name.
     */
    private function getTemplateFilePath($template): string
    {
        $templatePath = str_replace('@SyliusCmsPlugin', 'Application/templates/bundles/SyliusCmsPlugin', $template);
        return __DIR__ . '/../../../' . $templatePath;
    }

    /**
     * @AfterScenario
     */
    public function cleanup(): void
    {
        if ($this->tempConfigFile && file_exists($this->tempConfigFile)) {
            $this->filesystem->remove($this->tempConfigFile);
        }

        if ($this->tempTemplateFile && file_exists($this->tempTemplateFile)) {
            $this->filesystem->remove($this->tempTemplateFile);
        }
    }
}
