<script type="text/javascript">
 $(window).load(function(){
        $('#search').keyup(function(){
            var searchField = $('#search').val();
			if(searchField === '')  {
				$('#results').html('');
				return;
			}
			
            var regex = new RegExp(searchField, "i");
            var output = ' ';
            var count = 1;
            $.getJSON('radio.json', function(data) {
			  data=data.items;
              $.each(data, function(key, val){
                if ((val.name.search(regex) != -1)){
                  output += '<a href="http://bhuvankumarthakur.co.nf/tools/custom/player.php?title='+val.name+'&ext='+val.type+'&url=' + val.url + '"  target="iframe_a" ><div id="button">' + val.name +'</div></a>';  
                  count++;
                }
              });
              output += '';
              $('#results').html(output);
            }); 
        });
      });
</script>