<Text>
    <headline><?php echo $row->title;?></headline>
    <break>Ӂ</break>
    <paragraph> <?php echo $row->description; ?></paragraph>
    <break>Ӂ</break>
     <break>Ӂ</break>
    <paragraph><a href="<?php echo $row->link?>" target="<?php echo $params->get('open_target','_parent');?>"><?php echo JText::_('Read more...');?></a></paragraph>	
 </Text>   
