<hr>
<table class="table_Films">
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Thanks to Nick for letting me use moviesapi API!</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
            <td>
                <div class="accordion">
                    <div class="accord-header"><h3>Add custom runtimes</h3></div>
                        <div class="accord-content">
                            <form method="POST">
                                Film Name: <input name="field1" type="text" />
                                Film Time: <input name="field2" type="text" />
                                <input type="submit" name="submit" value="SaveTimes">
                            </form>

                            <form method="POST">
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
                            ?>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="accordion">
                    <div class="accord-header"><h3>Convert Film title:</h3></div>
                        <div class="accord-content">
                            <form method="POST">
                                Displayed Film Name: <input name="field1" type="text" />
                                Correct Film Name:   <input name="field2" type="text" />
                                <input type="submit" name="submit" value="SaveTitle">
                            </form>

                            <form method="POST">
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
                            ?>
                      </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="accordion">
                    <div class="accord-header"><h3>Convert Film year:</h3></div>
                        <div class="accord-content">
                            <form method="POST">
                                Film Name: <input name="field1" type="text" />
                                Film year:   <input name="field2" type="text" />
                                <input type="submit" name="submit" value="SaveYear">
                            </form>

                            <form method="POST">
                                Film Name: <input name="field1" type="text" />
                                Film year:   <input name="field2" type="text" />
                                <input type="submit" name="submit" value="RemoveYear">
                            </form>

                            <?php

                                switch($_POST['submit']){
                                    case "SaveYear":
                                        saveYear();
                                    break;
                                    case "RemoveYear":
                                        removeYear();
                                    break;
                                    default:
                                    echo "Contents of file <br>";
                                    echo file_get_contents(getcwd().'/tmp/year.txt');
                                }
                            ?>
                      </div>
                    </div>
                </div>
            </td>
		</tr>
		<tr>
			<td>OMDB:</td>
			<td><a href="http://www.omdbapi.com/" target="_blank">http://www.omdbapi.com/</a></td>
		</tr>
		<tr>
			<td>Convert Time:</td>
			<td><a href="https://www.calculateme.com/Time/Hours/ToMinutes.htm" target="_blank">https://www.calculateme.com/Time/Hours/ToMinutes.htm</a></td>
		</tr>
		<tr>
			<td>API Link: <a href="http://moviesapi.org/" target="_blank">http://moviesapi.org/</a></td>
			<td>GitHub Link: <a href="https://github.com/nickcharlton/moviesapi" target="_blank">https://github.com/nickcharlton/moviesapi</a></td>
		</tr>
	</table>
</body>
</html>