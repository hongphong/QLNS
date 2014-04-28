<div class="right actions" style="width:100%">
	<div class="left">
        <div id="head">
            <ul class="tab">
     			
            </ul>
        </div>
    </div>
    
    <div class="right"></div>
    
    <div class="left" style="width:100%;">
    	<div id="md03">
            <div class="content">
				<p style="text-align:center; color:#f00; padding-top:10px;">Phần quản trị đánh giá sản phẩm</p>
            </div>
            <div class="footer"></div>
        </div>	
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		//$('#nav li a[href|="link"]').addClass('current');
		$(function() {
			$('#table tr').hover(function() {
				$(this).css('background-color', '#FFFFC6');
			},
			function() {
				$(this).css('background-color', '');
			});
		});
	});
	$(function(){
		$("#selectall").click(function () {
			  $('.case').attr('checked', this.checked);
		});
		$(".case").click(function(){
			if($(".case").length == $(".case:checked").length) {
				$("#selectall").attr("checked", "checked");
		} else {
				$("#selectall").removeAttr("checked");
			}
		});
	});
</script>