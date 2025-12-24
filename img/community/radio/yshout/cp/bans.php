<?
	$ys = ys();
	$bans = $ys->bans(); 
?>

<h2>Bans</h2>

<? if(sizeof($bans) > 0) : ?>
	<p>All IP's that are banned are displayed below. If you're feeling generous you can <a href="?reqType=unbanall">Unban them all</a>!</p>

	<table>
		<tr class="title">
			<th>IP</th>
			<th>Reason</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
		<? foreach($bans as $ban) : ?>
			<tr>
				<td class="ban-ip"><?= $ban['ip']; ?></td>
				<td class="ban-reason"><?= $ban['reason'] == '' ? 'I felt like it.' : $ban['reason']; ?></td>
				<td class="ban-date"><?= date('F dS', $ban['timestamp']); ?></td>
				<td class="ban-actions"><a href="?reqType=unban&ip=<?= $ban['ip']; ?>">Unban</a></td>
			</tr>
		<? endforeach; ?>
	</table>
<? else : ?>
	<p>There aren't any bans to show yet, but feel free to add some below.</p> 
<? endif; ?>

<form id="ban-form" method="post" action="?reqType=ban">
	<fieldset>
		<legend>Add a victim!</legend>
		<ol>
			<li>
				<label for="ip">IP</label>
				<input type="text" id="ip" name="ip" />
			</li>
			<li>
				<label for="reason">Reason</label>
				<input type="text" id="reason" name="reason" />
			</li>
			<li>
				<label for="submit">Feeling evil?</label>
				<input type="submit" id="submit" name="submit" value="Finish him!" />
			</li>
		</ol>
	</fieldset>
	<input type="hidden" id="form" name="form" value="true" />
</form>