<ul>
<?
	foreach ( $rubroArray as $personas )
	{
		?><li><?=$personas['object']->nombre?></li><?
	}
?>
</ul>

<?
foreach ( $rubroArray as $personas )
{
	?>
	<ul id="persona<?=$personas['object']->id?>">
		<?
		foreach ( $personas['cuentas'] as $cuentas )
		{
			?><li><?=$cuentas->nombre?></li><?
		}
		?>
	</ul>	
	<?
}