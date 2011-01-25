<div class="inner-page-title">
						<h3>BLA</h3>
					</div>	
				<div class="content-box">
					<table cellspacing="0">
						<thead>
							<tr>
								<th>{lang.description}</th>
								<th>{lang.value}</th>
							</tr>
						</thead>
						<tbody>
														{loop name="wid"}
							<tr>
                                <td>{$wid.widgetname}</td>
                                <td>{$wid.widgetarea}</td>
{/loop}
							
						</tbody>
                    </table>
				</div>
