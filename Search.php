<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style.css">
    <title>Otaku Search</title>
</head>
<?php
  require_once("sparqllib.php");
  $test = "";
  if (isset($_POST['search'])) {
    $test = $_POST['search'];
    $data = sparql_get(
      "http://localhost:3030/otakusearch",
      "
        PREFIX p: <http://otakusearch.com>
        PREFIX d: <http://otakusearch.com/ns/data#>
        
        SELECT ?Title ?Type ?Author ?Desc ?Genre ?Status
        WHERE
        { 
            ?x	d:title ?Title;
  				      d:desc	?Desc.
  			    ?g 	d:genreTitle ?Genre;
  				      d:isGenre ?x.
  			    ?a 	d:authorTitle ?Author;
  				      d:isAuthor ?x.
  			    ?t 	d:typeTitle ?Type;
  				      d:isType ?x.
  			    ?s 	d:statusTitle ?Status;
  				      d:isStatus ?x.
                FILTER (regex(?Title, '$test', 'i') || regex(?Type, '$test', 'i') || regex(?Author,  '$test', 'i') || regex(?Genre, '$test', 'i'))
        }
            "
    );
  } else {
    $data = sparql_get(
      "http://localhost:3030/otakusearch",
      "
        PREFIX p: <http://otakusearch.com>
        PREFIX d: <http://otakusearch.com/ns/data#>
      
        SELECT ?Title ?Type ?Author ?Desc ?Genre ?Status
        WHERE
        { 
            ?x	d:titleA ?Title;
  				      d:desc	?Desc.
  			    ?g 	d:genreTitle ?Genre;
  				      d:isGenre ?x.
  			    ?a 	d:authorTitle ?Author;
  				      d:isAuthor ?x.
  			    ?t 	d:typeTitle ?Type;
  				      d:isType ?x.
  			    ?s 	d:statusTitle ?Status;
  				      d:isStatus ?x.
        }
            "
    );
  }

  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  // var_dump($data);
  // $search = $_POST['search-aniln'];
  //         var_dump($search);
  ?>
<body>
    <header>
        <nav role="navigation">
            <div id="menuToggle">
              <input type="checkbox" />
        
              <span></span>
              <span></span>
              <span></span>
              
              <ul id="menu">
                <a href="index.html"><li>Home</li></a>
                <a href="#"><li>Search</li></a>
              </ul>
            </div>
        </nav>
        <div class="grid-mid">
            <ul class="menu-bar">
                <li>All</li>
                <li>Anime</li>
                <li>Manga</li>
                <li>Light Novel</li>
            </ul>
        </div>
        <div class="grid-r">
            <p class="brand">
                OTAKU SEARCH
            </p>
        </div>
    </header>
    <div class="searchMain">
        <h1 class="title">What are you looking for?</h1>
        <form action ="" method="post" id="nameform">
          <div class="container">
            <input name="search" type="text" placeholder="Search...">
            <div class="search"></div>
          </div>
        </form>
    </div>
    <div class=content>  
        <div class="contentContainer">
        <?php foreach ($data as $dat) : ?>
            <div class="contentBox">
                <h2><?= $dat['Title'] ?></h2>
                <div class="contentContent">
                <h4>Type</h4>
                <h4>Author</h4>
                <h4>Genre</h4>
                <h4>Status</h4>
                </div>
                <div class="contentContent">
                <p><?= $dat['Type'] ?></p>
                <p><?= $dat['Author'] ?></p>
                <p><?= $dat['Genre'] ?></p>
                <p><?= $dat['Status'] ?></p>
                </div>
                </br>
                <h4>Description </h4>
                <p><?= $dat['Desc'] ?></p>
                
                <div class="line"></div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>