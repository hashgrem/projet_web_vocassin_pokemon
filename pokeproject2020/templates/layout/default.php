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

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7418e7179d.js" crossorigin="anonymous"></script>
    <?= $this->Html->css(['style', 'milligram.min', 'cake', 'style']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="container navbar navbar-expand-lg navbar-light bg-light">

        <?= $this->Html->link(
            $this->Html->image('Master-Ball-256.png', [
                'height' => 64,
                'width' => 64,
            ]),
            '/',
            [
                'class' => 'navbar-brand',
                'escape' => false,
            ]
        ) ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <?= $this->Html->link(__('Pokemons'), ['controller' => 'Pokemons', 'action' => 'index'], ['class' => "nav-link"]) ?>
                </li>
            </ul>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer class="container">
    <div class="row">
        <div class="col-auto snorlax">
            <?= $this->element('Footer/snorlax') ?>
        </div>
        <div class="col-auto text-center">
                A sleeping Pokemon block the way !
        </div>
    </div>
    </footer>
</body>
</html>
