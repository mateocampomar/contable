<ul class="saldos-menu">
<?
	foreach ( $personas as $persona )
	{
		$style		= '';
		$spanStyle	= '';
		
		if ( round( $persona['saldo'], 2 ) )
		{
			$saldo_parts = explode( "," , formatNumberCustom( $persona['saldo'] ) );
			
			if ( $this->session->userdata( 'filter_' . $persona['unique_name'] ) )
			{
				$style		= 'filter: grayscale(100%);';
				$spanStyle	= 'color: grey;';
			}
			
			?>
			<li class="filter_btn" name="<?=$persona['unique_name']?>"><img src="<? echo base_url( "assets/img/" . $persona['unique_name'] )?>.png" class="border" style="<?=$style?>border-color: <?=$persona['color']?>" /><span style="<?=$spanStyle?>"><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
			<?
		}
	}

	if ( $saldoSinRubrar )
	{
		$saldo_parts = explode( "," , formatNumberCustom( $saldoSinRubrar ) );
		
		?>
		<li class="filter_btn" name="sinrubrar"><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>" class="border" style="border-color:#e10000;" /><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
		<?
	}


	if ( round( $checkSaldos, 2 ) )
	{
		$saldo_parts = explode( "," , formatNumberCustom( $checkSaldos ) );
		
		?>
		<li><img src="<?=base_url( 'assets/img/icon_bug.png' )?>"/><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
		<?
	}
?>
</ul>

<script type="text/javascript">



		$(".filter_btn").dblclick(function()
		{
			alert('ok dbl');
		});

		$(".filter_btn").click(function()
		{
			//alert();
			$.ajax({
				method: "POST",
				url: "<?=base_url('index.php/filtros')?>/setPersona/" + $(this).attr('name'),
			})
			.done(function( msg ) {
				
				var jsonObj = jQuery.parseJSON( msg );
	
				if ( jsonObj.refresh == true )
				{
					refrescar();
				}
			});
		});
		
		function refrescar()
		{
			window.location.replace("<?=base_url('index.php/cuentas/' . $this->router->fetch_method() . '/' . implode( "-", $cuentasArray ) )?>");
		}

</script>




<ul class="cuenta-menu">
	<?
		if ( !$multicuenta )
		{
			?>
			<li>
				<div class="ui-content">
					<a href="#dialogPageTransfer" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_transfer.png')?>" /></a>
				</div>
			</li>
			<li>
				<div role="main" class="ui-content">
			    	<a href="#dialogPage" data-rel="dialog" data-rel="back" data-transition="pop"><img src="<?=base_url('assets/img/icon_plus.png')?>" /></a>
				</div>
			</li>
			<?
		}
	?>
	<li>
		<div class="ui-content">
			<a href="<?=base_url('index.php/cuentas/stats/' . implode( "-", $cuentasArray ) )?>"><img src="<?=base_url('assets/img/icon_stats.png')?>" /></a>
		</div>
	</li>
	<?
		if ( !$multicuenta )
		{
			?>
			<li>
				<div class="ui-content">
					<a href="<?=base_url('index.php/cuentas/ver/' . implode( "-", $cuentasArray ) )?>"><img src="<?=base_url('assets/img/icon_list.png')?>" /></a>
				</div>
			</li>
			<?
		}
	?>
</ul>
<?
	$saldo_parts = explode( "," , formatNumberCustom( $saldoTotal ) );
	
	$style = '';
	if ( $saldoTotal < 0 )	$style = "color:red;";
?>
<h1>
	<div class="saldo" style="<?=$style?>"><span><?=$monedaSimbolo?></span> <?=( isset($saldo_parts[0]) && $saldo_parts[0] ) ? $saldo_parts[0] : '0'?><span>,<?=(isset($saldo_parts[1])) ? $saldo_parts[1] : '00'?></span></div>
	<div><?=implode(", ", $cuentas_nombres)?> <span style="font-weight: normal;">[<?=$moneda?>]</span></div>
</h1>