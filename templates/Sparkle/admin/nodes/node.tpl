<tr>
	<td>{$row['name']}</td>
    <td><if $row['is_default']=='1'>{$lng['panel']['yes']}<else>{$lng['panel']['no']}</if></td>
	<td>{$row['image_name']}</td>
	<td>{$row['image_tag']}</td>
    <td>{$row['domains']}</td>
	<td>
		<a href="{$linker->getLink(array('section' => 'nodes', 'page' => $page, 'action' => 'edit', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
		</a>&nbsp;
		<a href="{$linker->getLink(array('section' => 'nodes', 'page' => $page, 'action' => 'delete', 'id' => $row['id']))}">
			<img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
		</a>
	</td>
</tr>
