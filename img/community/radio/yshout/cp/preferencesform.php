<h2>Preferences</h2>
<p>If you're not sure what a preference does, view the <a href="?reqType=help">help page</a>! It contains detailed descriptons of all the preferences listed below.</p>

<p style="font-size: 15px; font-weight:bold;">PLEASE DO NOT CHANGE ANY OF THESE SETTINGS.<br />If you are a DJ you may change the flood timeout (60000), length (60000) and messages (1) if you want to take requests from the shoutbox and not have people spam it up. Otherwise timeout (30000) length (5000) messages (3)</p>

<form id="prefs-form" action="?reqType=setprefs" method="post">
	<fieldset>
		<legend>Control panel</legend>
		
		<ol>
			<li>
				<label for="password">Password</label> 
				<input type="text" name="password" id="password" maxlength="25" value="<?= $prefs['password']; ?>" />
			</li>
		</ol>
	</fieldset>

	<fieldset>
		<legend>History</legend>
		
		<ol>
			<li>
				<label for="logs">Maximum logs</label> 
				<input type="text" name="logs" id="logs" value="<?= $prefs['logs']; ?>" />
			</li>
		
			<li>
				<label for="history">Shouts to keep in history</label> 
				<input type="text" name="history" id="history" value="<?= $prefs['history']; ?>" />
			</li>
		</ol>
	</fieldset>
	
	<fieldset>
		<legend>Input boxes</legend>
		
		<ol>
			<li>
				<label for="defaultNickname">Default nickname text</label> 
				<input type="text" name="defaultNickname" id="defaultNickname" value="<?= $prefs['defaultNickname']; ?>" />
			</li>

			<li>
				<label for="defaultMessage">Default message text</label> 
				<input type="text" name="defaultMessage" id="defaultMessage" value="<?= $prefs['defaultMessage']; ?>" />
			</li>
		
			<li>
				<label for="defaultSubmit">Default submit text</label> 
				<input type="text" name="defaultSubmit" id="defaultSubmit" value="<?= $prefs['defaultSubmit']; ?>" />
			</li>
		
			<li>
				<label for="nicknameLength">Max. nickname length</label> 
				<input type="text" name="nicknameLength" id="nicknameLength" value="<?= $prefs['nicknameLength']; ?>" />
			</li>

			<li>
				<label for="messageLength">Max. message length</label> 
				<input type="text" name="messageLength" id="messageLength" value="<?= $prefs['messageLength']; ?>"  />
			</li>
		</ol>
	</fieldset>

	<fieldset>
		<legend>Miscellaneous preferences</legend>
		 
		<ol>
			<li>
				<label for="inverse">Form position</label> 
				<select name="inverse" id="inverse">
					<option <? echo $prefs['inverse'] ? 'selected="selected"' : ''; ?> >Top</option>
					<option <? echo !$prefs['inverse'] ? 'selected="selected"' : ''; ?> >Bottom</option>
				</select>
			</li>

			<li>
				<label for="timestamp">Timestamp format</label> 
				<select name="timestamp" id="timestamp">
					<option <? echo $prefs['timestamp'] == 12 ? 'selected="selected"' : ''; ?> >12-hour</option>
					<option <? echo $prefs['timestamp'] == 24 ? 'selected="selected"' : ''; ?> >24-hour</option>
					<option <? echo $prefs['timestamp'] == 0 ? 'selected="selected"' : ''; ?> >No timestamps</option>
				</select>
			</li>		
							
			<li>
				<label for="refresh">Refresh rate (ms)</label> 
				<input type="text" name="refresh" id="refresh" value="<?= $prefs['refresh']; ?>" />
			</li>
			
			<li>
				<label for="truncate">Messages to show</label> 
				<input type="text" name="truncate" id="truncate" value="<?= $prefs['truncate']; ?>" />
			</li>	
								
			<li>
				<label for="showCPLink">Show link to Admin CP</label> 
				<input type="checkbox" name="showCPLink" id="showCPLink" <? echo $prefs['showCPLink'] ? 'checked="ya rly"' : ''; ?> />
			</li>
		
			<li>
				<label for="info">Info view</label> 
				<select name="info" id="info">
					<option <? echo $prefs['info'] == 'overlay' ? 'selected="selected"' : ''; ?> >Overlay</option>
					<option <? echo $prefs['info'] == 'inline' ? 'selected="selected"' : ''; ?> >Inline</option>
				</select>
			</li>

		</ol>
	</fieldset>		

	<fieldset>
		<legend>Flood control</legend>
		
		<ol>
			<li>
				<label for="floodTimeout">Flood timeout (ms)</label> 
				<input type="text" name="floodTimeout" id="floodTimeout" value="<?= $prefs['floodTimeout']; ?>" />
			</li>

			<li>
				<label for="floodMessages">Flood messages</label> 
				<input type="text" name="floodMessages" id="floodMessages" value="<?= $prefs['floodMessages']; ?>" />
			</li>
		
			<li>
				<label for="floodDisable">Flood length (ms)</label> 
				<input type="text" name="floodDisable" id="floodDisable" value="<?= $prefs['floodDisable']; ?>" />
			</li>
			
			<li>
				<label for="flood">Use flood control</label> 
				<input type="checkbox" name="flood" id="flood" <? echo $prefs['flood'] ? 'checked="ya rly"' : ''; ?> />
			</li>
		</ol>
	</fieldset>
	
	<fieldset id="submit-fieldset">
		<legend>Submit</legend>
		<ol>
			<li>
				<label>If you're done...</label>
				<input type="submit" id="submit" value="Save Preferences">
			</li>
			<li>
				<label>Or if you've screwed up</label>
				<a href="?reqType=resetprefs">Reset the preferences</a>
			</li>
		</ol>
	</fieldset>
	
	<input type="hidden" value="true" name="form" id="form" />

</form>