<?php

namespace App;

use App\Entity\Template;
use App\Template\TemplateBasicTag;
use App\Template\TemplateTagHydrator;

class TemplateManager
{
    /**
     * @var TemplateTagHydrator
     */
    private $templateTag;

    /**
     * TemplateManager constructor.
     * @param TemplateTagHydrator|null $templateTag // keep compatibility with old script
     */
    public function __construct(?TemplateTagHydrator $templateTag = null)
    {
        if ($templateTag) {
            $this->templateTag = $templateTag;
        }
    }

    /**
     * Return cloned template with computed data
     *
     * /!\ Signature must not change
     * @param Template $tpl
     * @param array<string, mixed> $data
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $tags = $this->getTemplateTag()->getTagsData($data);
        $replaced->subject = $this->computeText($replaced->subject, $tags);
        $replaced->content = $this->computeText($replaced->content, $tags);

        return $replaced;
    }

    /**
    * Set tag strategy
    * @param TemplateTagHydrator $templateTag
    */
    public function setTemplateTag(TemplateTagHydrator $templateTag): void
    {
        $this->templateTag = $templateTag;
    }

    /**
    * Get defined or default tag strategy.
    * @return TemplateTagHydrator
    */
    public function getTemplateTag(): TemplateTagHydrator
    {
        if (!$this->templateTag) {
            $this->templateTag = new TemplateBasicTag();
        }

        return $this->templateTag;
    }

    /**
    * replace tags in given text
    * @param $text
    * @param array<string, string> $aryTags //Tag to replace, Value replaced
    * @return string
     */
    private function computeText($text, array $aryTags): string
    {
        return  str_replace(array_keys($aryTags), array_values($aryTags), $text);
    }
}
