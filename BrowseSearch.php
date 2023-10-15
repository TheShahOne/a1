<!DOCTYPE html>
<html>
<head>
    <title>COMP 3512 Assign1</title>
    <link rel="stylesheet" type="text/css" href="css/BrowseSearch.css">
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
        <h3>Song List</h3>
        <?php
            require_once('includes/dbh.inc.php'); 

            //query to retrieve songs
            $sql = "SELECT s.song_id, s.title, a.artist_name, s.year, g.genre_name, s.popularity
                    FROM songs s
                    INNER JOIN artists a ON s.artist_id = a.artist_id
                    INNER JOIN genres g ON s.genre_id = g.genre_id";

            $stmt = $pdo->query($sql);
            
            //check query success
            if ($stmt) {
                //start table
                echo "<table>";
                echo "<tr>";
                echo "<th>Title</th>";
                echo "<th>Artist</th>";
                echo "<th>Year</th>";
                echo "<th>Genre</th>";
                echo "<th>Popularity</th>";
                echo "<th>Add to Favorites</th>";  // Add this column
                echo "<th>View</th>";
                echo "</tr>";

                //loop to display song data per row
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td><a href='SingleSong.php?song_id={$row['song_id']}'>{$row['title']}</a></td>";
                    echo "<td>{$row['artist_name']}</td>";
                    echo "<td>{$row['year']}</td>";
                    echo "<td>{$row['genre_name']}</td>";
                    echo "<td>{$row['popularity']}</td>";
                    //add to fav link
                    echo "<td><a href='Favorites.php?song_id={$row['song_id']}'>Add to Favorites</a></td>";
                    echo "<td><a href='SingleSong.php?song_id={$row['song_id']}'>View</a></td>";
                    echo "</tr>";
                }
                //end table
                echo "</table>";
            } else {
                echo "No songs found.";
            }
        ?>
    </main>


    <footer>
        <p> COMP 3512 &copy; Sadman Shahryier <a href="https://github.com/TheShahOne/COMP3512_A1" style="color: yellow;"> github</a></p>
    </footer>

</body>
</html>
