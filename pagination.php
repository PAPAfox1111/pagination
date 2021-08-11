<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>live data search with pagination</title>

	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>

	<br />
	<div class="card">
		<div class="card-header">Dynamic Data</div>
		<div class="card-body">
			<div class="form-group">
				<input type="text" name="search_box" id="search_box"
						class="form-control" placeholder="Type your search" /> 
			</div>
			<div class="table-responsive" id="dynamic_content"></div>

		</div>
	</div>
</body>
</html>

<script>
	$(document).ready(function(){

		load_data(1);

		function load_data(page, query=''){
			$.ajax({
				url: "fetch.php",
				method: "POST",
				data: {page:page, query:query},
				success: function(data){
					$('#dynamic_content').html(data);
				}
			})
		}
		$(document).on('click', '.page-link', function(){
			var page = $(this).data('page_number');
			var query = $('#search_box').val();
			load_data(page, query);
		});

		$('#search_box').keyup(function(){
			var query = $('#search_box').val();
			load_data(1, query);
			console.log(query);
		});
		
	
	});




</script>