<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

echo 'Hello ' . $managerFirstName . ', <br/> <br/>' . 
'This email has been sent to you because a candidate applied for a job offer in your department:<br/>' . 
 $candidateInfo['first_name'] . ' ' . $candidateInfo['last_name'] . ' applies for the ' .
 $title . ' vacancy and is born '. $candidateInfo['birth_date'] . '.<br/> <br/>' . 
'You will find his resume attached to this email. <br/> <br/> <br/>' . 
'<hr><p style="font-size:0.8em;">this email has been sent to you automatically, please do not reply.</p></body>';

echo '<hr />';



