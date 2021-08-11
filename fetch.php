<?php

//fetch.php

// for connection to sql database;
$host = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxx";

$dsn = 'mysql:dbname=xxx;host=xxx';

try {
    $connect = new PDO($dsn, $username, $password);

}   
    catch(PDOException $e){
        print "Error:" . $e->getMessage() . "<br />";
        die();
    }

$limit = 5;
$page = 1;


if ($_POST['page'] > 1) {
			$start = (($_POST['page'] - 1) * $limit);
			$page = $_POST['page'];
	} else {
			$start = 0;
	}

	$query = "SELECT * FROM users ";

	if ($_POST['query'] != '') {
			$query .="
			WHERE username LIKE '%".str_replace('', '%', $_POST['query'])."%'
	";
	}

	$query .= ' ORDER BY id ASC ';

	$filter_query = $query . ' LIMIT '. $start. ', '. $limit. '';

	echo "<div>".$filter_query."</div>";

	$statement = $connect->prepare($query);
	$statement->execute();

	$total_data = $statement->rowCount();

	$statement = $connect->prepare($filter_query);
	$statement->execute();

	$result = $statement->fetchAll();

	$total_filter_data = $statement->rowCount();


	//mysqli statement `` not working yet ``
	/* $total_result = $mysqli->query($query);
	$total_data = mysqli_num_rows($total_result);

	$rows = $mysqli->query($filter_query);
	$result = $rows->fetch_all(MYSQLI_ASSOC);
	$total_filter_data = mysqli_num_rows($result); */

	/* $result_filter = $mysqli->query($filter_query);
	$rows_filter = $result_filter->fetch_assoc();
	$total_filter_data = $rows_filter->mysqli_num_row();
		*/

	$output = '
	<label for="" class="">Total Records - '.$total_data.'</label>
	<table class="table table-striped table-bordered">
		<tr>
			<th>ID</th>
			<th>Post Title</th>
		</tr>
	';

	if ($total_data > 0) {
			foreach ($result as $row) {
					$output .= '
					<tr class="">
						<td>'.$row["username"].'</td>
						<td>'.$row["email"].'</td>
					</tr>
					';
			}
	} else {
			$output .= '
			<tr>
				<td colspan="2" align="center">No Data Found</td>
			</tr>
			';
	}

	$output .= '
	</table>
	<br />
	<div align="center">
		<nav aria-label="page navigation">
		<ul class="pagination">
	';


	$total_links = ceil($total_data/$limit);
	$previous_link ='';
	$next_link ='';
	$page_link ='';


	//echo total_links;

	if ($total_links > 4){

			if ($page < 5) {
					for ($count = 1; $count <= 5; $count++) {
							$page_array[] = $count;
					}
					$page_array[] = '...';
					$page_array[] = $total_links;
			} else {
					$end_limit = $total_links - 5;
					if ($page > $end_limit) {
							$page_array[] = 1;
							$page_array[] = '...';

							for ($count = $end_limit; $count <= $total_links; $count++) {
									$page_array[] = $count;
							}
					} else {
							$page_array[] = 1;
							$page_array[] = '...';

							for ($count = $page - 1; $count <= $page + 1; $count++) {
									$page_array[] = $count;
							}
							$page_array[] = '...';
							$page_array[] = $total_links;
					}
			}
	} else {
			for ($count = 1; $count <= $total_links; $count++) {
					$page_array[] = $count;
			}
	}
	if($total_data <= 0){
			$output .= '
			<tr>
				<td colspan="2" align="center">No Data Found</td>
			</tr>
			';
	}

    if ($total_data !== 0) {
        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $page_link .= '
					<li class="page-item active">
						<a class="page-link" href ="javascript:void(0)" 
						data-page_number="'.$page_array[$count].'"
						<span class="sr-only">"'.$page.'"</span></a>
					</li>
					';

                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_link = '
							<li class="page-item ">
								<a class="page-link" href ="javascript:void(0)"
								data-page_number="'.$previous_id.'">Previous</a>
							</li>
							';
                } else {
                    $previous_link = '
							<li class="page-item disabled">
								<a class="page-link" href="#">Previous</a>
							</li>
							';
                }

                $next_id = $page_array[$count] + 1;
                if ($next_id > $total_links) {
                    $next_link = '
									<li class="page-item disabled">
										<a class="page-link" href ="#" >Next</a>
									</li>
							';
                } else {
                    $next_link = '
							<li class="page-item">
								<a class="page-link" href="javascript:void(0)" 
									data-page_number="'.$next_id.'">Next</a>
							</li>
							';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $page_link .='
							<li class="page-item disabled">
								<a class="page-link" href ="#" >...</a>
							</li>
							';
                } else {
                    $page_link .= '
							<li class="page-item"><a class="page-link"
								href ="javascript:void(0)" data-page_number="'.
                 $page_array[$count].'">'.$page_array[$count].'</a>
							</li>
							';
                }
            }
        }
    }

	$output .= $previous_link . $page_link . $next_link;
	$output .= '
		</ul>
		</nav>
	</div>
	';


	echo $output;


?>