<?php

namespace App\Model;

use Contao\Model;

/**
 * @property string  $ref_year
 * @property string  $ref_author
 * @property string  $ref_title
 */
class ReferenceModel extends Model
{
	protected static $strTable = 'tl_reference';

	public function findRefByUser(int $userId)
    {
        return static::findOneBy('pid',$userId);
    }
}