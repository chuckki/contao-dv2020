<?php

namespace App\InsertTag;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Terminal42\ServiceAnnotationBundle\ServiceAnnotationInterface;

class ReplaceInsertTagsListener implements ServiceAnnotationInterface
{
    /**
     * @Hook("replaceInsertTags")
     */
    public function onReplaceInsertTags(
        string $insertTag,
        bool $useCache,
        string $cachedValue,
        array $flags,
        array $tags,
        array $cache,
        int $_rit,
        int $_cnt
    )
    {
        if ('cookieDay' === $insertTag) {
            return date_diff(date_create('2020-07-18'), date_create())->format('%a');
        }

        return false;
    }
}
