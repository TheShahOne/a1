<!DOCTYPE html>
<html>
<head>
    <title>COMP 3512 Assign1</title>
    <link rel="stylesheet" type="text/css" href="css/Home.css">
</head>
<body>
    <header>
        <h1>COMP 3512 Assign1</h1>
        <h2>
            Home Page <br>
            Sadman Shahryier <br>
            Github Link
        </h2>
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
        <h3>Top Genres</h3>
        <table>
            <tr>
                <th>Genre</th>
                <th># of Songs</th>
            </tr>
            <?php
                require_once('includes/dbh.inc.php');

                //top genre query
                $genreSql = "SELECT g.genre_name, COUNT(s.song_id) as num_songs
                        FROM genres g
                        LEFT JOIN songs s ON g.genre_id = s.genre_id
                        GROUP BY g.genre_id
                        ORDER BY num_songs DESC
                        LIMIT 10";

                $genreStmt = $pdo->query($genreSql);

                //fetch and display
                while ($row = $genreStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['genre_name']}</td>";
                    echo "<td>{$row['num_songs']}</td>";
                    echo "</tr>";
                }
            ?>
        </table>

        <h3>Top Artists</h3>
        <table>
            <tr>
                <th>Artist</th>
                <th># of Songs</th>
            </tr>
            <?php
                //top artists query
                $artistSql = "SELECT a.artist_name, COUNT(s.song_id) as num_songs
                        FROM artists a
                        LEFT JOIN songs s ON a.artist_id = s.artist_id
                        GROUP BY a.artist_id
                        ORDER BY num_songs DESC
                        LIMIT 10";

                $artistStmt = $pdo->query($artistSql);

                while ($row = $artistStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['artist_name']}</td>";
                    echo "<td>{$row['num_songs']}</td>";
                    echo "</tr>";
                }
            ?>
        </table>

        <h3>Most Popular Songs</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Popularity</th>
            </tr>
            <?php
                //popularity sort query
                $songsSql = "SELECT s.title, a.artist_name, MAX(s.popularity) as popularity
                        FROM songs s
                        INNER JOIN artists a ON s.artist_id = a.artist_id
                        GROUP BY s.title, a.artist_name
                        ORDER BY popularity DESC
                        LIMIT 10";

                $songsStmt = $pdo->query($songsSql);

                while ($row = $songsStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['artist_name']}</td>";
                    echo "<td>{$row['popularity']}</td>";
                    echo "</tr>";
                }
            ?>
        </table>

        <h3>One Hit Wonders</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Popularity</th>
            </tr>
            <?php
                //1 hit wonder query
                $oneHitWondersSql = "SELECT s.title, a.artist_name, MAX(s.popularity) as popularity
                        FROM songs s
                        INNER JOIN artists a ON s.artist_id = a.artist_id
                        WHERE a.artist_id IN (
                            SELECT s2.artist_id
                            FROM songs s2
                            GROUP BY s2.artist_id
                            HAVING COUNT(s2.song_id) = 1
                        )
                        GROUP BY s.title, a.artist_name
                        ORDER BY popularity DESC
                        LIMIT 10";

                $oneHitWondersStmt = $pdo->query($oneHitWondersSql);

                while ($row = $oneHitWondersStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['artist_name']}</td>";
                    echo "<td>{$row['popularity']}</td>";
                    echo "</tr>";
                }
            ?>
    </table>

    <h3>Longest Acoustic Songs</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Duration</th>
        </tr>
        <?php
            //long acousitc query
            $acousticSongsSql = "SELECT s.title, a.artist_name, s.duration
                    FROM songs s
                    INNER JOIN artists a ON s.artist_id = a.artist_id
                    WHERE s.acousticness > 40
                    ORDER BY s.duration DESC
                    LIMIT 10";

            $acousticSongsStmt = $pdo->query($acousticSongsSql);

            while ($row = $acousticSongsStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['artist_name']}</td>";
                echo "<td>{$row['duration']}</td>";
                echo "</tr>";
            }
        ?>
    </table>

    <h3>Best Club Vibes</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Rating</th>
        </tr>
        <?php
        //club query
        $clubSongsSql = "SELECT s.title, a.artist_name, (s.danceability * 1.6 + s.energy * 1.4) as suitability_score
                FROM songs s
                INNER JOIN artists a ON s.artist_id = a.artist_id
                WHERE s.danceability > 80
                ORDER BY suitability_score DESC
                LIMIT 10";

        $clubSongsStmt = $pdo->query($clubSongsSql);

        while ($row = $clubSongsStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['artist_name']}</td>";
            echo "<td>{$row['suitability_score']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h3>Running Songs</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Rating</th>
        </tr>
        <?php
        //runner query
        $runningSongsSql = "SELECT s.title, a.artist_name, (s.energy * 1.3 + s.valence * 1.6) as suitability_score
                FROM songs s
                INNER JOIN artists a ON s.artist_id = a.artist_id
                WHERE s.bpm BETWEEN 120 AND 125
                ORDER BY suitability_score DESC
                LIMIT 10";

        $runningSongsStmt = $pdo->query($runningSongsSql);

        while ($row = $runningSongsStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['artist_name']}</td>";
            echo "<td>{$row['suitability_score']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h3>Studying Songs</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Rating</th>
        </tr>
        <?php
        //studying query
        $studyingSongsSql = "SELECT s.title, a.artist_name, (s.acousticness * 0.8) + (100 - s.speechiness) + (100 - s.valence) as suitability_score
                FROM songs s
                INNER JOIN artists a ON s.artist_id = a.artist_id
                WHERE s.bpm BETWEEN 100 AND 115 AND s.speechiness BETWEEN 1 AND 20
                ORDER BY suitability_score DESC
                LIMIT 10";

        $studyingSongsStmt = $pdo->query($studyingSongsSql);

        while ($row = $studyingSongsStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['artist_name']}</td>";
            echo "<td>{$row['suitability_score']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </main>

    <footer>
        <p> COMP 3512 &copy; Sadman Shahryier <a href="https://github.com/TheShahOne/COMP3512_A1" style="color: yellow;"> github</a></p>
    </footer>

</body>
</html>
