<?php

namespace App\Model;

use Contao\Date;
use Contao\MemberModel;

/**
 * @property string  $ref_year
 * @property string  $ref_author
 * @property string  $ref_title
 */
class ExtMemberModel extends MemberModel
{

	public static function findAllReference()
	{
        $arrColumns =  array("ref_year != '' AND ref_author != '' AND ref_title != ''");
		return static::findBy($arrColumns,[]);
	}
    
}