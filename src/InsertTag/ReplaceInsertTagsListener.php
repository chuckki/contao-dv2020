<?php

namespace App\InsertTag;

use App\Model\ReferenceModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendUser;
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
            return date_diff(date_create('2021-07-18'), date_create())->format('%a');
        }

        if ('refArticel' === $insertTag) {
                $objUser     = FrontendUser::getInstance();
                $userRef = ReferenceModel::findRefByUser($objUser->id);
                return $userRef->ref_author . ' (' . $userRef->ref_year . ') ' . $userRef->ref_title;
        }

        return false;
    }
}
