<div class="fixed-menu">
	<ul class="saldos-menu">
	<?
		foreach ( $personas as $persona )
		{
			$style		= '';
			$spanStyle	= '';
			$filtro_icon = false;
			
			if ( round( $persona['saldo'], 2 ) )
			{
				$saldo_parts = explode( "," , formatNumberCustom( $persona['saldo'] ) );
				
				if ( $this->session->userdata( 'filter_' . $persona['unique_name'] ) === 'some' )
				{
					$filtro_icon = true;
				}
				elseif ( $this->session->userdata( 'filter_' . $persona['unique_name'] ) )
				{
					$style		= 'filter: grayscale(100%);';
					$spanStyle	= 'color: grey;';
				}
				
				?>
				<li class="filter_btn" name="<?=$persona['unique_name']?>">
					<?
						if ( $filtro_icon )
						{
							?><img src="<?=base_url( "assets/img/filtro_some" )?>.png" class="filtro_some" /><?
						}
					?>
					<img src="<? echo base_url( "assets/img/" . $persona['unique_name'] )?>.png" class="thumb" style="<?=$style?>border-color: <?=$persona['color']?>" />
					<span style="<?=$spanStyle?>">
						<i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?>
					</span>
				</li>
				<?
			}
		}
	
		if ( $saldoSinRubrar )
		{
			$saldo_parts = explode( "," , formatNumberCustom( $saldoSinRubrar ) );

			$style		= '';
			$spanStyle	= '';
			if ( $this->session->userdata( 'filter_sinrubrar' ) )
			{
				$style		= 'filter: grayscale(100%);';
				$spanStyle	= 'color: grey;';
			}
			
			?>
			<li class="filter_btn" name="sinrubrar"><img src="<?=base_url( 'assets/img/icon_interrogacion.png' )?>" class="thumb" style="<?=$style?>border-color:#e10000;" /><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
			<?
		}
	
	
		if ( round( $checkSaldos, 2 ) )
		{
			$saldo_parts = explode( "," , formatNumberCustom( $checkSaldos ) );
			
			?>
			<li><img src="<?=base_url( 'assets/img/icon_bug.png' )?>"  class="thumb" /><span><i><?=$monedaSimbolo?> </i><?=$saldo_parts[0] . "<i>," . $saldo_parts[1] . "</i>"?></span></li>
			<?
		}
	?>
	</ul>
	
	<script type="text/javascript">
	
	
			var DELAY = 500, clicks = 0, timer = null, thisObjPersona = null;

			$(".filter_btn").click(function()
			{
			        clicks++;
			        
			        thisObjPersona = $(this);
			
			        if(clicks === 1) {

			            timer = setTimeout(function()
			            {
							$.ajax({
								method: "POST",
								url: "<?=base_url('index.php/filtros/selectRubros')?>/" + thisObjPersona.attr('name'),
							})
							.done(function( msg ) {
								
								var jsonObj = jQuery.parseJSON( msg );
	
								$("#filtros-container").html( jsonObj.html );
							});
	
				            $("#dialogPageFiltros").click();

	
							clicks = 0;
			
			            }, DELAY);
			
			        } else {
			
			            clearTimeout(timer);    //prevent single-click actio
			            
						$.ajax({
							method: "POST",
							url: "<?=base_url('index.php/filtros')?>/setPersona/" + thisObjPersona.attr('name'),
						})
						.done(function( msg ) {

							var jsonObj = jQuery.parseJSON( msg );
				
							if ( jsonObj.refresh == true )
							{
								refrescar();
							}
						});


			            clicks = 0;             //after action performed, reset counter
			        }
			});
			
			function refrescar()
			{
				window.location.replace("<?=base_url('index.php/cuentas/' . $this->router->fetch_method() . '/' . implode( "-", $cuentasArray ) )?>");
			}
	
	</script>
	
	<div class="ui-content" style="display:none;">
		<a href="#dialogPageFiltros" id="dialogPageFiltros" data-rel="dialog" data-transition="pop"></a>
	</div>
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
				<li>
					<div class="ui-content">
						<a href="<?=base_url('index.php/cuentas/ver/' . implode( "-", $cuentasArray ) )?>"><img src="<?=base_url('assets/img/icon_list.png')?>" /></a>
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
</div>