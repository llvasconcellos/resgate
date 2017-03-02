<Piecemaker>
  <Settings>
    <imageWidth><?php echo $params->get( 'main_width','300' );?></imageWidth>
    <imageHeight><?php echo $params->get( 'main_height','960' );?></imageHeight>
    <segments><?php echo $params->get('segments','7');?></segments>
    <tweenTime><?php echo trim($params->get( 'duration','1.2' ));?></tweenTime>
    <tweenDelay><?php echo $params->get('tween_delay','0.1');?></tweenDelay>
    <tweenType><?php echo $params->get( 'effect','easeInOutBack' );?></tweenType>
    <zDistance><?php echo $params->get( 'z_distance', 0 )?></zDistance>
    <expand><?php echo $params->get( 'expand', '20' );?></expand>
    <innerColor>0x<?php echo trim($params->get( 'inner_bg','111111' ) );?></innerColor>
    <textBackground>0x<?php echo trim($params->get( 'text_bg','031933' ));?></textBackground>
    <shadowDarkness><?php echo (int)$params->get('shadow','100');?></shadowDarkness>
    <textDistance><?php echo $params->get('text_distance','25');?></textDistance>
    <autoplay><?php echo trim($params->get( 'autoplay','12' ));?></autoplay>
  </Settings>
  <?php foreach($list as $key => $row ) : ?>
     <Image Filename="<?php echo $row->mainImage; ?>">
    	<?php echo modLofpiecemaker::renderItem( $row, $params );?> 
     </Image>
 <?php endforeach; ?>
 <?php?>
</Piecemaker>
