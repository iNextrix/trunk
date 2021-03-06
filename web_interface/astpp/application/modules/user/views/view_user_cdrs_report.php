<? extend('master.php') ?>
<? startblock('extra_head') ?>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $('.rm-col-md-12').addClass('float-right');
        $(".rm-col-md-12").removeClass("col-md-12");
        var datetime = date + " 00:00:00";
        var datetime1 = date + " 23:59:59";
        $("#customer_cdr_from_date").datetimepicker({
            value:datetime,
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            modal:true,
            format: 'yyyy-mm-dd HH:MM:ss',
            footer:true
         });  
         $("#customer_cdr_to_date").datetimepicker({
            value:datetime1,
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            modal:true,
            format: 'yyyy-mm-dd HH:MM:ss',
            footer:true
         });   

        build_grid("user_cdrs_report","",<? echo $grid_fields; ?>,<? echo $grid_buttons; ?>);
        $("#user_cdr_search_btn").click(function(){
            post_request_for_search("user_cdrs_report","","user_cdrs_report_search");
        });        
        $("#id_reset").click(function(){
            clear_search_request("user_cdrs_report","");
        });
    });
</script>
<script>
var lastClicked = '';
function playAudio(val,time_pause) { 
	if(lastClicked != '' && lastClicked != val){
		var y = document.getElementById("myAudio_"+lastClicked);
		$("#play_"+lastClicked).css("display","block");
		$("#pause_"+lastClicked).css("display","none"); 
		y.pause(); 
		y.currentTime = 0;
	}
	var x = document.getElementById("myAudio_"+val);
	$("#play_"+val).css("display","none");
	$("#pause_"+val).css("display","block"); 
	x.play();
	lastClicked= val;
	setTimeout(function(){
			$("#play_"+val).css("display","block");
			$("#pause_"+val).css("display","none");
		}, time_pause*1000
	);
} 
function pauseAudio(val) { 
	var x = document.getElementById("myAudio_"+val); 
	$("#play_"+val).css("display","block");
	$("#pause_"+val).css("display","none");
	x.pause(); 
} 
</script>
<? endblock() ?>

<? startblock('page-title') ?>
<?= $page_title ?>
<? endblock() ?>

<? startblock('content') ?>        

<section class="slice color-three">
	<div class="w-section inverse p-0">
    	<div class="col-12">
            	<div class="portlet-content mb-4"  id="search_bar" style="display:none">
                    	<?php echo $form_search; ?>
    	        </div>
        </div>
    </div>
</section>

<section class="slice color-three padding-b-20">
	<div class="w-section inverse no-padding">
       <div class="">
           <div class="">
            <div class="card col-md-12 pb-4">      
                <form method="POST"  enctype="multipart/form-data" id="ListForm">
                    <table id="user_cdrs_report" align="left" style="display:none;"></table>
                </form>
            </div>  
        </div>
    </div>
</div>
</section>


<? endblock() ?>	
<? end_extend() ?>  
