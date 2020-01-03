<?php
	/* 	Bind parameters.
		Types: %s = string, %i = integer, %d = double,  %b = blob
	*/
	class mySqlPrepare {
		function __construct($user=null, $password=null, $database=null, $host=null) {
			$this->user 	= $user;//localhost
			$this->password = $password;//root
			$this->database = $database;//cinema
		}
		protected function connect() {
			return new mysqli($this->host, $this->user, $this->password, $this->database);
		}
		//querying data: $db->query('SELECT QXC_COMPANY, QXC_BRAND, QXC_AGGCODE, QXC_TYPE from QX_CONTROL ', 1);
		public function query($query, $rtArray=0,$debug=0) {
			$db = $this->connect();
			$result = $db->query($query);

			//check if prepare or DB conenction ok
			if (false===$db) {
				$this->printDiagnostics("prepare()",$db,$stmt,$data,$format,$query);
			}

			if ($debug){
				$this->printSQLDebug("Query",$db,$stmt,$data,$format,$query);
			}

			//check if return array specified
			if($rtArray == 1){
				//Create results object
				while ($row = $result->fetch_object()) {
					$results[] = $row;
				}
				$db->close();
				return $this->object_to_array($results);
			}else{
				$db->close();
				return mysqli_fetch_assoc($result);
			}
		}
		//selecting data: $db->select('SELECT * FROM QX_ADDONS WHERE'.$sql, array($data), array($format), 1);
		public function select($query, $data, $format, $rtArray=0,$debug=0) {
			// Connect to the database
			$db = $this->connect();

			//Prepare our query for binding
			$stmt = $db->prepare($query);

			//check if prepare or DB conenction ok
			if (false===$stmt) {
				die($this->printDiagnostics("prepare()",$db,$stmt,$data,$format,$query));
			}

			//Normalize format
			$format = implode('', str_replace('%', '', $format));

			// Prepend $format onto $values
			array_unshift($data, $format);

			//Dynamically bind values
			$rc = call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($data));

			//check if bind param is ok
			if (false == $rc) {
				die($this->printDiagnostics("bind_param()",$db,$stmt,$data,$format,$query));
			}

			//Execute the query
			$stmt->execute();

			//check if exe is ok
			if (false == $rc) {
				die($this->printDiagnostics("execute()",$db,$stmt,$data,$format,$query));
		    }

			if ($debug){
				$this->printSQLDebug("Select",$db,$stmt,$data,$format,null,null,$query);
			}

			//Fetch results
			$result = $stmt->get_result();

			//check if return array specified
			if($rtArray == 1){
				//Create results object
				while ($row = $result->fetch_object()) {
					$results[] = $row;
				}
				$stmt->close();
				return $this->object_to_array($results);
			}else{
				$stmt->close();
				return mysqli_fetch_assoc($result);
			}
		}
		//inserting new entries: $addonResult = $dboveride->insert('QX_ADDONS', array($data), array($format));
		public function insert($table, $data, $format,$debug=0) {
			// Check for $table or $data not set
			if ( empty( $table ) || empty( $data ) ) {
				return false;
			}

			// Connect to the database
			$db = $this->connect();

			// Cast $data and $format to arrays
			$data = (array) $data;
			$format = (array) $format;

			// Build format string
			$format = implode('', $format);
			$format = str_replace('%', '', $format);

			list( $fields, $placeholders, $values ) = $this->prep_query($data);

			// Prepend $format onto $values
			array_unshift($values, $format);

			// Prepary our query for binding
			$stmt = $db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");

			//check if prepare or DB conenction ok
			if (false===$stmt) {
				die($this->printDiagnostics("prepare()",$db,$stmt,$data,$format,"INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})"));
			}

			// Dynamically bind values
			$rc = call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($values));

			//check if bind param is ok
			if (false == $rc) {
				die($this->printDiagnostics("bind_param()",$db,$stmt,$data,$format,"INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})"));
			}

			// Execute the query
			$stmt->execute();

			//check if exe is ok
			if (false == $rc) {
				die($this->printDiagnostics("execute()",$db,$stmt,$data,$format,"INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})"));
		    }

			if ($debug){
				$this->printSQLDebug("Insert",$db,$stmt,$data,$format,null,null,"INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");
			}

			// Check for successful insertion
			if ( $stmt->affected_rows ) {
				$id = $stmt->insert_id;
				$stmt->close();
				return $id;
			}else{
				$stmt->close();
				return false;
			}
		}
		//updating values: $db->update('QX_ADDONS', array($data), array($format),$where,array($where_format));
		public function update($table, $data, $format, $where, $where_format,$debug=0) {
			// Check for $table or $data not set
			if ( empty( $table ) || empty( $data ) ) {
				return false;
			}

			// Connect to the database
			$db = $this->connect();

			// Cast $data and $format to arrays
			$data = (array) $data;
			$format = (array) $format;

			// Build format array
			$format = implode('', $format);
			$format = str_replace('%', '', $format);
			$where_format = implode('', $where_format);
			$where_format = str_replace('%', '', $where_format);
			$format .= $where_format;

			list( $fields, $placeholders, $values ) = $this->prep_query($data, 'update');

			//Format where clause
			$where_clause = '';
			$where_values = '';
			$count = 0;

			foreach ( $where as $field => $value ) {
				if ( $count > 0 ) {
					$where_clause .= ' AND ';
				}

				$where_clause .= $field . '=?';
				$where_values[] = $value;

				$count++;
			}

			// Prepend $format onto $values
			array_unshift($values, $format);
			$values = array_merge($values, $where_values);

			// Prepary our query for binding
			$stmt = $db->prepare("UPDATE {$table} SET {$placeholders} WHERE {$where_clause}");

			//check if prepare or DB conenction ok
			if (false===$stmt) {
				die($this->printDiagnostics("prepare()",$db,$stmt,$data,$format,"UPDATE {$table} SET {$placeholders} WHERE {$where_clause}"));
			}

			// Dynamically bind values
			$rc = call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($values));

			//check if bind param is ok
			if (false == $rc) {
				die($this->printDiagnostics("bind_param()",$db,$stmt,$data,$format,"UPDATE {$table} SET {$placeholders} WHERE {$where_clause}"));
			}

			// Execute the query
			$stmt->execute();

			//check if exe is ok
			if (false == $rc) {
				die($this->printDiagnostics("execute()",$db,$stmt,$data,$format,"UPDATE {$table} SET {$placeholders} WHERE {$where_clause}"));
		    }

			if($debug){
				$this->printSQLDebug("Update",$db,$stmt,$data,$format,$where, $where_format,"UPDATE {$table} SET {$placeholders} WHERE {$where_clause}");
			}

			// Check for successful insertion
			if ( $stmt->affected_rows ) {
				$id = $stmt->id;
				$stmt->close();
				return $id;
			}else{
				$stmt->close();
				return false;
			}
		}
		//deleting entries: $db->delete('QX_ADDONS', 'AO_KEY', $QX_ADDONS['AO_KEY']);
		public function delete($table, $field, $id, $format="s", $operator="=",$debug=0) {
			// Connect to the database
			$db = $this->connect();

			// Prepary our query for binding
			$stmt = $db->prepare("DELETE FROM {$table} WHERE {$field} {$operator} ?");

			//check if prepare or DB conenction ok
			if (false===$stmt) {
				die($this->printDiagnostics("prepare()",$db,$stmt,$id,'',"DELETE FROM {$table} WHERE {$field} {$operator} ?"));
			}

			// Dynamically bind values
			$rc = $stmt->bind_param($format, $id);

			//check if bind param is ok
			if (false == $rc) {
				die($this->printDiagnostics("bind_param()",$db,$stmt,$id,'',"DELETE FROM {$table} WHERE {$field} {$operator} ?"));
			}

			// Execute the query
			$stmt->execute();

			//check if exe is ok
			if (false == $rc) {
				die($this->printDiagnostics("execute()",$db,$stmt,$id,'',"DELETE FROM {$table} WHERE {$field} {$operator} ?"));
		    }

			if($debug){
				$this->printSQLDebug("Delete",$db,$stmt,$data,$format,null,null,"DELETE FROM {$table} WHERE {$field} {$operator} ?");
			}

			// Check for successful insertion
			if ( $stmt->affected_rows ) {
				$stmt->close();
				return true;
			}else{
				$stmt->close();
				return false;
			}
		}
		//deleting multi data: $db->deleteMulti('DELETE FROM QX_UNSUBSCRIBE WHERE UNS_EMAIL = ? AND UNS_BRAND = ? ', array($data), array($format));
		public function deleteMulti($query, $data, $format,$debug=0) {
			// Connect to the database
			$db = $this->connect();

			//Prepare our query for binding
			$stmt = $db->prepare($query);

			//check if prepare or DB conenction ok
			if (false===$stmt) {
				die($this->printDiagnostics("prepare()",$db,$stmt,$data,$format,$query));
			}

			//Normalize format
			$format = implode('', str_replace('%', '', $format));

			// Prepend $format onto $values
			array_unshift($data, $format);

			//Dynamically bind values
			$rc = call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($data));

			//check if bind param is ok
			if (false == $rc) {
				die($this->printDiagnostics("bind_param()",$db,$stmt,$data,$format,$query));
			}

			// Execute the query
			$stmt->execute();

			//check if exe is ok
			if (false == $rc) {
				die($this->printDiagnostics("execute()",$db,$stmt,$data,$format,$query));
		    }

			if($debug){
				$this->printSQLDebug("DeleteMulti",$db,$stmt,$data,$format,null,null,$query);
			}

			// Check for successful insertion
			if ( $stmt->affected_rows ) {
				$stmt->close();
				return true;
			}else{
				$stmt->close();
				return false;
			}
		}

		//Function to set defaults into the $data in inserts and updates as they cannot be blank
		public function defaultDataVar($var, $default=' ') {
			if (empty($var)){
		        $var = $default;
		    }
			return $var;
		}
		/*************************************************************************************************************************
		* The Private Function Section
		*************************************************************************************************************************/
		//prepping the query for the preapred statements
		private function prep_query($data, $type='insert') {
			// Instantiate $fields and $placeholders for looping
			$fields = '';
			$placeholders = '';
			$values = array();

			// Loop through $data and build $fields, $placeholders, and $values
			foreach ( $data as $field => $value ) {
				$fields .= "{$field},";
				$values[] = $value;

				if ( $type == 'update') {
					$placeholders .= $field . '=?,';
				} else {
					$placeholders .= '?,';
				}

			}
			// Normalize $fields and $placeholders for inserting
			$fields = substr($fields, 0, -1);
			$placeholders = substr($placeholders, 0, -1);

			return array( $fields, $placeholders, $values );
		}
		//ref values loop around the $data to create the call_user_func_array and bind_param
		private function ref_values($array) {
			$refs = array();
			foreach ($array as $key => $value) {
				$refs[$key] = &$array[$key];
			}
			return $refs;
		}
		//setting up diagnostics for errors
		private function printDiagnostics($name,$db,$stmt,$data,$format,$query) {
			print("<pre>");
			print($name.' failed: ('.$db->errno.' '.$stmt->error.')');
			print("<br />");
			print_r(htmlspecialchars($db->error));
			print("<br />");
			print_r(htmlspecialchars($stmt->error));
			print("<br />");
			print("Data:");
			print_r($data);
			print("<br />");
			print("Format:");
			print_r($format);
			print("<br />");
			print("SQL Info:");
			print_r($stmt);
			print("<br />");
			print("Query:");
			print_r($query);
			print("</pre>");
		}

		//setting up diagnositcs for SQL actions
		private function printSQLDebug($type,$db,$stmt,$data,$format,$where,$where_format,$query){
			print "<pre>";
			print "<h3>SQL Debug - $type</h3>";
			print_r("<h3>SQL</h3>".$query);
			print_r("<h3>Data</h3>");
			print_r($data);
			print_r("<h3>Where Clause Data</h3>");
			print_r($where);
			print("<h3>SQL Action Info</h3>");
			print_r("Rows Affected   :- ".$stmt->affected_rows);
			print "<br>";
			print_r("Insert ID       :- ".$stmt->insert_id);
			print "<br>";
			print_r("Num Rows        :- ".$stmt->num_rows);
			print "<br>";
			print_r("Paramater Count :- ".$stmt->param_count);
			print "<br>";
			print "</pre>";
		}

		//this converts and object to an array
		private function object_to_array($obj) {
			if(is_object($obj)) $obj = (array) $obj;
			    if(is_array($obj)) {
			        $new = array();
			        foreach($obj as $key => $val) {
			            $new[$key] = $this->object_to_array($val);
			        }
			    }else{
					$new = $obj;
				}
		    return $new;
		}
	}//end of class
	/*****************************************************************************************************
		These are Example Statements to use within the code:

		//Conenctions:
		Create new Db Conenction:
		//get db conenctuions
		$db 		= new mySqlPrepare(getDBUsername(), getDBUserPassword(), getDBName(), getDBHost());
		$dboveride  = new mySqlPrepare(getDBUsername(), getDBUserPassword(), getOverrideDb(), getDBHost());

		//sanitise data
		protect_against_sql_attack($db);

		if (get_class($db) != "mySqlPrepare") {
			$db 		= new mySqlPrepare(getDBUsername(), getDBUserPassword(), getDBName(), getDBHost());
			$dboveride 	= new mySqlPrepare(getDBUsername(), getDBUserPassword(), getOverrideDb(), getDBHost());
		}

		/---query---/:
		My Fetch Assoc:
		$prodResults = $dboveride->query('SELECT DISTINCT(TRIM(DP_TYPE)) DP_TYPE FROM QX_PANDICTIONARY GROUP BY TRIM(DP_TYPE) ');

		Return array:
		$prodResults = $dboveride->query('SELECT DISTINCT(TRIM(DP_TYPE)) DP_TYPE FROM QX_PANDICTIONARY GROUP BY TRIM(DP_TYPE) ', 1);

		/---Selects---/:
		My Fetch assoc:
		$arFullData = $db->select('SELECT * from QX_QUOTE where Q_KEY = ?', array($QX_QUOTE['Q_KEY']), array('%i'));

		Return Array:
		$arFullData = $db->select('SELECT * from QX_QUOTE where Q_KEY = ?', array($QX_QUOTE['Q_KEY']), array('%i'),1);

		Multi Select:
	    $data = array(
	                    'FE_JOURNEY'                    => $type,
	                    'QJP_TEMPLATENAME'                 => $page,
	                    'FE_QJPKEY'                        => $FEpage
	    );
	    $arQd = $db->select('SELECT * from QX_FRONTEND, QX_JOURNEY_PAGES, QX_JOURNEY where FE_JOURNEY = ? and QJ_CODE = FE_JOURNEY and QJP_TEMPLATENAME = ? and FE_QJPKEY = ? ORDER by FE_ERRORORDER, FE_OCCURRENCE, FE_OCCURRENCE_2, FE_TABLE, FE_FIELD ', $data, array('%s%s%s'),1);

		/---Inserts---/:
		$data = array(
			'AO_COMPANY'        => $QX_ADDONS['AO_COMPANY'],
			'AO_TYPE'           => $QX_ADDONS['AO_TYPE'],
			'AO_PROVIDER'       => $QX_ADDONS['AO_PROVIDER'],
			'AO_ADDON'          => $QX_ADDONS['AO_ADDON'],
			'AO_PRICE'          => $QX_ADDONS['AO_PRICE'],
			'AO_DESCRIPTION'	=> $QX_ADDONS['AO_DESCRIPTION'],
			'AO_ACTIVE'         => $QX_ADDONS['AO_ACTIVE']
		);
		$format = "%s%s%s%s%s%s%s";
		$addonResult = $dboveride->insert('QX_ADDONS', $data, array($format));

		Alt Insert (Best):
		$data = array(
			'ACC_DRKEY'         => $arSafe['DriverId'],
			'ACC_COST'          => $arSafe['incidentCost'],
			'ACC_CATEGORY'      => $arSafe['incidentType'],
			'ACC_NCBLOST'       => $arSafe['NCBLost'],
			'ACC_PI'         	=> $arSafe['personalInjuries'],
			'ACC_FAULT'			=> $arSafe['atFault'],
			'ACC_CURRENTPOLICY' => $arSafe['currentPolicy'],
			'ACC_DATE'         	=> $arSafe['incidentDate'],
			'ACC_QKEY'         	=> $arSafe['Q']
		);
		$ClaimId = $db->insert('QX_ACCIDENTS', $data, array(str_repeat('%s',count($data))));

		/---Updates---/:
		$data = array(
		    'AO_COMPANY'        => $QX_ADDONS['AO_COMPANY'],
		    'AO_TYPE'           => $QX_ADDONS['AO_TYPE'],
		    'AO_PROVIDER'       => $QX_ADDONS['AO_PROVIDER'],
		    'AO_ADDON'          => $QX_ADDONS['AO_ADDON'],
		    'AO_PRICE'          => $QX_ADDONS['AO_PRICE'],
		    'AO_DESCRIPTION'	=> $QX_ADDONS['AO_DESCRIPTION'],
		    'AO_ACTIVE'         => $QX_ADDONS['AO_ACTIVE']
		);
		$format = "%s%s%s%s%s%s%s";
		$where = array('AO_KEY' => $QX_ADDONS['AO_KEY']);
		$where_format = "%i";
		$dboveride->update('QX_ADDONS', $data, array($format),$where,array($where_format));

		Short Update:
		$db->update('QX_QUOTE', array('Q_QUOTETIME' => date('Y-m-d H:i:s')), array('%s'),array('Q_KEY' => $QX_QUOTE['Q_KEY']),array('%i'));

		Update Alt (Best):
		$data = array(
			'AO_COMPANY'        => $QX_ADDONS['AO_COMPANY'],
			'AO_TYPE'           => $QX_ADDONS['AO_TYPE'],
			'AO_PROVIDER'       => $QX_ADDONS['AO_PROVIDER'],
			'AO_ADDON'          => $QX_ADDONS['AO_ADDON'],
			'AO_PRICE'          => $QX_ADDONS['AO_PRICE'],
			'AO_DESCRIPTION'	=> $QX_ADDONS['AO_DESCRIPTION'],
			'AO_ACTIVE'         => $QX_ADDONS['AO_ACTIVE']
		);
		$ClaimId = $db->update('QX_ADDONS', $data, array(str_repeat('%s',count($data))),array('AO_KEY' => $QX_ADDONS['AO_KEY']),array('%s'));

		/---Deletes---/:
		$dboveride->delete('QX_ADDONS', 'AO_KEY', $QX_ADDONS['AO_KEY']);

		with specific operator:
		$dboveride->delete('QX_ADDONS', 'AO_KEY', $QX_ADDONS['AO_KEY']),'<';

		delete multi:
		$del = $db->deleteMulti('DELETE FROM QX_UNSUBSCRIBE WHERE UNS_EMAIL = ? AND UNS_BRAND = ? ', array($arCtl['fullData']['CD_EMAILADDRESS']['Data'], $QX_BRAND), array('%s%s'));


		*****************************
		***** Odd Things to use *****
		*****************************
		//building up SQL: and data for a select:

		if($arCtl['AO_COMPANY'] != ""){
				$sql = $sql."AND AO_COMPANY = ? ";
				$data = $data.$arCtl['AO_COMPANY'] . ",";
				$format = $format."%s";
		}
		if($arCtl['AO_TYPE'] != ""){
						$sql = $sql."AND AO_TYPE = ? ";
						$data = $data.$arCtl['AO_TYPE'] . ",";
						$format = $format."%s";
		}

		//remove ending chars to format the data correctly
		$data = rtrim($data, ',');
		$sql = ltrim($sql, 'AND');

		//make an array of data to send through
		$data = explode(",",$data);

		$arAddons = $dboveride->select('SELECT * FROM QX_ADDONS WHERE'.$sql, $data, array($format), 1);


		//building up date and format in a loop for inserts etc:
		foreach($record as $field => $value) {
			$FieldCount++;
			$value = isDateField($db, $field, $value);
			if ($noOfFields > $FieldCount) {
				$data[$field] = $value;
				$format = $format."%s";
			} else {
				$data[$field] = $value;
				$format = $format."%s";
			}
		}
		// now add in values
		$tablekey = $db->insert($Table, $data, array($format));

	*****************************************************************************************************/
?>
