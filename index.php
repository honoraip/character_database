<!DOCTYPE html>

<html>
<head>
    <title>The Tales Series Character Database</title>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
</head>

<body>
<?php
    $delimiter = '|';
    
    $nameErr = $weaponErr = "";
    $addSuccess = "";
  
    if (isset($_POST['add']) && !empty($_POST['name'])) {
        
        $file = fopen("data.txt", "a+");
    
        if (!$file) {
            die("Cannot open data.txt file");
        }
    
    /* Set default values in case user did not provide field */
        if (empty($_POST['gender'])) {
            $_POST['gender'] = "Unknown";
        }
    
        if (empty($_POST['weapon'])) {
            $_POST['weapon'] = "Unknown";
        }
    
        if (empty($_POST['game'])) {
            $_POST['game'] = "Unknown";
        }
        
        if (empty($_POST['image'])) {
            $_POST['image'] = "assets/default.jpg";
        }
        
        /* Returns true if there is already a character entry with the same name */
        function checkduplicate($input) {
            
            $characters = file("data.txt");
            $delimiter = '|';
            
            $result = false;
            
            foreach($characters as $character){
                $info = explode($delimiter, trim($character));
                
                    if(ucwords($input) == $info[0]) {
                        $result = true;
                        return $result;
                    }
            }
            
            return $result;
        }
        
    /* Regex checks if entry makes sense, if not, error message appears */
        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])) {
            $nameErr = "<p>Please only fill in letters and spaces for field name.</p>";
            $name = "";
        }
        elseif(checkduplicate($_POST["name"])) {
            $nameErr = "<p>There is already an entry for this character.</p>";
            $name = "";
        }
        else {
            $name = ucwords($_POST['name']);
        }
        
        $gender = $_POST['gender'];
        $game = $_POST['game'];
        
        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["weapon"])) {
            $weaponErr = "<p>Please only fill in letters and spaces for field weapon.</p>";
            $weapon = "";
        }
        else {
            $weapon = ucwords($_POST['weapon']);
        }
        
        $image = $_POST['image'];
        
    /* Message appears for successfully adding entry to database */
        if ($name != "" && $weaponErr == "") {
            fwrite($file, "\n$name$delimiter$gender$delimiter$game$delimiter$weapon$delimiter$image");
            $addSuccess = "<p>You have successfully added your character.</p>";
        }
    
        fclose($file);
    }
?>

<?php
    $resetmsg = "";
    
    if (isset($_POST['reset'])) {
        
        /* For resetting database, message appears for successfully adding entry to database */
        $file = fopen("data.txt", "w+");
        fclose($file);
        
        $original = file("original.txt");
        $file = fopen("data.txt", "a+");
        
        foreach ($original as $line) {
            fwrite($file, $line);
        }
        
        $resetmsg = "<p>You have successfully reset the database.</p>";
        
        fclose($file);
    }
?>

<div id = "banner">
        <h1>The Tales Series Character Database</h1>
        <h2>Add or search the database</h2>
</div>

<div id = "logo">
    <img src="assets/tales_logo.jpg" alt="Tales Logo"> <p></p>
    <span><a href="http://image.noelshack.com/fichiers/2012/49/1354701318-f9072d33879627d89924d18de18e3ee1.jpg">
    Picture source</a></span>
</div>

<div id = "form">
<div id = "formadd">
<div class= "inputstyle">
<form action="index.php" method="post">
    <h3>Add a Character</h3>
    
    Character Name: (required)<br>
    <input type="text" name="name" maxlength="50" required> <p></p>
    
    Character Gender:<br>
    <input type="radio" name="gender" value="Male">Male <br>
    <input type="radio" name="gender" value="Female">Female <p></p>
    
    Select the game the character belongs to:<br>
    <select name="game">
        <option value="">Select...</option>
        <option value="Tales of Phantasia">Tales of Phantasia</option>
        <option value="Tales of Destiny">Tales of Destiny</option>
        <option value="Tales of Eternia">Tales of Eternia</option>
        <option value="Tales of Destiny 2">Tales of Destiny 2</option>
        <option value="Tales of Symphonia">Tales of Symphonia</option>
        <option value="Tales of Rebirth">Tales of Rebirth</option>
        <option value="Tales of Legendia">Tales of Legendia</option>
        <option value="Tales of the Abyss">Tales of the Abyss</option>
        <option value="Tales of Destiny">Tales of Destiny</option>
        <option value="Tales of Innocence">Tales of Innocence</option>
        <option value="Tales of Vesperia">Tales of Vesperia</option>
        <option value="Tales of Hearts">Tales of Hearts</option>
        <option value="Tales of Graces">Tales of Graces</option>
        <option value="Tales of Xilia">Tales of Xilia</option>
        <option value="Tales of Xilia 2">Tales of Xilia 2</option>
        <option value="Tales of Zesteria">Tales of Zesteria</option>
        <option value="Tales of Berseria">Tales of Berseria</option>
    </select> <p></p>
    
    Character's weapon:<br>
    <input type="text" name="weapon" maxlength="50"> <p></p>
    
    Picture of the character (URL): <br>
    <input type="text" name="image"> <p></p>
    
    <input type="submit" name="add" value="Add">
</form>

<form action="index.php" method="post">
    <input type="submit" name="reset" value="Reset Database">
</form>
</div>
</div>

<div id="formsearch">
<form action="index.php" method="post">
    <h3>Find Characters</h3>
    
    <div class="inputstyle">
    Character Name: <br>
    <input type="text" name="namesearch" maxlength="50"> <p></p>
    
    Character Gender: <br>
    <input type="radio" name="gendersearch" value="Male">Male <br>
    <input type="radio" name="gendersearch" value="Female">Female <p></p>
    
    Select the game the character belongs to: <br>
    <select name="gamesearch">
        <option value="">Select...</option>
        <option value="Tales of Phantasia">Tales of Phantasia</option>
        <option value="Tales of Destiny">Tales of Destiny</option>
        <option value="Tales of Eternia">Tales of Eternia</option>
        <option value="Tales of Destiny 2">Tales of Destiny 2</option>
        <option value="Tales of Symphonia">Tales of Symphonia</option>
        <option value="Tales of Rebirth">Tales of Rebirth</option>
        <option value="Tales of Legendia">Tales of Legendia</option>
        <option value="Tales of the Abyss">Tales of the Abyss</option>
        <option value="Tales of Destiny">Tales of Destiny</option>
        <option value="Tales of Innocence">Tales of Innocence</option>
        <option value="Tales of Vesperia">Tales of Vesperia</option>
        <option value="Tales of Hearts">Tales of Hearts</option>
        <option value="Tales of Graces">Tales of Graces</option>
        <option value="Tales of Xilia">Tales of Xilia</option>
        <option value="Tales of Xilia 2">Tales of Xilia 2</option>
        <option value="Tales of Zesteria">Tales of Zesteria</option>
        <option value="Tales of Berseria">Tales of Berseria</option>
    </select> <p></p>
    
    Character's weapon: <br>
    <input type="text" name="weaponsearch" maxlength="50"> <p></p>
    
    <input type="submit" name="search" value="Search" > <br>
    <input type="submit" name="displayall" value="Display All">
    </div>
</form>
</div>
</div>

<div id=error>
    <?php echo $nameErr ?>
    <?php echo $weaponErr ?>
</div>

<div id=success>
    <?php echo $addSuccess ?>
    <?php echo $resetmsg ?>
</div>
    
<?php
    
    if (isset($_POST['search']) && (!empty($_POST['namesearch']) or
        !empty($_POST['gendersearch']) or !empty($_POST['gamesearch']) or
        !empty($_POST['weaponsearch']))) {
        
        if (empty($_POST['namesearch'])) {
            $namesearch = "";
        }
        else {
            $namesearch = ucwords($_POST['namesearch']); /* Capitalizes first letters for users */
        }
        
        if (empty($_POST['gendersearch'])) {
            $gendersearch = "";
        }
        else {
            $gendersearch = $_POST['gendersearch'];
        }
        
        if (empty($_POST['gamesearch'])) {
            $gamesearch = "";
        }
        else {
            $gamesearch = $_POST['gamesearch'];
        }
        
        if (empty($_POST['weaponsearch'])) {
            $weaponsearch = "";
        }
        else {
            $weaponsearch = ucwords($_POST['weaponsearch']); /* Capitalizes first letters for users */
        }
        
        $characters = file("data.txt");
        
        /* Functions for checking if entry matches database. */
        
        function namematch($name, $namesearch) {
            if ($namesearch != "") {
                return $name == $namesearch;
            }
            
            return true;
        }
        
        function gendermatch($gender, $gendersearch) {
            if ($gendersearch != "") {
                return $gender == $gendersearch;
            }
            
            return true;
        }
        
        function gamematch($game, $gamesearch) {
            if ($gamesearch != "") {
                return $game == $gamesearch;
            }
            
            return true;
        }
        
        function weaponmatch($weapon, $weaponsearch) {
            if ($weaponsearch != "") {
                return $weapon == $weaponsearch;
            }
            
            return true;
        }
        
        print  print "<div id=tabletitle><h4>List of the Tales Series Characters (Filtered Results)</h4></div>";
    
        foreach($characters as $character){
            $info = explode($delimiter, trim($character));
            
            if (namematch($info[0], $namesearch) && gendermatch($info[1], $gendersearch) &&
                gamematch($info[2], $gamesearch) && weaponmatch($info[3], $weaponsearch)) {
                
            print "<div class=content>";
            
            print "<img src=\"$info[4]\" alt=\"Picture of Character\">";
    
            print "<span>Name: $info[0] <p></p> Gender: $info[1] <p></p> Game: $info[2] <p></p>
            Weapon: $info[3] <p></p>
            <a href=\"$info[4]\">Picture source</a> <p></p>
            </span>";
            
            print "</div>";
            
            }
        }
    } 
?>

<?php
    
    if (isset($_POST['displayall'])){
        print "<div id=tabletitle><h4>List of the Tales Series Characters (Full Collection)</h4></div>";

        $characters = file("data.txt");
    
        foreach($characters as $character){
            $info = explode($delimiter, trim($character));
            
            print "<div class=content>";
            
            print "<img src=\"$info[4]\" alt=\"Picture of Character\">";
    
            print "<span>Name: $info[0] <p></p> Gender: $info[1] <p></p> Game: $info[2] <p></p>
            Weapon: $info[3] <p></p>
            <a href=\"$info[4]\">Picture source</a> <p></p>
            </span>";
            
            print "</div>";
        }
    }
?>

<div id = "footer">
        Default picture for database edited from <a href="http://bit.ly/1QBtbXj">here</a>.<p></p>
</div>

</body>
 
</html>



