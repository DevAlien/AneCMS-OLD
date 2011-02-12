<div class="inner-page-title">
						<h3>BLA</h3>
					</div>	
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<th><?php echo $lang['description'];?></th>
								<th><?php echo $lang['value'];?></th>
							</tr>
						</thead>
						<tbody>
														<?php $counter_wid=0; foreach($var['wid'] as $key => $wid){ $counter_wid++; ?>
							<tr>
                                <td><?php echo $wid['widgetname'];?></td>
                                <td><?php echo $wid['widgetarea'];?></td>
<?php } ?>
							
						</tbody>
                    </table>
				</div>
