	
	<?php 
	
	
	namespace MyVenture\View;
	
	GlobalContext::GetCurrentGlobalContext()->App_LoadFile("AppView", "/Library/Contracts/");

	class MBlogView extends AppView{

		public $viewData; // contains  SplObjectStorage of  MyVenture\Entities\MBlog items 

		function __construct($viewData){
			
			$this->viewData = $viewData;
			
		}
		
		public  function Execute()
		{
			
	?>
	
	
	
	<style type="text/css">
	
		.MBlogBox
		{
			
			height: 120px;
			background-color:#EDEBD5;
			
		}
		
		
		.MBlogTemplate{
				border-bottom: 1px solid #ebebeb;;
		
		}
		
		.MBlogTemplate .BlogContent{
		
			font-family:Helvetica;
			display:block;
		}
		
		.MBlogTemplate .AuthorName
		{
		font-weight:bold;
		font-family:Helvetica;
		
		}
		
		#MblogContainer{
		
		overflow: auto;
		height:418px;
			
		
		
		}
		
		.MBlogTemplate .AdContent
		{
			font-weight:lighter;
			color: blue;
			display:block;
			margin:0 0 1.5em;
		}
		
		.MBlogTemplate #BlogContentBox
		{
		
			display:inline-block;
			width:442px;
		}
		
		.MBlogTemplate #imgContent ,.MBlogTemplate img
		{
			height:48px;
			display:inline-block;
			width:48px;
			vertical-align:top;
			margin: .25em;
		}
	.righttPane{
	
		border-left-color: #999;
			border-left-style: solid;
			border-left-width: 1px;
	}
	
	</style>
<div>
<div id="leftContent" class="leftPane">
   	   <div style="margin-left: 70px;margin-top: 70px;">
   	   		<table>
   	   		<tr><td><a href="#" style="TEXT-DECORATION: none" id="userName">Paras</a></td></tr>
   	   		<tr><td> <div style="height:10px;"></div>  </td></tr>
   	   		<tr><td><img alt="" src="" id="userImg"  style="height:150px;width:150px"/></td></tr>
   	   		</table>
		   	
	   </div>  
 </div>


<div  class="righttPane">	
	<div id="MBlogBox" class="MBlogBox" style="" >
		<div><span style="font-family: Helvetica; font-weight: bold;color: #999;margin-left: 5px;" >Whats in your Mind : </span></div>
    	<div> 
    		<div class="fltlft"><textarea rows="4" style="width:440px;margin-left: .5em;" id="txtArea_MBlog" maxlength="120" ></textarea> </div>
    		<div class="fltrt" style="margin-left: 1px;"><input type="button" value="Update" style="height: 70px;color: #999;" onclick="javascript:BlogDisplay_Obj.PublishMBlog();" /></div>
    		<div class="clearfloat"></div>
       	</div>
   </div>
        
        <div  style="height:10px;"></div>
        
<div id="MblogContainer">
    	<?php 
    	$this->viewData-> rewind();
      	while($this->viewData->valid())
        {

        $obj_t = $this->viewData ->current();
         ?>
          
	       <div id="MBlogs" class="MBlogTemplate">
		       	<div id="imgContent">
		       		<img  alt="" src=" <?php $obj_t->$authorImg ?> "  />
		       	</div>
		       		
		       	<div id="BlogContentBox">
			       	
			       		<span id="AuthorName_template" class="AuthorName"> 
			       	<?php 
				  		  echo   	$obj_t->authorName;
				       	    	
						//echo get_class($obj_t); //MBlog
			  		  
			       	    ?> </span>
			       		
			       	<span id="BlogContent_template"  class="BlogContent"><?php echo $obj_t->Content;  $this->viewData->next(); ?>  	</span>
			       	
			       	<span id="AdContent_template"  class="AdContent"> <a href="<?php $obj_t->adURL ?>"><?php $obj_t->adContent ?></a> </span>
			       		
		       	</div>
	       </div>
	       
	       
	       
	       <?php  }?>
	       
       </div>
     </div>  
  </div>
  <script type="text/javascript">

	//set user name and img
	
	$("userName").get(0).src = user_Details.name;
	
	$("userImg").get(0).src = user_Details.imgURL

	
  
  var BlogDisplay_Type=function(){};

  BlogDisplay_Type.prototype={

	AddMBlog:function (Content,AuthorName,imgPath,adContent,adUrl)
	{
		debugger;

		var ad = "<a href='" + adUrl  + "'>" + adContent + "</a> ";
		
		var templateObject = $("#MBlogs_template");

		var templateObject_obj=templateObject.clone();
		
		var mBlogContainer= $("#MblogContainer");

		templateObject_obj.css("display","block");
		
	    $("#AuthorName_template",templateObject_obj).get(0).innerText = AuthorName;

	    $("#BlogContent_template",templateObject_obj).get(0).innerText = Content;

	    $("#authorImage",templateObject_obj).get(0).src = imgPath;
	
	    $("#AdContent_template",templateObject_obj).get(0).innerHTML = ad;
	    
	    mBlogContainer.prepend(templateObject_obj);
	
	},PublishMBlog:function()
	{

		debugger;
		
		var content = $("#txtArea_MBlog").val();

		var objTotransfer = '{"UserId":"' +  user_Details.$UId + '"."Content":"' + content + '"}';
		
		var returnObj = $.ajax({url:"\Services\HttpService.php\action=PublishBlog",data:{"UserDetails" : objTotransfer},error:erro,async:false});

		var returnJsonObj=$.parseJSON(returnObj.responseText);

		$("#txtArea_MBlog").val("");

		this.AddMBlog(content,user_Details.name,user_Details.img,"Buy Reebok shoes at 50 % discount","http://www.reebok.com/IN/");
		

	}
  };


// script to get blogs at real time




function GetBlogs()
{
	
	var objTotransfer = '{"UserId":"' +  user_Details.UId + '"."LastMBlogTimeStamp":"' + content + '"}';
	
	var returnObj = $.ajax({url:"\Services\HttpService.php\action=GetMySubscribedMBlogs",data:{"UserDetails" : objTotransfer},error:erro,async:false});

	var returnJsonObj = $.parseJSON(returnObj.responseText);

	for(var i=0;returnJsonObj.length ; i++)
	{
		BlogDisplay_Obj.AddMBlog(returnJsonObj.Content,returnJsonObj.AuthorName,returnJsonObj.imgPath,returnJsonObj.adContent,returnJsonObj.adURL);
	}
}


  setTimeout(function(){}, 1000 * 2 );
  
  
  function erro(rel,b,c)
  {

  	alert("some error happend");
  }
	var BlogDisplay_Obj=new BlogDisplay_Type();
	
  </script>
  
  
   <div id="MBlogs_template" class="MBlogTemplate" style="display:none">
		       	<div id="imgContent">
		       		<img  alt="" src="../../public/Image/007.jpg" id="authorImage"  />
		       	</div>
		       		
		       	<div id="BlogContentBox">
			       	
			       	<span id="AuthorName_template" class="AuthorName"> </span>
			       		
			       	<span id="BlogContent_template"  class="BlogContent"></span>
			       	
			       	<span id="AdContent_template"  class="AdContent"> </span>
			       		
		       	</div>
</div>
<?php 
		}
	
	}
	?>