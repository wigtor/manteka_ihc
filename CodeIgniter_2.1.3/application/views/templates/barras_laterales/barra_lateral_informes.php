<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Infomes"	-->
	<?php
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "reportesUsuario";
		}

		$reportesSistema = "";
		$reportesUsuario = "";
		$inReportes = "";
		if ($subVistaLateralAbierta == "reportesUsuario") {
			$reportesUsuario = 'class="active"';
			$inReportes = "in";
		}
		if ($subVistaLateralAbierta == "reportesSistema") {
			$reportesSistema = 'class="active"';
			$inReportes = "in";
		}
	?>
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
						Reportes</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse <?php echo $inReportes; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $reportesUsuario; ?> ><a href="<?php echo site_url("ReportesU/reportesUsuario")?>">Reportes de usuario</a></li>
						<li <?php echo $reportesSistema; ?> ><a href="<?php echo site_url("ReportesS/reportesSistema")?>">Reportes del sistema</a></li>
						
					</div>
				</div>
			</div>
		</div>
