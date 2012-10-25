<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test</title>
<script src="picnet.table.filter.min.js"type="text/javascript"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>    		    
	
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialise Plugin
            var options1 = {
                additionalFilterTriggers: [$('#onlyyes'), $('#onlyno'), $('#quickfind')],
                clearFiltersControls: [$('#cleanfilters')],
                matchingRow: function(state, tr, textTokens) {					
                    if (!state || !state.id) { return true; }
					var child = tr.children('td:eq(2)');
					if (!child) return true;
					var val =  child.text();					
					switch (state.id) {
						case 'onlyyes': return state.value !== true || val === 'IPA';
						case 'onlyno': return state.value !== true || val === 'no';
						default: return true;
					}
                }
            };

            $('#demotable1').tableFilter(options1);
			
			var grid2 = $('#demotable1');
			var options2 = {                
                filteringRows: function(filterStates) {										
					grid2.addClass('filtering');
                },
				filteredRows: function(filterStates) {      															
					grid2.removeClass('filtering');					
					setRowCountOnGrid2();
                }
            };			
			function setRowCountOnGrid2() {
				var rowcount = grid2.find('tbody tr:not(:hidden)').length;
				$('#rowcount').text('(Rows ' + rowcount + ')');										
			}
			
			grid2.tableFilter(options2); // No additional filters			
			setRowCountOnGrid2();
        });
    </script>
</head>
<body>
<div class="content">
		<h3>Additional Filters for Table 1</h3>
		Only Show Yes: <input type="checkbox" id="onlyyes"/>        	
		Only Show No: <input type="checkbox" id="onlyno"/>
         &nbsp;<input type="submit" value="Set Quick Find filter and refresh table" onClick="$('#quickfind').val('12'); $('#demotable1').tableFilterRefresh();"/>
		<br/>    	<br/>    
		Quick Find: <input type="text" id="quickfind"/>

		<a id="cleanfilters" href="#">Clear Filters</a>
		<div class="clear"></div>
			<table id='demotable1'>
				<tbody>
<?PHP

$file_handle = fopen("ChattBrewingCo.beersatlocations.csv", "r");
	$row = 1;
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		print "<tr><td>" . $line_of_text[0] . "</td><td>" . $line_of_text[1]. "</td></tr>";
	}
fclose($file_handle);
?>
				</tbody>

			</table>





</body>
</html>