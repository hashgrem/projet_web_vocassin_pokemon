<h1> Bienvenue sur le Tableau de bord !</h1>


<!-- Affichage Poids moyen des pokemons de la 4ième génération-->

<div class="pokemons view content"> <strong><p class="card">Poids moyen des pokemons de la 4ième génération: </strong> <?php
  foreach ($query['moy_quatrieme_gene'] as $Weight) :
      echo "<br>"."<br>";
      echo($Weight->avgWeight);
      echo "<br>";
  endforeach; ?></p>

<!-- Affichage  Nombre de pokemons de type fée dans les générations 1, 3 et 7  -->

  <strong><p class="card"> Nombre de pokemons de type fée dans les générations 1, 3 et 7: </strong> <?php
  foreach ($query['nombre_de_fee'] as $Fairy) :
      echo "<br>"."<br>";
      echo($Fairy->countFairies);
      echo "<br>";
  endforeach; ?> </p>


<!-- Les 10 premiers pokemons qui possèdent la plus grande vitesse  -->

  <strong><p class="card">Les 10 premiers pokemons qui possèdent la plus grande vitesse: </strong> <?php
  echo "<br>"."<br>";
  foreach ($query['les_plus_rapides'] as $pokemon) :
    echo($pokemon->name);
    echo "\t";
    foreach($pokemon->_matchingData as $pokemonStat):
    echo($pokemonStat->value);
    endforeach;
    echo "<br>";
  endforeach;


 ?> </p>
</div>

 <?php
 echo "<br>"."<br>";

  ?>
