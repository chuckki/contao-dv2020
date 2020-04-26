<?php

namespace App\Model;

use Contao\Model;

/**
 * @property string  $ref_year
 * @property string  $ref_author
 * @property string  $ref_title
 * @property int  $tstamp
 */
class ReferenceModel extends Model
{
	protected static $strTable = 'tl_reference';

	public static function findRefByUser(int $userId)
    {
        return static::findOneBy('pid',$userId);
    }

    public static function findAllAsArray(array $arrOptions = array())
    {
        $result = static::findAll($arrOptions);

        if(!$result){
            return [$result];
        }

        return $result;
    }
}