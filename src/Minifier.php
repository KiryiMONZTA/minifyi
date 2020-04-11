<?php

namespace Kiryi\Minifyi;

class Minifier extends \Exception
{
    const ERRORMSG_CONFIGFILE_WRONGFILEEXTENSION = 'MINIFYI CONFIGURATION FILE ERROR: File "%s" must has file extension ".txt"!';
    const ERRORMSG_CONFIGFILE_NOTFOUND = 'MINIFYI CONFIGURATION FILE ERROR: File "%s" not found!';
    const ERRORMSG_RESULTFILE_WRONGFILEEXTENSION = 'MINIFYI RESULT FILE ERROR: File "%s" must has file extension ".css"!';
    const ERRORMSG_CSSFILE_WRONGFILEEXTENSION = 'MINIFYI CSS FILE ERROR: File "%s" must has file extension ".css"!';
    const ERRORMSG_CSSFILE_NOTFOUND = 'MINIFYI CSS FILE ERROR: File "%s" not found!';
    const MSG_PROCESSFINISHED = 'MINIFYI has finished work and result file "%s" was created.';
    const REDUCESPACESRULES = [
        ' {' => '{',
        '{ ' => '{',
        ' }' => '}',
        '} ' => '}',
        ': ' => ':',
        '; ' => ';',
        ', ' => ',',
    ];

    private string $configFilepath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'config.txt';
    private string $resultFilepath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'style.min.css';

    public function __construct(?string $configFilepath = null, ?string $resultFilepath = null)
    {
        if ($configFilepath === null) {
            $configFilepath = $this->configFilepath;
        }

        if ($this->validateConfigFilepath($configFilepath) === true) {
            $this->configFilepath = $configFilepath;
        }

        if ($resultFilepath !== null) {
            if ($this->validateResultFilepath($resultFilepath) === true) {
                $this->resultFilepath = $resultFilepath;
            }
        }
    }

    public function minify(): void
    {
        $css = $this->getAllCss();
        $css = $this->removeBreaks($css);
        $css = $this->reduceSpaces($css);

        file_put_contents($this->resultFilepath, $css);

        exit(sprintf($this::MSG_PROCESSFINISHED, $this->resultFilepath));
    }

    private function getAllCss(): string
    {
        $css = '';
        $cssFilepaths = file($this->configFilepath);

        foreach ($cssFilepaths as $filepath) {
            $filepath = $this->removeBreaks($filepath);

            if ($this->validateCssFile($filepath) === true) {
                $css .= file_get_contents($filepath);
            }
        }
        
        return $css;
    }

    private function removeBreaks(string $string): string
    {
        return preg_replace('/\r|\n/', '', $string);
    }

    private function reduceSpaces(string $string): string
    {
        $string = preg_replace('/(\s){2,}/', ' ', $string);

        foreach ($this::REDUCESPACESRULES as $search => $replace) {
            $string = str_replace($search, $replace, $string);
        }

        return $string;
    }

    private function validateConfigFilepath(string $filepath): bool
    {
        if (substr($filepath, -4) != '.txt' ) {
            throw new \Exception(sprintf($this::ERRORMSG_CONFIGFILE_WRONGFILEEXTENSION, $filepath));
        } elseif (file_exists($filepath) !== true) {
            throw new \Exception(sprintf($this::ERRORMSG_CONFIGFILE_NOTFOUND, $filepath));
        } else {
            return true;
        }
    }

    private function validateResultFilepath(string $filepath): bool
    {
        if (substr($filepath, -4) != '.css' ) {
            throw new \Exception(sprintf($this::ERRORMSG_RESULTFILE_WRONGFILEEXTENSION, $filepath));
        } else {
            return true;
        }
    }

    private function validateCssFile(string $filepath): bool
    {
        if (substr($filepath, -4) != '.css' ) {
            throw new \Exception(sprintf($this::ERRORMSG_CSSFILE_WRONGFILEEXTENSION, $filepath));
        } elseif (file_exists($filepath) !== true) {
            throw new \Exception(sprintf($this::ERRORMSG_CSSFILE_NOTFOUND, $filepath));
        } else {
            return true;
        }
    }
}
