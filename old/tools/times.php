<form action="times.php" method="POST">
    Film Name: <input name="field1" type="text" />
    Film Time: <input name="field2" type="text" />
    <input type="submit" name="submit" value="SaveTimes">
</form>

<form action="times.php" method="POST">
    Film Name: <input name="field1" type="text" />
    Film Time: <input name="field2" type="text" />
    <input type="submit" name="submit" value="RemoveTimes">
</form>

<?php

    switch($_POST['submit']){
        case "SaveTimes":
            saveTimes();
        break;
        case "RemoveTimes":
            removeTimes();
        break;
        default:
        echo "Contents of file <br>";
        echo file_get_contents(getcwd().'/tmp/times.txt');
    }

// Save Times
function saveTimes(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/times.txt', $data, FILE_APPEND | LOCK_EX);
        if($ret === false) {
            die('There was an error writing this file');
        }
        else {
            echo "$ret bytes saved to file <br>";
            echo file_get_contents(getcwd().'/tmp/times.txt');
        }
    }
    else {
       die('no post times to process');
    }
}

// Save Time
function removeTimes(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/times.txt', str_replace($data, "", file_get_contents(getcwd().'/tmp/times.txt')));
        if($ret === false) {
            die('There was an error removing this line');
        }
        else {
            echo "$ret bytes removed from file <br>";
            echo file_get_contents(getcwd().'/tmp/times.txt');
        }
    }
    else {
       die('no post time to process');
    }
}