<!DOCTYPE html>
<html lang="en">
<head>
	<title>Waste Level</title>
	
    <meta charset="UTF-8">
    
	<meta name="description" content="100% native and cool looking animated JavaScript/CoffeeScript gauge">
	<meta name="viewport" content="width=1024, maximum-scale=1">
	<meta property="og:image" content="http://bernii.github.com/gauge.js/assets/preview.jpg?v=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
	
	<meta http-equiv="refresh" content="5" >
	
	<link rel="icon" href="trash.png" type="image/gif">
	
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/main.css?v=5">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Amaranth:400,700|Just+Another+Hand'>
	<link rel="stylesheet" type="text/css" href="assets/prettify.css">
	<link rel="stylesheet" type="text/css" href="assets/fd-slider/fd-slider.css?v=2">
	<link rel="stylesheet" type="text/css" href="assets/fd-slider/fd-slider-tooltip.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-analytics.js"></script>
    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-firestore.js"></script>
	
	<script type="text/javascript" src="assets/prettify.js"></script>
	<script type="text/javascript" src="assets/jscolor.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="assets/fd-slider/fd-slider.js"></script>
	<script src="dist/gauge.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="assets/excanvas.compiled.js"></script><![endif]-->
	
	<style>
		.gauge {
			width: 100%;
			max-width: 250px;
			font-family: "Roboto", sans-serif;
			font-size: 32px;
			color: #004033;
		}
		  
		table, th, td{
			border-collapse: collapse;
			border: 3px solid black;
		}
		
		table.center {
			margin-left: auto; 
			margin-right: auto;
		}
	  
	</style>

</head>

<body style="background: #a9d7cc;">

	<nav class="navbar navbar-inverse" style="height: 37px;">
		<div class="container-fluid" style="height: 37px; margin-top: -12px; margin-left: -413px;">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://localhost/firebase/Home.html">Smart Waste Detection and Segregation System</a>
			</div>
			<ul class="nav navbar-nav" style="margin-left: -400px;">
				<li class="active">
					<a href="http://localhost/firebase/gauge.js-gh-pages/index.php" style="padding: 15px;">Waste Level</a>
				</li>
				<li>
					<a href="http://localhost/firebase/Report.php" style="padding: 15px;">Waste Analysis</a>
				</li>
			</ul>
		</div>
	</nav>
	
    
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
										<th>Bin Type</th>
                                        <!--<th>Level</th>-->
                                        <th>Percentage</th>
										<th>Date</th>
										<th>Time</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    <?php 
                                        include('C:/xampp/htdocs/firebase/includes/dbconfig.php');

                                        $bin_01_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device1";
                                        $bin_01_getdata = $database->getReference($bin_01_ref)->getValue();
										
                                        if($bin_01_getdata > 0)
                                        {
                                            $last_row = end($bin_01_getdata);
											
											$bin_01_level = $last_row['level'];
											$bin_01_percentage = $last_row['percentage'].'%';
											$bin_01_date = $last_row['date'];
											$bin_01_time = $last_row['time'];
											$bin_01_timestamp = $last_row['timestamp'];
                                    ?>
                                            <tr>
												<td>Organic Bin</td>
                                                <td><?php echo $bin_01_percentage; ?></td>
												<td><?php echo $bin_01_date;?></td>
												<td><?php echo $bin_01_time; ?></td>
                                            </tr>
                                    <?php
                                        }
										else
                                        {
                                    ?>
                                            <tr class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </tr>
                                    <?php
                                        }
										
										$bin_02_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device2";
                                        $bin_02_getdata = $database->getReference($bin_02_ref)->getValue();
										
										if($bin_02_getdata > 0)
                                        {
                                            $last_row = end($bin_02_getdata);
											
											$bin_02_level = $last_row['level'];
											$bin_02_percentage = $last_row['percentage'].'%';
											$bin_02_date = $last_row['date'];
											$bin_02_time = $last_row['time'];
											$bin_02_timestamp = $last_row['timestamp'];
                                    ?>
                                            <tr>
												<td>Paper Bin</td>
                                                <td><?php echo $bin_02_percentage; ?></td>
												<td><?php echo $bin_02_date;?></td>
												<td><?php echo $bin_02_time; ?></td>
                                            </tr>
                                    <?php
                                        }
										
                                        else
                                        {
                                    ?>
                                            <tr class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </tr>
                                    <?php
                                        }
										
										$bin_03_ref = "UsersData/GBTkl2mHHjTCLYaRneCZfVnlhcs1/readings/Device3";
                                        $bin_03_getdata = $database->getReference($bin_03_ref)->getValue();
										
										if($bin_03_getdata > 0)
                                        {
                                            $last_row = end($bin_03_getdata);
											
											$bin_03_level = $last_row['level'];
											$bin_03_percentage = $last_row['percentage'].'%';
											$bin_03_date = $last_row['date'];
											$bin_03_time = $last_row['time'];
											$bin_03_timestamp = $last_row['timestamp'];
                                    ?>
                                            <tr>
												<td>Plastic Bin</td>
                                                <td><?php echo $bin_03_percentage; ?></td>
												<td><?php echo $bin_03_date;?></td>
												<td><?php echo $bin_03_time; ?></td>
                                            </tr>
                                    <?php
                                        }
										
                                        else
                                        {
                                    ?>
                                            <tr class="text-center">
                                                <td colspan="6">DATA NOT THERE IN DATABASE</td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<br>
	
	<div style="padding : 10px;">
		<table style="width:100%; background: white;">
			
			<thead class="table-dark">
				<tr>
					<th style="text-align: center; font-size:25px;">Organic Bin</th>
					<th style="text-align: center; font-size:25px;">Paper Bin</th>
					<th style="text-align: center; font-size:25px;">Plastic Bin</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<!--*****************************************************Bin 01 Gauge*********************************************************************-->
					<td>
						
							<div id="example" class="gauge">
								<ul class="horiz-list" id="type-select">
									<li class="active" type="gauge">
										<canvas width=1 height=1 id="select-1"></canvas>
									</li>
								</ul>
								
								<div id="preview" style="margin-left: 50px;">
									<canvas width=350 height=150 id="canvas-preview"></canvas>
									
									<div id="preview-textfield"></div>
								</div>
			 
								<form id="opts" class="opts">
				
										<!--Change Gauge value realtime-->
										<input type="hidden" name="currval" min="0" max="100" step="1" value="<?php echo $bin_01_level; ?>"><br>
									
								</form>
							</div>

					</td>
					
					<!--*****************************************************Bin 02 Gauge*********************************************************************-->
					<td>
						
						<div id="example" class="gauge">
								<ul class="horiz-list" id="type-select">
									<li class="active" type="gauge">
										<canvas width=1 height=1 id="select-1"></canvas>
									</li>
								</ul>
								
								<div id="preview" style="margin-left: 50px;">
									<canvas width=350 height=150 id="canvas-preview"></canvas>
									
									<div id="preview-textfield"></div>
								</div>
			 
								<form id="opts" class="opts">
				
										<!--Change Gauge value realtime-->
										<input type="hidden" name="currval" min="0" max="100" step="1" value="<?php echo $bin_01_level; ?>"><br>
									
								</form>
							</div>
						
					</td>
					
					<!--*****************************************************Bin 03 Gauge*********************************************************************-->
					<td>
						
						<div id="example" class="gauge">
								<ul class="horiz-list" id="type-select">
									<li class="active" type="gauge">
										<canvas width=1 height=1 id="select-1"></canvas>
									</li>
								</ul>
								
								<div id="preview" style="margin-left: 50px;">
									<canvas width=350 height=150 id="canvas-preview"></canvas>
									
									<div id="preview-textfield"></div>
								</div>
			 
								<form id="opts" class="opts">
				
										<!--Change Gauge value realtime-->
										<input type="hidden" name="currval" min="0" max="100" step="1" value="<?php echo $bin_01_level; ?>"><br>
									
								</form>
							</div>
						
					</td>

				</tr>
			</tbody>
		</table>
	</div>
	
	
	
	
	
	
	
	<script type="text/javascript">
	prettyPrint();

	function update() {
		var opts = {};
		var tmp_opts = opts;
		tmp_opts.renderTicks = {};

		$('.opts input[min], .opts .color').not('.renderTicks').each(function() {
			var val = $(this).hasClass("color") ? this.value : parseFloat(this.value);
			if($(this).hasClass("color")){
				val = "#" + val;
			}
			if(this.name.indexOf("lineWidth") != -1 || this.name.indexOf("radiusScale") != -1 || 
			   this.name.indexOf("angle") != -1 || this.name.indexOf("pointer.length") != -1)
			{
				val /= 100;
			}
			else if(this.name.indexOf("pointer.strokeWidth") != -1)
			{
				val /= 1000;
			}
			
			$('#opt-' + this.name.replace(".", "-")).text(val);
			if(this.name.indexOf(".") != -1)
			{
				var elems = this.name.split(".");
				var tmp_opts = opts;
				for(var i=0; i<elems.length - 1; i++)
				{
					if(!(elems[i] in tmp_opts))
					{
						tmp_opts[elems[i]] = {};
					}
					tmp_opts = tmp_opts[elems[i]];
				}
				tmp_opts[elems[elems.length - 1]] = val;
			}
			else if($(this).hasClass("color"))
			{
				// color picker is removing # from color values
				opts[this.name] = "#" + this.value
				$('#opt-' + this.name.replace(".", "-")).text("#" + this.value);
			}
			else
			{
				opts[this.name] = val;
			}
			if(this.name == "currval")
			{
				// update current demo gauge
				demoGauge.set(parseInt(this.value));
				AnimationUpdater.run();
			}
		});
		
		$('#opts input:checkbox').each(function() {
			opts[this.name] = this.checked;
			$('#opt-' + this.name).text(this.checked);
		});
    
	}
  
	function initGauge(){
		/*document.getElementById("class-code-name").innerHTML = "Gauge";*/
		demoGauge = new Gauge(document.getElementById("canvas-preview"));
		demoGauge.setTextField(document.getElementById("preview-textfield"));
		demoGauge.maxValue = 100;
		demoGauge.set(<?php echo $bin_01_level; ?>);
	};
  

	$(function() {
		var params = {};
		var hash = /^#\?(.*)/.exec(location.hash);
		if (hash) {
			$('#share').prop('checked', true);
			$.each(hash[1].split(/&/), function(i, pair) {
				var kv = pair.split(/=/);
				params[kv[0]] = kv[kv.length-1];
			});
		}
		$('.opts input[min], #opts .color').each(function() {
			var val = params[this.name];
			if (val !== undefined) this.value = val;
				this.onchange = update;
		});
		$('.opts input[name=currval]').mouseup(function(){
			AnimationUpdater.run();
		});

		$('.opts input:checkbox').each(function() {
		  this.checked = !!params[this.name];
		  this.onclick = update;
		});
		$('#share').click(function() {
			window.location.replace(this.checked ? '#?' + $('form').serialize() : '#!');
		});

		$("#type-select li").click(function(){
			$("#type-select li").removeClass("active")
			$(this).addClass("active");
			var type = $(this).attr("type");
    	
		
			if (type=="gauge"){
				initGauge();
				$("input[name=lineWidth]").val(44);
				$("input[name=fontSize]").val(41);
				$("input[name=angle]").val(15);
				$("#preview-textfield").removeClass("reset").addClass("reset");
			
				$("input[name=colorStart]").val("6FADCF")[0].color.importColor();
				$("input[name=colorStop]").val("8FC0DA")[0].color.importColor();
				$("input[name=strokeColor]").val("E0E0E0")[0].color.importColor();

				fdSlider.enable('input-ptr-len');
				fdSlider.enable('input-ptr-stroke');
				$("#input-ptr-color").prop('disabled', false);
				selectGaguge1.set(100);
				selectGaguge2.set(1) ;
				selectGauge3.set(1);
				selectGauge4.set(1);
			}
		
			//fdSlider.updateSlider('input-line-width');
			fdSlider.updateSlider('input-font-size');
			fdSlider.updateSlider('input-angle');
			$("#example").removeClass("donut, gauge").addClass(type);
			update();
		});

		selectGaguge1 = new Gauge(document.getElementById("select-1"));
		selectGaguge1.maxValue = 100;
		selectGaguge1.set(1552);

		initGauge();
		update();

	});
</script>

<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-11790841-11']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
   
</body>
</html>
