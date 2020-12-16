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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <style type="text/css">
      @media only screen and (min-width: 600px) { .maxW { width:600px !important; } }
    </style>
</head>
<body style="font-family:arial;">
    <?= $this->fetch('content') ?>

   <!--[if (gte mso 9)|(IE)]><table width="600" align="center" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->
   <div class="maxW" style="max-width:600px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td>
          <a href="https://www.nestle.be"><img width="80%" src="https://www.nestle.be/themes/custom/da_vinci_code/logo.png"/></a>
        </td>
      </tr>
    </table>
  </div>
  <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
  
</body>
</html>
