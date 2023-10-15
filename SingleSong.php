<!DOCTYPE html>
<html>
<head>
    <title>COMP 3512 Assign1</title>
    <link rel="stylesheet" type="text/css" href="css/SingleSong.css">
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
        <?php
            require_once('includes/dbh.inc.php'); 

            //check song_id query parameter
            if (isset($_GET['song_id'])) {
                $song_id = $_GET['song_id'];

                //sql query 
                $sql = "SELECT s.song_id, s.title, s.bpm, s.energy, s.danceability, s.liveness, s.valence, s.acousticness, s.speechiness, s.popularity, s.year, s.duration,
                    a.artist_name, g.genre_name, t.type_name
                FROM songs s
                INNER JOIN artists a ON s.artist_id = a.artist_id
                INNER JOIN genres g ON s.genre_id = g.genre_id
                INNER JOIN types t ON a.artist_type_id = t.type_id
                WHERE s.song_id = :song_id";

                //prepare and execute query
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':song_id', $song_id, PDO::PARAM_INT);
                $stmt->execute();

                //check if song_id is found
                $song = $stmt->fetch();

                //display title, artist name, genre name, year, duration
                echo "<p>Title: {$song['title']}</p>";
                echo "<p>Artist: {$song['artist_name']}</p>";
                echo "<p>Type: {$song['type_name']}</p>";
                echo "<p>Genre: {$song['genre_name']}</p>";
                echo "<p>Release date: {$song['year']}</p>";

                //format the duration display to be in minutes and seconds
                $durationSeconds = $song['duration'];
                $minutes = floor($durationSeconds / 60);
                $seconds = $durationSeconds % 60;
                echo "<p>Duration: {$minutes} minutes {$seconds} seconds</p>";

                //display song stats
                echo "<p>BPM: {$song['bpm']}</p>";
                echo "<p>Energy: {$song['energy']}</p>";
                echo "<p>Danceability: {$song['danceability']}</p>";
                echo "<p>Liveness: {$song['liveness']}</p>";
                echo "<p>Valence: {$song['valence']}</p>";
                echo "<p>Acousticness: {$song['acousticness']}</p>";
                echo "<p>Speechiness: {$song['speechiness']}</p>";
                echo "<p>Popularity: {$song['popularity']}</p>";
            } 
        ?>
        
    </main>

    <footer>
        <p> COMP 3512 &copy; Sadman Shahryier <a href="https://github.com/TheShahOne/COMP3512_A1" style="color: yellow;"> github</a></p>
    </footer>

</body>
</html>
