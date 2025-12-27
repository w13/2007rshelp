Object.extend = function(destination, source) {
  for (property in source) {
    destination[property] = source[property];
  }
  return destination;
};

String.prototype.sReplace = function(find, replace) {
	return this.split(find).join(replace);
};

var YShout = function() { this.init.apply(this, arguments); }

var yShout;

YShout.prototype = {
	init: function(options) {
		yShout = this;
		if ($('#yshout').size() == 0) return;

		var dOptions = {
			yPath: 'http://2007rshelp.com/img/community/radio/yshout/',
			log: 1
		};

		this.options = Object.extend(dOptions, options);

		this.ajax(this.initialLoad, { 
			reqType: 'init',
			yPath: this.options.yPath,
			log: this.options.log
		});

		this.postNum = 0;

	},

	initialLoad: function(updates) {
		this.d('In initialLoad');

		this.prefs = updates.prefs;
		this.initForm();
		this.initRefresh();
		this.initCP();
		if (this.prefs.flood) this.initFlood();

		if (updates.nickname)
			$('#ys-input-nickname')
				.removeClass( 'ys-before-focus')
				.addClass( 'ys-after-focus')
				.val(updates.nickname);

		if (updates)
			this.updates(updates);
	},

	initForm: function() {
		this.d('In initForm');
		var postForm = 
			'<form id="ys-post-form"><fieldset>' +
				'<input id="ys-input-nickname" value="' + this.prefs.defaultNickname + '" type="text" maxlength="' + this.prefs.nicknameLength + '" class="ys-before-focus" />' +
				'<input id="ys-input-message" value="' + this.prefs.defaultMessage + '" type="text" maxlength="' + this.prefs.messageLength + '" class="ys-before-focus" />' +
				'<input id="ys-input-submit" value="' + this.prefs.defaultSubmit + '" type="button" />' +
				(this.prefs.showCPLink ? '<a title="Launch History" href="http://2007rshelp.com/img/community/radio/yshout/history.php" target="_blank">View History</a>' : '') +
			'</fieldset></form>';

		var postsDiv = '<div id="ys-posts"></div>';

		if (this.prefs.inverse) $('#yshout').html(postForm + postsDiv);
		else $('#yshout').html(postsDiv + postForm);

		var self = this;

		var defaults = { 
			'ys-input-nickname': self.prefs.defaultNickname, 
			'ys-input-message': self.prefs.defaultMessage
		};

		var keypress = function(e) { 
			var key = window.event ? e.keyCode : e.which; 
			if (key == 13 || key == 3) {
				self.send.apply(self);
				return false;
			}
		};

		var focus = function() { 
			if (this.value == defaults[this.id])
				$(this).removeClass('ys-before-focus').val('');
		};

		var blur = function() { 
			if (this.value == '')
				$(this).addClass('ys-before-focus').val(defaults[this.id]); 
		};

		$('#ys-input-message').keypress(keypress).focus(focus).blur(blur);
		$('#ys-input-nickname').keypress(keypress).focus(focus).blur(blur);

		$('#ys-input-submit').click(function(){ self.send.apply(self) });
		$('#ys-post-form').submit(function(){ return false });
	},

	initRefresh: function() {
		var self = this;
		this.refreshTimer = setInterval(function() {
			self.ajax(self.updates, { reqType: 'refresh' });
		}, 3000);
	},

	initFlood: function() {
		var self = this;
		this.floodCount = 0;
		this.floodControl = false;

		this.floodTimer = setInterval(function() {
			self.floodCount = 0;
		}, this.prefs.floodTimeout);
	},

	initCP: function() {
		var self = this;

		$('#ys-cp-launch').click(function() {
			self.openCP.apply(self);
			return false;
		});
	},

	openCP: function(url) {
		var self = this;
		if (this.cpOpen) return;
		this.cpOpen = true;
		if (!url) url = this.options.yPath + 'history.php';

		$('body').append('<div id="ys-cp-overlay"></div><div id="ys-cp"><a title="Close Admin CP" href="#" id="ys-cp-close">Close</a><object id="cp-browser" data="' + url +'" type="text/html">Something went horribly wrong.</object></div>');

		var scrollTop = this.scrollTop();

		if (scrollTop > 0)
			$('#ys-cp-overlay').css('margin-top', scrollTop + 'px');
			$('#cp-browser').css('margin-top', scrollTop + 'px');
			$('#ys-cp-close').css('margin-top',  scrollTop  - 290 + 'px');
		
		$('#ys-cp-overlay, #ys-cp-close').click(function() { 
			self.reload.apply(self, [true]);
			self.closeCP.apply(self);
			return false; 
		}); 
	},

	closeCP: function() {
		this.cpOpen = false;
		$('#ys-cp-overlay, #ys-cp').remove();
	},

	send: function() {

		if (!this.validate()) return;
		if (this.prefs.flood && this.floodControl) return;

		var  postNickname = $('#ys-input-nickname').val(), postMessage = $('#ys-input-message').val();

		if (postMessage == '/cp')
			this.openCP();
		else
			this.ajax(this.updates, {
				reqType: 'post',
				nickname: postNickname,
				message: postMessage
			});

		$('#ys-input-message').val('')

		if (this.prefs.flood) this.flood();
	},

	validate: function() {
		var nickname = $('#ys-input-nickname').val(),
				message = $('#ys-input-message').val(),
				error = false;

		var showInvalid = function(input) {
			$(input).removeClass('ys-input-valid').addClass('ys-input-invalid').get(0).focus();
			error = true;
		}

		var showValid = function(input) {
			$(input).removeClass('ys-input-invalid').addClass('ys-input-valid');
		}

		if (nickname == '' ||	nickname == this.prefs.defaultNickname)
			showInvalid('#ys-input-nickname');
		else
			showValid('#ys-input-nickname');

		if (message == '' || message == this.prefs.defaultMessage)
			showInvalid('#ys-input-message');
		else
			showValid('#ys-input-message');

		return !error;
	},

	flood: function() {
		var self = this;

		if (this.floodCount < this.prefs.floodMessages) {
			this.floodCount++;
			return;
		}

		this.disable();

		setTimeout(function() {
			self.floodCount = 0;
			self.enable.apply(self);
		}, this.prefs.floodDisable);
	},

	disable: function () {
		$('#ys-input-submit').get(0).disabled = true;
		this.floodControl = true;
	},

	enable: function () {
		$('#ys-input-submit').get(0).disabled = false;
		this.floodControl = false;
	},

	updates: function(updates) {
		if (!updates) return;

		if (updates.prefs) this.prefs = updates.prefs;
		if (updates.posts) this.posts(updates.posts);
	},

	posts: function(p) {
		for (var i = 0; i < p.length; i++)
			this.post(p[i]);

		this.truncate();
	},

	post: function(post) {
		var pad = function(n) { return n > 9 ? n : '0' + n; };
		var date = function(ts) { return new Date(ts * 1000); };
		var time = function(ts) { 
			var d = date(ts);
			var h = d.getHours(), m = d.getMinutes();

			if (self.prefs.timestamp == 12) {
				h = (h > 12 ? h - 12 : h);
				if (h == 0) h = 12;
			}

			return pad(h) + ':' + pad(m);
		};

		var dateStr = function(ts) {
			var t = date(ts);

		  var Y = t.getFullYear();
		  var M = t.getMonth();
		  var D = t.getDay();
		  var d = t.getDate();
		  var day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][D];
		  var mon = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		             'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'][M];

		  return day + ' ' + mon + '. ' + d + ', ' + Y;
		};

		var self = this;

		this.postNum++;

		var id = 'ys-post-' + this.postNum;
		post.message = this.smileys(post.message);
		//post.message = this.links(post.message);
		post.message = this.request(post.message);
		var html = 
			'<div id="' + id + '" class="ys-post' + (post.admin ? ' ys-admin-post' : '') + (post.banned ? ' ys-banned-post' : '') + '">' +
				(this.prefs.timestamp> 0 ? '<span class="ys-post-timestamp">' + time(post.timestamp) + '</span> ' : '') +
				'<span class="ys-post-nickname">' + post.nickname + ':</span> ' +
				'<span class=" ys-post-message">' + post.message + '</span> ' +
				'<span class="ys-post-info' + (this.prefs.info == 'overlay' ? ' ys-info-overlay' : ' ys-info-inline') + '">' + (post.adminInfo ? '<em>IP:</em> ' + post.adminInfo.ip + ', ' : '') + '<em>Posted:</em> ' +  dateStr(post.timestamp) + '.</span>' +
				'<span class="ys-admin-actions"><a title="Show post information" class="ys-info-link" href="#">Info</a>'  + (post.adminInfo ? ' | ' + (post.banned ? '<a title="Unban ' + post.nickname + '" class="ys-unban-link" href="#">Unban</a>' : '<a title="Ban ' + post.nickname + '" class="ys-ban-link" href="#">Ban</a>') : '') + '</span>' +
			'</div>';

		if (this.prefs.inverse) $('#ys-posts').prepend(html);
		else $('#ys-posts').append(html);

		$('#' + id + ' .ys-info-link').click(function() {
			if (this.innerHTML == 'Info') {
				$('#' + id + ' .ys-post-info').css('display', 'block');
				this.innerHTML = 'Close Info';
			} else {
				$('#' + id + ' .ys-post-info').css('display', 'none');
				this.innerHTML = 'Info';
			}

			return false;

		});

		$('#' + id + ' .ys-ban-link').click(function() {
			if (this.innerHTML == 'Banning...') return; 

			var pars = {
				reqType: 'ban',
				ip: post.adminInfo.ip
			};

			self.ajax(function(json) {
				if (json.error) {
					switch(json.error) {
						case 'admin':
							self.error('You\'re not an admin. Log in through the admin CP to ban people.');
							break;
						case 'already':
							self.reload();
						//	self.error('That guy\'s banned already!');
							break;
					}

					return;
				}

				self.reload();
			}, pars);

			this.innerHTML = 'Banning...';
			return false;
		});

		$('#' + id + ' .ys-unban-link').click(function() {
			if (this.innerHTML == 'Unbanning...') return;

			var pars = {
				reqType: 'unban',
				ip: post.adminInfo.ip
			};

			self.ajax(function(json) {
				if (json.error) {
					switch(json.error) {
						case 'admin':
							self.error('You\'re not an admin. Log in through the admin CP to ban people.');
							break;
						case 'already':
							self.reload();
						//	self.error('That guy\'s unbanned already!');
							break;
					}

					return;
				}

				self.reload();
			}, pars);

			this.innerHTML = 'Unbanning...';
			return false;
		});
	},

	smileys: function(s) {
		var yp = this.options.yPath;

		var smile = function(str, smiley, image, title) {
			return str.sReplace(smiley, '<img alt="" title="' + title + '" src="' + yp + 'smileys/' + image + '" />');
		};

		s = smile(s, '(devil)',  'twisted.gif', '(devil)');
		s = smile(s, '(cry)',  'cry.gif', '(cry)');
		s = smile(s, '(eek)',  'eek.gif', '(eek)');
		s = smile(s, '(evil)',  'evil.gif', '(evil)');
		s = smile(s, '(lol)',  'lol.gif', '(lol)');
		s = smile(s, '(happy)',  'mrgreen.gif', '(happy)');
		s = smile(s, '(rolleyes)',  'rolleyes.gif', '(rolleyes)');
		s = smile(s, '(suspect)',  'suspect.gif', '(suspect)');
		s = smile(s, '(uber)',  'uberhappy.gif', '(uber)');
		s = smile(s, '(spam)',  'spam.gif', '(spam)');
		s = smile(s, '(woeh)',  'woeh.gif', '(woeh)');
		s = smile(s, '(woah)',  'woeh.gif', '(woah)');
		s = smile(s, '(mad)',  'beat.gif', '(mad)');
		s = smile(s, '(angry)',  'beat.gif', '(angry)');
		s = smile(s, '(beat)',  'beat.gif', '(beat)');
		s = smile(s, '(fish)',  'fish.gif', '(fish)');		
		s = smile(s, '(mellow)',  'mellow.gif', '(mellow)');		
		s = smile(s, '(nono)',  'nono.gif', '(nono)');
		s = smile(s, '-_-',  'ugh.gif', '-_-');
		s = smile(s, '(peh)',  'peh.png', '(peh)');
		s = smile(s, '(hug)',  'hug.gif', '(hug)');		
		s = smile(s, '(rock)',  'buttrock.gif', '(rock)');	
		s = smile(s, '(whip)',  'whip.gif', '(whip)');	
		s = smile(s, '(poke)',  'poke.gif', '(poke)');	
		s = smile(s, '(uhuh)',  'uhuh.gif', '(uhuh)');
		s = smile(s, '(whistle)',  'whistling.gif', '(whistle)');
		s = smile(s, '(huh)',  'huh.gif', '(huh)');
		s = smile(s, '(unsure)',  'unsure.gif', '(unsure)');
		s = smile(s, '(wave)',  'wave.gif', '(wave)');
		s = smile(s, '(hi)',  'wave.gif', '(hi)');
		s = smile(s, '(wub)',  'wub.gif', '(wub)');
		
		s = smile(s, ':$',  'blush.gif', ':$');
		s = smile(s, ':s',  'confused.gif', ':s');
		s = smile(s, ':S',  'confused.gif', ':S');
		s = smile(s, ':D',  'biggrin.gif', ':D');
		s = smile(s, 'B-)',  'cool.gif', 'B-)');
		s = smile(s, 'b-)',  'cool.gif', 'b-)');
		s = smile(s, ':x',  'mad.gif', ':x');
		s = smile(s, ':|',  'mellow.gif', ':|');
		s = smile(s, ':p',  'tongue.gif', ':p');
		s = smile(s, ':P',  'tongue.gif', ':P');
		s = smile(s, ':(',  'sad.gif', ':(');
		s = smile(s, ':)',  'smile.gif', ':)');
		s = smile(s, ':o',  'ohmy.gif', ':o');
		s = smile(s, ':O',  'ohmy.gif', ':O');
		s = smile(s, ';)',  'wink.gif', ';)');
		s = smile(s, ':XD',  'XD.gif', ':XD');
		s = smile(s, '(XD)',  'XD.gif', '(XD)');
		return s;
	},

	//links: function(s) {
	//	return s.replace(/((https|http|ftp|ed2k):\/\/[\S]+)/gi, '$1');

	//},

	request: function(s) {
		return s.replace(/((|dj request|artist request|song request|request|SR:|)+)/gi, '<span style="color: red; font-weight:bold;">$1</span>');
	},
	
	truncate: function(clearAll) {
		var truncateTo = clearAll ? 0 : this.prefs.truncate;
		var posts = $('div.ys-post').size();
		if (posts <= truncateTo) return;

		if (this.prefs.inverse)
			$('div.ys-post:gt(' + truncateTo + ')').remove();
		else
			$('div.ys-post:lt(' + (posts - truncateTo) + ')').remove();
	},

	reload: function(everything) {
		var self = this;

		if (everything) {
			this.ajax(function(json) { 
				$('#yshout').html(''); 
				clearInterval(this.refreshTimer);
				clearInterval(this.floodTimer);
				this.initialLoad(json); 
			}, { 
				reqType: 'init',
				yPath: this.options.yPath,
				log: this.options.log
			});
		} else {
			this.ajax(function(json) { this.truncate(true); this.updates(json); },{
				reqType: 'reload'
			});
		}
	},

	error: function(str) {
		alert(str);
	},

	json: function(parse) {
		this.d('In json: ' + parse);
		var json = eval('(' + parse + ')');
		if (!this.checkError.json) return json;
	},

	checkError: function(json) {
		if (!json.yError) return false;

		this.d('Error: ' + json.yError);
		return true;
	},

	pageSize: function() {
		var de = document.documentElement;
		var w = window.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
		var h = window.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
		
		return [w, h];
	},

	scrollTop: function (){
		var scrollTop;
		
		if (window.pageYOffset)	return window.pageYOffset;
			
		if (document.documentElement && document.documentElement.scrollTop)
		 return document.documentElement.scrollTop;
		 
		if (document.body) return document.body.scrollTop;
	},

	ajax: function(callback, pars) {
		pars = Object.extend({
			reqFor: 'shout'
		}, pars);

		var self = this;

		$.post(this.options.yPath + 'index.php', pars, function(parse) {
				if (parse.length > 1)
					callback.apply(self, [self.json(parse)]);
				else
					callback.apply(self);
		});
	},

	d: function(message) {
		$('#debug').css('display', 'block').prepend('<p>' + message + '</p>');
	}
};