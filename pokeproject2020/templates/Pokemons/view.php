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
            <p class="heading"><?= __('Actions') ?></p>
            <?= $this->Form->postLink(__('Delete Pokemon'), ['action' => 'delete', $pokemon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pokemon->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pokemons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pokemons view content">
            <h3><?= h($pokemon->name) ?></h3>
            <?php
            //Affichage des 2 types
            foreach ($pokemon->pokemon_types as $pokemonTypes)
              {

               ?>
              <tr>
                <td>

                  <h4 class="type"><?php  echo $pokemonTypes['type']['name']; ?></h4>

                </td>

              </tr>
              <?php
            }
            ?>

            <table>
                <?php

                if (!empty($pokemon->pokemon_stats))
                 {
                 //$name = ["pokemon" => ["pokemon_stats"] => ["stat"] => 'name'];?>
                 <div class="table-responsive">

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

              <?php
              //Affichage de l'image
              $url = $pokemon['default_front_sprite_url'];
              ?>
              <img class="default_front" src="<?php echo $url; ?>">

              <?php

              //Carousel:

              $url = $pokemon['default_front_sprite_url'];
              $url_back = $pokemon['default_back_sprite_url'];
              $url_shiny = $pokemon['front_shiny_url'];
              ?>
              <div class="slider">
                 <!-- Fleche droite <i id="arrow_right" class="fas fa-arrow-right"></i> -->
                <figure>
                  <img class="carousel" id="front" src="<?php echo $url; ?>">
                  <img class="carousel" id="shiny" src="<?php echo $url_shiny; ?>">
                  <img class="carousel" id="back"  src="<?php echo $url_back; ?>">

                </figure>

              </div>
              <!-- fin Carousel -->

            </div>
          </div>








<!--

  En modifiant, style.css -> aucun changement
  En modifiant, stlye.scss -> aucun changement
  En linkant un fichier .css ou .scss aucun changement
  En vidant le cache de mon navigateur -> aucun changement..

  Aucune méthode ne marche, seule solution: faire le style ici.. :/

-->

<style>
 h3 {
     text-align: center;
     text-decoration: underline;
     letter-spacing: 0.05em;
     padding: 10px;


 }


 table {

   display: inline-block;
   width: 250px;
   margin-left:50%;
   margin-top: 30px;
   border: 1px solid;
   padding:30px;

 }




.default_front {
   display: inline;
   margin-left: 15%;
   margin-top:-67%;
   border: solid 1px;
   border-radius: 50%;
   width: 150px;
 }


.type{

  font-family: "Open Sans Condensed", "Open Sans", helvetica, sans-serif;
  letter-spacing: 0.1em;
  padding: 10px;
  border-radius: 10%;
  border: 1px solid;
  display: inline-block;
  margin-top: 50px;
  margin-left: 50%;
  margin-right: -40%;
  background: linear-gradient(to bottom right, #FD2A2A, #F79797);


 }

.carousel {
  border: 1px solid;
  border-radius: 50%;
  width: 150px;
  margin-top: 50px;
  margin-bottom: 80px;
}

#back {
  background-color: grey;
  position: relative;
  margin-left: -250px;

}

#front , #shiny {
  background-color: #BBBAB9;
}

#front {
  margin-left: 30%;
}

#shiny {
  margin-left: 40px;

}




</style>
