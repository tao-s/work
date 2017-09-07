<?php
namespace Craft;

class TwigExtensionPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Twig Extension Placeholder');
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'keitadev';
    }

    public function getDeveloperUrl()
    {
        return '';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.twigextension.filters.EducationCareerFilters');
        return new EducationCareerFilters();
    }
}