<?php

namespace App\Model;

use Contao\Model;

/**
 * @property string  $ref_year
 * @property string  $ref_author
 * @property string  $ref_title
 * @property integer $tstamp
 * @property integer $pid
 * @property boolean $submission
 * @property string  $q1
 * @property string  $q2
 * @property string  $q3
 * @property string  $q4
 * @property string  $q5
 * @property string  $q6
 * @property string  $q7
 * @property string  $q8
 * @property string  $q9
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
            return [];
        }

        return $result;
    }
}