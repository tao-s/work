<?php
namespace Craft;

class RedactorFontColorPlugin extends BasePlugin
{
    public function getName()
    {
        return 'Redactor Font Color';
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getDeveloper()
    {
        return 'keitadev';
    }

    public function getDeveloperUrl()
    {
        return '';
    }

    public function init()
    {
        if (!craft()->isConsole())
        {
            if (craft()->request->isCpRequest() && craft()->userSession->isLoggedIn())
            {
                craft()->templates->includeJsResource('redactorfontcolor/js/fontcolor.js', true);
            }
        }
    }
}