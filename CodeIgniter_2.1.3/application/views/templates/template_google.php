<!DOCTYPE html>
<html lang="en">
	<?php
		echo $head						//	Esta variable es pasada como parámetro a esta vista
	?>

<script type="text/javascript">
	function getMeGoogle(){
		/*$.ajax({
			type: "GET",
			//url: "<?php echo $url_google; ?>",
			success: function (data){
				$('#body_google').html(data);
			},
			error: function (){
				alert(':(');
			}
		});*/
	}

	function doAjax(url){
	    // if it is an external URI
	    if(url.match('^http')){
	      // call YQL
	      $.getJSON("http://query.yahooapis.com/v1/public/yql?"+
	                "q=select%20*%20from%20html%20where%20url%3D%22"+
	                encodeURIComponent(url)+
	                "%22&format=xml'&callback=?",
	        // this function gets the data from the successful 
	        // JSON-P call
	        function(data){
	          // if there is data, filter it and render it out
	          if(data.results[0]){
	            var data = filterData(data.results[0]);
	            $('#body_google').html(data);
	          // otherwise tell the world that something went wrong
	          } else {
	            var errormsg = "<p>Error: can't load the page.</p>";
	            $('#body_google').html(errormsg);
	          }
	        }
	      );
	    // if it is not an external URI, use Ajax load()
	    }
	}

	function filterData(data){
		data = data.replace(/<?\/body[^>]*>/g,'');
		data = data.replace(/[\r|\n]+/g,'');
		data = data.replace(/<--[\S\s]*?-->/g,'');
		data = data.replace(/<noscript[^>]*>[\S\s]*?<\/noscript>/g,'');
		data = data.replace(/<script[^>]*>[\S\s]*?<\/script>/g,'');
		data = data.replace(/<script.*\/>/,'');
		return data;
  	}

	//$(document).ready(doAjax("<?php echo $url_google; ?>"));
</script>

<body >
	<?php
			echo $banner_portada;	//	Banner del sitio Web
	?>
	<div id="body_google" style="
    	max-width: 50%;
    	margin-left: auto;
    	margin-right: auto;
	">
	</div>
	<?php
		echo $footer;
	?>
</body>
</html>
