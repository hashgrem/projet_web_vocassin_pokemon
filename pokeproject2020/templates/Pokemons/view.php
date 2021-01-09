<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pokemon $pokemon
 *
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(__('Delete Pokemon'), ['action' => 'delete', $pokemon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pokemon->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pokemons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pokemons view content">
            <h3><?= h($pokemon->name) ?></h3>
            <table>
                <?php
                echo "debut de table \n";


                if (!empty($pokemon->pokemon_stats))
                 {
                 //$name = ["pokemon" => ["pokemon_stats"] => ["stat"] => 'name'];?>
                 <div class="table-responsive">
                    <table>
                      <?php foreach ($pokemon->pokemon_stats as $pokemonStats)
                        {

                         ?>
                        <tr>
                          <td>
                            <?php
                              echo $pokemonStats['stat']['name'];
                            ?>
                          </td>
                          <td><?= h($pokemonStats->value) ?></td>
                        </tr>
                      <?php


                      }
                    }
                 ?>
              </table>
            </div>
          </div>



          <?php
          //Affichage de l'image
          $url = $pokemon['default_front_sprite_url'];
          ?>
          <img src="<?php echo $url; ?>">

          <?php
          //Affichage des 2 types
          foreach ($pokemon->pokemon_types as $pokemonTypes)
            {

             ?>
            <tr>
              <td>
                <?php
                  echo $pokemonTypes['type']['name'];
                ?>
              </td>

            </tr>
            <?php
          }

          //Carousel:
          echo "Carousel: \n";
          $url = $pokemon['default_front_sprite_url'];
          $url_back = $pokemon['default_back_sprite_url'];
          $url_shiny = $pokemon['front_shiny_url'];
          ?>
          <img src="<?php echo $url; ?>">
          <img src="<?php echo $url_back; ?>">
          <img src="<?php echo $url_shiny; ?>">











            <div class="related">
                <h4><?= __('Related Pokemon Types') ?></h4>
                <?php if (!empty($pokemon->pokemon_types)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Pokemon Id') ?></th>
                            <th><?= __('Type Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($pokemon->pokemon_types as $pokemonTypes) : ?>
                        <tr>
                            <td><?= h($pokemonTypes->id) ?></td>
                            <td><?= h($pokemonTypes->pokemon_id) ?></td>
                            <td><?= h($pokemonTypes->type_id) ?></td>
                            <td><?= h($pokemonTypes->created) ?></td>
                            <td><?= h($pokemonTypes->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PokemonTypes', 'action' => 'view', $pokemonTypes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PokemonTypes', 'action' => 'edit', $pokemonTypes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PokemonTypes', 'action' => 'delete', $pokemonTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pokemonTypes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
