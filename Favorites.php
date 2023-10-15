<!DOCTYPE html>
<html>
<head>
    <title>COMP 3512 Favorites</title>
    <link rel="stylesheet" type="text/css" href="css/Favorites.css">
</head>
<body>
    <header>
        <h1>COMP 3512 Favorites</h1>
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
        <h3>Your Favorites</h3>

        <?php
            //check query parameter
            if (isset($_GET['song_id'])) {
                $song_id = $_GET['song_id'];

                require_once('includes/dbh.inc.php');

                //fetch song info on song_id
                $sql = "SELECT s.song_id, s.title, a.artist_name, s.year, g.genre_name
                        FROM songs s
                        INNER JOIN artists a ON s.artist_id = a.artist_id
                        INNER JOIN genres g ON s.genre_id = g.genre_id
                        WHERE s.song_id = :song_id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':song_id', $song_id, PDO::PARAM_INT);
                $stmt->execute();
                
                //fetch next row
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Title</th>";
                    echo "<th>Artist</th>";
                    echo "<th>Year</th>";
                    echo "<th>Genre</th>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['artist_name']}</td>";
                    echo "<td>{$row['year']}</td>";
                    echo "<td>{$row['genre_name']}</td>";
                    echo "<td><a href='Favorites.php?remove={$song_id}'>Remove</a></td>";
                    echo "<td><a href='SingleSong.php?song_id={$song_id}'>View</a></td>";
                    echo "</tr>";

                    echo "</table>";
                } else {
                    echo "Song not found.";
                }
                //check remove param
                } elseif (isset($_GET['remove'])) {
                //remove song
                $song_id = $_GET['remove'];
                } 
            ?>
    </main>

    <footer>
        <p> COMP 3512 &copy; Sadman Shahryier <a href="https://github.com/TheShahOne/COMP3512_A1" style="color: yellow;"> github</a></p>
    </footer>
</body>
</html>
