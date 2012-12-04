<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Database_utility
{
	public function __construct()
	{
		
	}

	public function export()
	{
		//ENTER THE RELEVANT INFO BELOW
		$mysqlDatabaseName ='xcode';
		$mysqlUserName ='root';
		$mysqlPassword ='root';
		$mysqlHostName ='localhost';
		$mysqlExportPath ='/home/bryan/chooseFilenameForBackup.sql';

		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
		exec($command,$output=array(),$worked);
		switch($worked){
    		case 0:
        		echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
        	break;
    		case 1:
        		echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
        	break;
    		case 2:
        		echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
        	break;
		}
	}

	public function import()
	{
		//ENTER THE RELEVANT INFO BELOW
		$mysqlDatabaseName ='xcode';
		$mysqlUserName ='root';
		$mysqlPassword ='root';
		$mysqlHostName ='localhost';
		$mysqlImportFilename ='/home/bryan/yourMysqlBackupFile.sql';

		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		exec($command,$output=array(),$worked);
		switch($worked){
    		case 0:
        		echo 'Import file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
        	break;
    		case 1:
        		echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
        	break;
		}
	}

	public function outfile()
	{
		$tableName  = 'mypet';
		$backupFile = 'backup/mypet.sql';
		$query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";
		$result = mysql_query($query);
	}

	public function infile()
	{
		$tableName  = 'mypet';
		$backupFile = 'mypet.sql';
		$query      = "LOAD DATA INFILE 'backupFile' INTO TABLE $tableName";
		$result = mysql_query($query);
	}
}

/* End of file database_utility.php */
/* Location: ./application/libraries/database_utility.php */
