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
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<?php
echo $this->Html->css('member');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        PHP研修課題2
    </title>
    <?= $this->Html->meta('icon') ?>
    <ul class="header">
        <h2>会 員 名 簿</h2>　
        <menu><a href="http://localhost/MIS/training/members">MemberList</a></memu>
        　/
        <!--<menu><a href="http://localhost/MIS/training/members/new">NewMember</a></memu>
        　/-->
        <menu><a href="http://localhost/MIS/training/members/item_list">ItemList</a></memu>
        <!--　/
        <menu><a href="http://localhost/MIS/training/members/new_item">NewItem</a></memu> -->
      </ul>
</nav>
</head>
<body>
    
    <?= $this->fetch('content') ?>

</body>
<br>
<br>
<footer>
    <th>フッター</th>
</footer>
</html>
