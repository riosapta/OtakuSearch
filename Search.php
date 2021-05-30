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
            ?s  d:title ?Title;
                d:type ?Type;
                d:author ?Author;
                d:desc ?Desc;
                d:genre ?Genre;
                d:status ?Status
                FILTER regex(?Title, '$test')
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
            ?s  d:title ?Title;
                d:type ?Type;
                d:author ?Author;
                d:desc ?Desc;
                d:genre ?Genre;
                d:status ?Status
                d:episodeChapter ?JumlahEps
        }
            "
    );
  }

  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  var_dump($data);
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
                <a href="#"><li>Home</li></a>
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
        <p>test</p>
        <?php foreach ($data as $dat) : ?>
            <div class="contentBox">
                <h2><?= $dat['Title'] ?></h2>
                <p>Type&emsp;&emsp;&emsp;&emsp;: <?= $dat['Type'] ?></p>
                <p>Author&emsp;&emsp;&emsp;: <?= $dat['Author'] ?></p>
                <p>Genre&emsp;&emsp;&emsp; : <?= $dat['Genre'] ?></p>
                <p>Status&emsp;&emsp;&emsp;: <?= $dat['Status'] ?></p>
                <p>Description : <?= $dat['Desc'] ?></p>
                <div class="line"></div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>