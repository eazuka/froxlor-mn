$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/ipsports_big.png" alt="" />&nbsp;
				{$lng['admin']['nodes']['nodes']}
			</h2>
		</header>

		<section>
			
			<form action="{$linker->getLink(array('section' => 'ipsandports'))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s"/>
				<input type="hidden" name="page" value="$page"/>
				<div class="overviewsearch">
					{$searchcode}
				</div>
	
				<div class="overviewadd">
					<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
					<a href="{$linker->getLink(array('section' => 'nodes', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['nodes']['add']}</a>
				</div>
	
				<table class="full hl">
					<thead>
						<tr>
							<th>{$lng['admin']['nodes']['name']}&nbsp;{$arrowcode['name']}</th>
							<th>{$lng['admin']['nodes']['image']}&nbsp;{$arrowcode['image']}</th>
                            <th>{$lng['admin']['nodes']['tag']}&nbsp;{$arrowcode['tag']}</th>
                            <th>{$lng['panel']['options']}</th>
						</tr>
					</thead>

					<if $pagingcode != ''>
					<tfoot>
						<tr>
							<td colspan="8">{$pagingcode}</td>
						</tr>
					</tfoot>
					</if>

					<tbody>
						$nodes
					</tbody>
				</table>
			</form>

			<if 15 < $count>
			<div class="overviewadd">
				<img src="templates/{$theme}/assets/img/icons/add.png" alt="" />&nbsp;
				<a href="{$linker->getLink(array('section' => 'nodes', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['nodes']['add']}</a>
			</div>
			</if>

		</section>

	</article>
$footer
