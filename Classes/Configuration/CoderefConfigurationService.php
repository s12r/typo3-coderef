<?php

declare(strict_types=1);

namespace SomeBdyElse\Coderef\Configuration;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CoderefConfigurationService
{
    /**
     * @return string[]
     */
    public function getTables(): array
    {
        try {
            $tablesString = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ExtensionConfiguration::class)
                ->get('coderef', 'tables');
            $tables = GeneralUtility::trimExplode(',', $tablesString);
            return $tables;
        } catch (ExtensionConfigurationExtensionNotConfiguredException $e) {
            return [];
        } catch (ExtensionConfigurationPathDoesNotExistException $e) {
            return [];
        }
    }
}
