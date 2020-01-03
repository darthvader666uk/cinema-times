<form action="convertTitle.php" method="POST">
    Displayed Film Name: <input name="field1" type="text" />
    Correct Film Name:   <input name="field2" type="text" />
    <input type="submit" name="submit" value="SaveTitle">
</form>

<form action="convertTitle.php" method="POST">
    Displayed Film Name: <input name="field1" type="text" />
    Correct Film Name:   <input name="field2" type="text" />
    <input type="submit" name="submit" value="RemoveTitle">
</form>

<?php

    switch($_POST['submit']){
        case "SaveTitle":
            saveTitle();
        break;
        case "RemoveTitle":
            removeTitle();
        break;
        default:
        echo "Contents of file <br>";
        echo file_get_contents(getcwd().'/tmp/title.txt');
    }

// Save Title
function saveTitle(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/title.txt', $data, FILE_APPEND | LOCK_EX);
        if($ret === false) {
            die('There was an error writing this file');
        }
        else {
            echo "$ret bytes saved to file <br>";
            echo file_get_contents(getcwd().'/tmp/title.txt');
        }
    }
    else {
       die('no post title to process');
    }
}

// Save Time
function removeTitle(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/title.txt', str_replace($data, "", file_get_contents(getcwd().'/tmp/title.txt')));
        if($ret === false) {
            die('There was an error removing this line');
        }
        else {
            echo "$ret bytes removed from file <br>";
            echo file_get_contents(getcwd().'/tmp/title.txt');
        }
    }
    else {
       die('no post time to process');
    }
}