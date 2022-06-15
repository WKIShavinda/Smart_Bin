<html>
<head>
	<title>Waste Reports</title>
	
	<link rel="icon" href="images/trash.png" type="image/gif">
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1024, maximum-scale=1">
	
	<meta http-equiv="refresh" content="5" >
	
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/main.css?v=5">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Amaranth:400,700|Just+Another+Hand'>
	<link rel="stylesheet" type="text/css" href="assets/prettify.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
</head>
<body style="background: #a9d7cc;">

	<nav class="navbar navbar-inverse" style="height: 37px;">
		<div class="container-fluid" style="height: 37px; ">
			<table border=0 style="height: 37px; margin-top: -7px; margin-left: -859px;">
				<tr style="height: 37px;">
					<td>
						<div class="navbar-header">
							<a class="navbar-brand" href="http://localhost/firebase/Home.html" >Smart Waste Detection and Segregation System</a>
						</div>
					</td>
			
					<td>
						<ul class="nav navbar-nav">
							<li>
								<a href="http://localhost/firebase/gauge.js-gh-pages/index.php"><font style="font-size: 14px;">Waste Level</font></a>
							</li>
						</ul>
					</td>
					
					<td>
						<ul class="nav navbar-nav" >
							<li class="active">
								<a href="http://localhost/firebase/Report.php"><font style="font-size: 14px;">Waste Analysis</font></a>
							</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
	</nav>

<!--
	<section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody class="">
									<tr>-->
									
                                    <?php 
                                        include('C:/xampp/htdocs/firebase/includes/dbconfig.php');

                                        $bin_01_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device1";
                                        $bin_01_getdata = $database->getReference($bin_01_ref)->getValue();
										$i = 0;
										$sum_bin_01 = 0;
										$avg_bin_01 = 0;
										$a = 0;
										$x = 0;
										
										$bin_02_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device2";
                                        $bin_02_getdata = $database->getReference($bin_02_ref)->getValue();
										$j = 0;
										$sum_bin_02 = 0;
										$avg_bin_02 = 0;
										$b = 0;
										$y = 0;
										
										$bin_03_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device3";
                                        $bin_03_getdata = $database->getReference($bin_03_ref)->getValue();
										$k = 0;
										$sum_bin_03 = 0;
										$avg_bin_03 = 0;
										$c = 0;
										$z = 0;

										//*********************************************Bin 01******************************************************
                                        if($bin_01_getdata > 0)
                                        {
                                            //$row = end($getdata)
											foreach($bin_01_getdata as $key => $bin_01_row)
											{
												$i++;
												$sum_bin_01 += $bin_01_row['level'];
												
												if($bin_01_row['detected'] == 'True')
												{
													$a++;
												}
												
												if($bin_01_row['level'] > 85)
												{
													$x++;
												}
											}
                                        }
                                        else
                                        {
                                    ?>
                                            <td class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </td>
                                    <?php
                                        }
										
										//**********************************************Bin 02****************************************************
										if($bin_02_getdata > 0)
                                        {
                                            //$row = end($getdata)
											foreach($bin_02_getdata as $key => $bin_02_row)
											{
												$j++;
												$sum_bin_02 += $bin_02_row['level'];
												
												if($bin_02_row['detected'] == 'True')
												{
													$b++;
												}
												
												if($bin_02_row['level'] > 85)
												{
													$y++;
												}
											}
                                        }
                                        else
                                        {
                                    ?>
                                            <td class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </td>
                                    <?php
                                        }
										
										//*********************************************Bin 03************************************************
										if($bin_03_getdata > 0)
                                        {
                                            //$row = end($getdata)
											foreach($bin_03_getdata as $key => $bin_03_row)
											{
												$k++;
												$sum_bin_03 += $bin_03_row['level'];
												
												if($bin_03_row['detected'] == 'True')
												{
													$c++;
												}
												
												if($bin_03_row['level'] > 85)
												{
													$z++;
												}
											}
                                        }
                                        else
                                        {
                                    ?>
                                            <td class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </td>
                                    <?php
                                        }
                                    ?>
										
										
								<!--
									</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<br><br>-->
	
	<!--********************************************************PIE CHART************************************************************-->
	
	
	<?php
	
		$avg_bin_01 = $sum_bin_01 / $i;
		$avg_bin_02 = $sum_bin_02 / $j;
		$avg_bin_03 = $sum_bin_03 / $k;
	
		$bin_01_level_percentage = ($avg_bin_01 * 100) / ($avg_bin_01 + $avg_bin_02 + $avg_bin_03);
		$bin_02_level_percentage = ($avg_bin_02 * 100) / ($avg_bin_01 + $avg_bin_02 + $avg_bin_03);
		$bin_03_level_percentage = ($avg_bin_03 * 100) / ($avg_bin_01 + $avg_bin_02 + $avg_bin_03);
		
		$bin_01_irr_percentage = (($a/$i) * 100) / (($a/$i) + ($b/$j) + ($c/$k));
		$bin_02_irr_percentage = (($b/$j) * 100) / (($a/$i) + ($b/$j) + ($c/$k));
		$bin_03_irr_percentage = (($c/$k) * 100) / (($a/$i) + ($b/$j) + ($c/$k));
		
		$bin_01_max_percentage = ($x * 100) / ($x + $y + $z);
		$bin_02_max_percentage = ($y * 100) / ($x + $y + $z);
		$bin_03_max_percentage = ($z * 100) / ($x + $y + $z);
		
	
		//waste level
		$dataPoints_01 = array( 
			array("label"=>"Organic", "y"=>$bin_01_level_percentage),	//Bin 01
			array("label"=>"Plastic", "y"=>$bin_02_level_percentage),	//Bin 02
			array("label"=>"Paper", "y"=>$bin_03_level_percentage)		//Bin 03
		);
		
		
		//irrelevant waste
		$dataPoints_02 = array( 
			array("label"=>"Organic", "y"=>$bin_01_irr_percentage),		//Bin 01
			array("label"=>"Plastic", "y"=>$bin_02_irr_percentage),		//Bin 02
			array("label"=>"Paper", "y"=>$bin_03_irr_percentage)		//Bin 03
		);
		
		//max filled waste
		$dataPoints_03 = array( 
			array("label"=>"Organic", "y"=>$bin_01_max_percentage),		//Bin 01
			array("label"=>"Plastic", "y"=>$bin_02_max_percentage),		//Bin 02
			array("label"=>"Paper", "y"=>$bin_03_max_percentage)		//Bin 03
		);
		 
	?>
	
	<script>
		window.onload = function() {
			
			//Waste level
			var chart_01 = new CanvasJS.Chart("chartContainer-01", {
				animationEnabled: true,
				title: {
					text: "Average Waste Fill"
				},
				subtitles: [{
					text: "Year 2022"
				}],
				data: [{
					type: "pie",
					yValueFormatString: "#,##0.00\"%\"",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($dataPoints_01, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart_01.render();

			//Irrelevant waste
			var chart_02 = new CanvasJS.Chart("chartContainer-02", {
				animationEnabled: true,
				title: {
					text: "Irrelevant Waste Fill"
				},
				subtitles: [{
					text: "Year 2022"
				}],
				data: [{
					type: "pie",
					yValueFormatString: "#,##0.00\"%\"",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($dataPoints_02, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart_02.render();
			
			//Irrelevant waste
			var chart_03 = new CanvasJS.Chart("chartContainer-03", {
				animationEnabled: true,
				title: {
					text: "Maximum Waste Fill"
				},
				subtitles: [{
					text: "Year 2022"
				}],
				data: [{
					type: "pie",
					yValueFormatString: "#,##0.00\"%\"",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($dataPoints_03, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart_03.render();
		}
	</script>

	<center>
		<div>
			<table>
				<tbody>
					<td style="padding: 20px;">
						<div id="chartContainer-01" style="height: 370px; width: 450px; border: 2px solid black"></div>
					</td>
					
					<td style="padding: 20px;">
						<div id="chartContainer-02" style="height: 370px; width: 450px; border: 2px solid black"></div>
					</td>
					
					<td style="padding: 20px;">
						<div id="chartContainer-03" style="height: 370px; width: 450px; border: 2px solid black"></div>
					</td>
				</tbody>
			</table>
		</div>
	</center>

</body>
</html>