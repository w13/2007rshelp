<h2>Login</h2>

<form id="login-form" method="post" action="admincp.php">
	<fieldset>
	<legend >Login to YShout</legend>
		<ol>
			<li>
				<label for="password">Password (default fortytwo)</label>
				<input type="password" id="password" name="password" />
			</li>

			<li>
				<label for="submit">If you REALLY want to</label>
				<input type="submit" id="submit" value="Login!" />
			</li>
		</ol>
	</fieldset>
	
	<input type="hidden" name="reqType" value="login" />
	
</form>