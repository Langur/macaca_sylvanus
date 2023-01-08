<?php
/**
 * Sylvanusにおけるオブジェクトに対する処理
 * 
 * @copyright Copyright (c) 2017-2023 Akihisa ONODA
 * @license https://github.com/Langur/macaca_sylvanus/blob/main/LICENSE MIT
 * @link https://github.com/Langur/macaca_sylvanus#readme
 * @author Akihisa ONODA <akihisa.onoda@osarusystem.com>
 */

namespace Sylvanus;

/**
 * Sylvanusオブジェクトへの初期化処理。
 *
 * @param Kernel $kernel
 * @param array $param
 * @return bool
 */
function init($db, $type=null) {
    $result = false;
    
    switch ($type) {
    case 'mysql': 
        $db->setUSER(DB_USER);
        $db->setPASSWORD(DB_PASSWORD);
        $db->setHOST(DB_HOST);
        $db->setPORT(DB_PORT);
        $db->setNAME(DB_NAME);
        $db->setCHARSET(DB_CHARSET);
        $db->setTYPE($type);
        $db->setPREFIX(DB_PREFIX);
	$result = true;
        break;

    case 'sqlite':
        $db->setFILE(DB_FILE);
        $db->setCHARSET(DB_CHARSET);
        $db->setPREFIX(DB_PREFIX);
        $db->setTYPE($type);
	$result = true;
        break;

    default:
        break;
    }

    return $result;
}
