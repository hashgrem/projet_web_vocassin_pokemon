
<figure class="card card--<?= $pokemon->first_type ?>">
    <div class="card__image-container poke-sprite-<?= $pokemon->pokedex_number ?>" id="main-poke-sprites">
        <?= $this->Html->image($pokemon->main_sprite); ?>
    </div>
    
    <figcaption class="card__caption">
        <h1 class="card__name"><?= $pokemon->name ?></h1>

        <h3 class="card__type <?= $pokemon->first_type ?>"">
            <?= $pokemon->first_type ?>
        </h3>

        <?php if ($pokemon->has_second_type) : ?>
        <h3 class="card__second_type <?= $pokemon->second_type ?>">
            <?= $pokemon->second_type ?>
        </h3>
        <?php endif ?>

        <table class="card__stats">
            <tbody>
                <tr>
                    <th>Height</th>
                    <td><?= $pokemon->height ?></td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td><?= $pokemon->weight ?></td>
                </tr>
            </tbody>
        </table>

        <div>
            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $pokemon->id], ['escape' => false, 'class' => 'btn btn-sm btn-info', 'title' => __('Voir')]) ?>
            <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $pokemon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pokemon->name), 'escape' => false, 'class' => 'btn btn-sm', 'title' => __('Supprimer')]) ?>
        </div>
    </figcaption>
</figure>
