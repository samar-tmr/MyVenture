<?php


namespace MyVenture\Data;


require_once '../../Library/Entities/Mblog.php';
class MBlog
{
	
	
	private $con;
	
	
	public function PublishBlog($UID,$Content)
	{
	
		
	
	}
	
	
	/*
	 * 
	 * 
	 * 
	 * */
	public function GetMySubscribedMBlogs($UID)
	{
		//echo "in data layer";
		
		$array_MBlog = new \SplObjectStorage();

		$result = $this->GetResult("select * from mblog");
				if($result)
				{
					while ($row = mysql_fetch_assoc($result)) {
						
						$obj= new \MyVenture\Entities\MBlog();
							
						$obj->authorName = $row['Category'];
							
						$obj->Content = $row['Content'];;
							
						$obj->ID = $row['id'];;
							
						$obj->UID = $row['UID'];;
							
						$array_MBlog ->attach($obj);
						
						
					}
					
					mysql_free_result($result);
				}
			
			mysql_close($this->con);
		
			return $array_MBlog;
		
	}
	
	
	private function GetResult($query)
	{
		
		$result;
		
		$this->con = mysql_connect(Global_Config_DatabaseServerName,Global_Config_DatabaseServerUserId,Global_Config_DatabaseServerPassword);
		
		if (!$this->con)
		{
				
			//echo "not connected";
			die('Could not connect: ' . mysql_error());
		}
		else{
			echo "connected ";
				
			mysql_select_db(Global_Config_DataBaseName,$this->con);
				
			$result = mysql_query($query,$this->con);
		}
		
		
	return 	$result;
		
	}
	
	
}