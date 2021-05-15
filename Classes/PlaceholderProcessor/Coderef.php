<?php

declare(strict_types=1);

namespace SomeBdyElse\Coderef\PlaceholderProcessor;

use TYPO3\CMS\Core\Configuration\Processor\Placeholder\PlaceholderProcessorInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Coderef implements PlaceholderProcessorInterface
{
    public function canProcess(string $placeholder, array $referenceArray): bool
    {
        return is_string($placeholder) && (strpos($placeholder, '%coderef(') !== false);
    }

    public function process(string $value, array $referenceArray)
    {
        [$table, $coderef] = explode(':', $value);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $uid = $queryBuilder
            ->select('uid')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('tx_coderef_identifier', $queryBuilder->createNamedParameter($coderef))
            )
            ->execute()->fetchOne();

        if ($uid === false) {
            throw new \UnexpectedValueException('Coderef not found: ' . $value, 1621033619105);
        }

        return $uid;
    }
}
