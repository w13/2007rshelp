// Constructor
function textareaResizer(textarea) {
	if (textareaResizer.htmlstyle == null)
		textareaResizer.htmlstyle = document.getElementsByTagName('html')[0].style;
	
	var ua = navigator.userAgent.toLowerCase(), name;
	switch (true) {
		case ua.indexOf('konqueror') >= 0:
		case ua.indexOf('opera') >= 0:
		case ua.charAt(ua.indexOf('msie') + 5) == 5: // IE5
			return;
			break;
	};
	
	var index = textareaResizer.instances.length;
	textareaResizer.instances[textareaResizer.instances.length] = this;
	
	var handle = document.createElement('span');
	handle.className = 'textarea-handle';
	handle.onmousedown = function(e) { textareaResizer.instances[index].listen(e); };
	handle.onmouseover = function() { this.style.cursor = 'n-resize'; };
	handle.onmouseout = function() { this.style.cursor = 'auto'; };
	handle = textarea.parentNode.insertBefore(handle, textarea.nextSibling);
	handle.middle = Math.ceil(textareaResizer.findHeight(handle) / 2);
	
	this.handle = handle;
	this.textarea = textarea;
	this.index = index;
	this.minHeight = 50;
};

// Static properties
textareaResizer.isResizing = false;
textareaResizer.instances = new Array;
textareaResizer.htmlstyle = null;

// Static methods
textareaResizer.findPosY = function(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
		while (obj.offsetParent) {
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
};
textareaResizer.findHeight = function(element, recalc) {
	if (element.height && recalc != true)
		return element.height;
	else {
		if (element.style.height)
			element.height = parseInt(element.style.height);
		else {
			element.style.height = element.clientHeight + 'px';
			element.height = parseInt(element.style.height);
		};
		return element.height;
	}
};
textareaResizer.pageY = function(e) {
	if (!e.pageY)
		return e.clientY + window.document.documentElement.scrollTop;
	else
		return e.pageY;
};
textareaResizer.addToAll = function() {
	for (var i = 0, textarea; textarea = document.getElementsByTagName('textarea')[i]; i++)
		new textareaResizer(textarea);
	textarea = null;
};

// Methods
textareaResizer.prototype.listen = function(e) {
	var handle = this.handle, index = this.index;
	
	textareaResizer.htmlstyle.cursor = 'n-resize';
	textareaResizer.isResizing = true;
	handle.onmousedown = null;
	handle.onmouseup = function(e) { textareaResizer.instances[index].stopListening(e); };
	window.document.onmouseup = function(e) { textareaResizer.instances[index].stopListening(e); };
	window.document.onmousemove = function(e) { textareaResizer.instances[index].resize(e); };
};
textareaResizer.prototype.resize = function(e) {
	if (!e) var e = window.event;
	e.cancelBubble = true;
	
	var selection = document.selection;
	if (selection)
		selection.clear();
	
	if (textareaResizer.isResizing) {
		var textarea = this.textarea, handle = this.handle, minHeight = this.minHeight;
		
		/* This next statement is:
			* Textarea height +
			* Desired change in height +
			* Half the size of the handle (so the cursor stays in the middle of it) */
		var newHeight = textareaResizer.findHeight(textarea, true) + textareaResizer.pageY(e) - textareaResizer.findPosY(handle) - handle.middle;
		if (newHeight < minHeight)
			newHeight = minHeight;
		
		textarea.style.height = newHeight + 'px';
	};
};
textareaResizer.prototype.stopListening = function(e) {
	var handle = this.handle, index = this.index;
	
	textareaResizer.htmlstyle.cursor = 'auto';
	textareaResizer.isResizing = false;
	window.document.onmousemove = null;
	window.document.onmouseup = null;
	handle.onmouseup = null;
	handle.onmousedown = function(e) { textareaResizer.instances[index].listen(e); };
};