<!DOCTYPE html>
<html>
<head>
    <title>COMP 3512 Assign1</title>
    <link rel="stylesheet" type="text/css" href="css/Search.css">
</head>
<body>
    <header>
        <h1>COMP 3512 Assign1</h1>
        <h2>Sadman Shahryier</h2>
        <nav>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="BrowseSearch.php">Browse</a></li>
                <li><a href="Search.php">Search</a></li>
                <li><a href="About.php">About Us</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h3>Song Search</h3>
        <!-- pass to BrowseSearch.php -->
        <form method="GET" action="BrowseSearch.php">

            <!-- search by title -->
            <div>
                <input type="radio" id="searchTitle" name="searchOption" value="title">
                <label for="searchTitle">Title</label>
                <input type="text" id="searchBar" name="searchText">
            </div>

            <!-- artist select dropdown -->
            <div>
                <input type="radio" id="searchArtist" name="searchOption" value="artist">
                <label for="searchArtist">Artist</label>
                <select id="searchArtistDropdown" name="searchArtistDropdown">
                    <option value=""></option>
                    <?php
                        require_once('includes/dbh.inc.php');
                        //get artist names
                        $sql = "SELECT artist_name FROM artists";
                        $stmt = $pdo->query($sql);
                        //loop thru as associative arr. 
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            //generate option element
                            echo "<option value='" . $row['artist_name'] . "'>" . $row['artist_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- genre select dropdown -->            
            <div>
                <input type="radio" id="searchGenre" name="searchOption" value="genre">
                <label for="searchGenre">Genre</label>
                <select id="searchBar" name="searchText">
                    <option value=""></option>
                    <?php
                        //get genres
                        $sql = "SELECT genre_name FROM genres";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        //loop 
                        while ($row = $stmt->fetch()) {
                            //generate option element
                            echo "<option value='" . $row['genre_name'] . "'>" . $row['genre_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- search by year -->              
            <div>
                <input type="radio" id="searchYear" name="searchOption" value="year">
                <label for="searchYear">Year</label>
                <input type="text" id="searchBeforeYear" name="searchBeforeYear" placeholder="Before year">
                <input type="radio" id="lessRadio" name="yearOption" value="less">
                <label for="lessRadio">Less</label>
                <input type="text" id="searchAfterYear" name="searchAfterYear" placeholder="After year">
                <input type="radio" id="moreRadio" name="yearOption" value="more">
                <label for="moreRadio">Greater</label>
            </div>
            
            <button type="submit">Search</button>
        </form>
    </main>

    <footer>
        <p> COMP 3512 &copy; Sadman Shahryier <a href="https://github.com/TheShahOne/COMP3512_A1" style="color: yellow;"> github</a></p>
    </footer>

</body>
</html>
