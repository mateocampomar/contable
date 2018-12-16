<html>
	<head>
		<title><?=(isset($title)) ? $title : 'Contable - Flia Campomar Pereyra Iraola'?></title>
		
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="<?=base_url('assets/css/css.css')?>" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css">
		<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
		
	</head>
	<body>

		<div data-role="page" id="page1">
			<header>
			</header>
			<div id="left_header">
				<ol>
					<?
					foreach( $listCuentas as $cuenta )
					{
						
						if ( $cuenta->saldo >= 0 )	$cssClass = 'positivo';
						else						$cssClass = 'negativo';
						
						$saldo_parts = explode( "," , number_format($cuenta->saldo, 2, "," , ".") );
						
						?>
						<li class="<?=$cssClass?>" onclick="window.location.href='<?=base_url( 'index.php/cuentas/ver/' . $cuenta->id )?>'">
							<h2><?=$cuenta->nombre?> <strong>(<?=$cuenta->moneda?>)</strong></h2>
							<div class="total">
								<small><?=$cuenta->simbolo?> </small><?=$saldo_parts[0]?><small>,<?=$saldo_parts[1]?></small>
							</div>
						</li>
						<?
					}
					?>
				</ol>
			</div>