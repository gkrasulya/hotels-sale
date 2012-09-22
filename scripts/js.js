function id (name, elem) {
	return (elem || document).getElementById(name);
}

function tag (name, elem) {
	return (elem || document).getElementsByTagName(name);
}

function stopDefault (e) {
	if ( e && e.preventDefault ) {
		e.preventDefault();
	}else{
		window.event.returnValue = false;
	}
	return false;
}

function next (elem) {
	if (elem == null) return null
	do {
		elem = elem.nextSibling;
	} while ( elem && elem.nodeType != 1 );
	return elem;
}

function prev (elem) {
	if (elem == null) return null
	do {
		elem = elem.previousSibling;
	} while ( elem && elem.nodeType != 1 );
	return elem;
}

function first (elem) {
	if (elem == null) return null
	elem = elem.firstChild;
	return elem && elem.nodeType != 1 ? next (elem) : elem;
}

function last (elem) {
	if (elem == null) return null
	elem = elem.lastChild;
	return elem && elem.nodeType != 1 ? prev (elem) : elem;
}

function stopDefault (e) {
	if ( e && e.preventDefault ) {
		e.preventDefault();
	}else{
		window.event.returnValue = false;
	}
	return false;
}

function addEvent (element, type, handler) {
	if (!handler.$$guid) handler.$$guid = addEvent.guid++;
	
	if (!element.events) element.events = {};
	
	var handlers = element.events[type];
	if (!handlers) {
		handlers = element.events[type] = {};
		
		if (element["on" + type]) {
			handlers[0] = element["on" + type];
		}
	}
	
	handlers[handler.$$guid] = handler;
	
	element["on" + type] = handleEvent;
}

addEvent.guid = 1;

function removeEvent (element, type, handler) {
	if (element.events && element.events[type]) {
		delete element.events[type][handler.$$guid];
	}
}

function handleEvent (event) {
	var returnValue = true;
	
	event = event || fixEvent(window.event);
	
	var handlers = this.events[event.type];
	
	for ( var i in handlers ) {
		this.$$handleEvent = handlers[i];
		if (this.$$handleEvent(event) === false) {
			returnValue = false;
		}
	}
	
	return returnValue;
}

function fixEvent (event) {
	event.preventDefault = fixEvent.preventDefault;
	event.stopPropagation = fixEvent.stopPropagation;
	return event;
}

fixEvent.preventDefault = function() {
	this.returnValue = false;
};

fixEvent.stopPropagation = function() {
	this.cancelBubble = true;
};

function getStyle (elem, name) {
	if (elem.style[name]) {
		return elem.style[name];

	}else if (elem.currentStyle) {
		return elem.currentStyle;

	}else if (document.defaultView && document.defaultView.getgetComputedStyle) {
		name = name.replace(/([A-Z])/g, "-$1");
		name = name.toLowerCase();
		var s = document.defaultView.getComputedStyle(elem,"");
		return s && s.getPropertyValue(name);
		
	}else{
		return null;
	}
}

function pageX (elem) {
	return elem.offsetParent ? elem.offsetLeft + pageX(elem.offsetParent) : elem.offsetLeft;
}

function pageY (elem) {
	return elem.offsetParent ? elem.offsetTop + pageY(elem.offsetParent) : elem.offsetTop;
}

function parentX (elem) {
	return elem.offsetParent == elem.parentNode ? elem.offsetLeft : pageX(elem) - pageX(elem.parentNode);
}

function parentY (elem) {
	return elem.offsetParent == elem.parentNode ? elem.offsetTop : pageY(elem) - pageY(elem.parentNode);
}

function posX (elem) {	
	elem.style.left = elem.style.left || 0;
	return parseInt(getStyle(elem, 'left'));
}

function posY (elem) {
	elem.style.top = elem.style.top || 0;
	return parseInt(getStyle(elem, 'top'));
}

function setX (elem,value) {
	elem.style.left = value + 'px';
}

function setY (elem,value) {
	elem.style.top = value + 'px';
}

function setSize (elem, x, y) {
	elem.style.width = x + 'px';
	elem.style.height = y + 'px';
}

function addX (elem,value) {
	setX(elem, (posX(elem) + value));
}

function addY (elem,value) {
	setY(elem, (posY(elem) + value));
}

function getWidth (elem) {
	return elem.style.width;
}

function getHeight (elem) {
	return elem.style.height;
}

function fullHeight (elem) {
	if (getStyle(elem, 'display') != 'none' ) {
		return elem.offsetHeight || getHeight(elem);
	};
	
	var	old = resetCSS(elem, {
		display: '',
		visibility: 'hidden',
		position: 'absolute'
	});
	
	var h = elem.clientHeight || getHeight(elem);
	restoreCSS(elem, old);
	return h;
}

function fullWidth (elem) {
	if (getStyle(elem, 'display') != 'none' ) {
		return elem.offsetWidth || getWidth(elem);
	};
	
	var old = resetCSS (elem, {
		display: '',
		visibility: 'hidden',
		position: 'absolute'
	});
	
	var h = elem.clientWidth || getWidth(elem);
	restoreCSS(elem, old);
	return h;
}

function windowWidth () {
	var de = document.documentElement;
	return self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
}

function windowHeight () {
	var de = document.documentElement;
	return self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
}

function resetCSS (elem, props) {
	old = {};
	
	for ( var i in props ) {
		old[i] = elem.style[i];
		elem.style[i] = props[i];
	}
	return old;
}

function restoreCSS (elem, props) {
	for ( var i in props ) {
		elem.style[i] = props[i];
	}
}

function show (elem) {
	elem.style.display = elem.$oldDisplay || '';
}

function hide (elem) {
	display = getStyle(elem, 'display');
	if (display != 'none') {
		elem.$oldDisplay = display;
		elem.style.display = 'none';
	};
}

function toggle(elem) {
	if (typeof elem == "string") elem = id(elem);
	display = getStyle(elem, 'display');
	if (display != 'none') {
		elem.$oldDisplay = display;
		elem.style.display = 'none';
	}else{
		elem.style.display = elem.$oldDisplay || '';
	}
}

function setOpacity (elem, level) {
	if (elem.filters) {
		elem.style.filter = 'alpha(opacity=' + level + ')';
	}else{
		elem.style.opacity = level / 100;
	}
}

function slideDown (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	var h = elem.$fullHeight || fullHeight(elem);
	var time = time || 1000;
	elem.$animating = true;
	elem.$overflow = elem.style.overflow;
	elem.style.overflow = 'hidden';
	elem.style.height = '0px';
	show(elem);
	for ( var i = 0; i < 100; i++ ) {
		(function() {
			var pos = i;
			setTimeout(function() {
				elem.style.height = (( pos / 100 ) * h ) + 'px'; 
			},( pos + 1 ) * (time/100));
		})();
		setTimeout(function(){
			elem.$animating = false;
			elem.style.overflow = elem.$overflow;
		},time);
	}
}

function slideUp (elem, time) {
	if (elem.$animating && elem.style.display == 'none' ) return false;
	var h = elem.$fullHeight = fullHeight(elem);
	var time = time || 1000;
	elem.$animating = true;
	elem.style.height = fullHeight(elem) + 'px';
	elem.style.overflow = 'hidden';
	for ( var i = 100; i >= 0; i-- ) {
		(function() {
			var pos = i;
			setTimeout(function() {
				elem.style.height = (( pos / 100 ) * h ) + 'px'; 
			},( 100 - pos + 1 ) * (time/100));
		})();
		setTimeout(function(){
			elem.style.display = 'none';
			elem.$animating = false;
		},time);
	}
}

function toggleSlide (elem, time) {
	if (elem.$animating) return false;
	if (getStyle(elem, 'display') == 'none') {
		slideDown(elem, time);
	}else{
		slideUp(elem, time);
	};
}

function fadeOut (elem, time) {
	var time = time || 1000;
	elem.$animating = true;
	elem.style.display = 'block';
	setOpacity(elem, 0);
	for ( var i = 0; i <= 100; i++ ) {
		(function() {
			var pos = i;
			setTimeout(function() {
				setOpacity(elem, pos);
			}, ( pos + 1 ) * (time/100));
		})();
	}
	setTimeout(function() {
		elem.$animating = false;
		elem.$hidden = false;
	}, time);
}

function fadeIn (elem, time, start) {
	if (elem.$animating && elem.style.display != 'none') return false;
	var time = time || 1000;
	var start = start || 100;
	elem.$animating = true;
	elem.$display = elem.style.display;
	setOpacity(elem, start);
	elem.style.display = 'block';
	for ( var i = start; i > 0; i-- ) {
		(function() {
			var pos = i;
			setTimeout(function() {
				setOpacity(elem, pos)
			}, ( start - pos + 1) * (time/start));
		})();
	}
	setTimeout(function() {
		elem.$animating = false;
		elem.$hidden = true;
		elem.style.display = 'none';
	}, time);
}

function toggleFade (elem, time) {
	if (elem.$animating) return false;
	if ((elem.$hidden && elem.$hidden == false) || !elem.$hidden) {
		fadeIn(elem, time);
	}else{
		fadeOut(elem, time);
	}
}

function slideFadeIn (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	fadeIn(elem, time);
	slideUp(elem, time);
}

function slideFadeOut (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	fadeOut(elem, time);
	slideDown(elem, time);
}

function toggleSlideFade (elem, time) {
	if (elem.style.display != 'none' ) {
		slideFadeIn(elem, time);
	}else{
		slideFadeOut(elem, time);
	}
}

function getMouseX (e) {
	e = e || window.event;
	return e.pageX || e.clientX + document.body.scrollLeft;
}

function getMouseY (e) {
	e = e ||window.event;
	return e.pageY || e.clientY + document.body.scrollTop;
}
			
function move(elem, xCoord, yCoord, time) {
	if (elem.style.position=='') elem.style.position = 'relative';
	var xCoord = xCoord || posX(elem);
	var yCoord = yCoord || posY(elem);
	var time = time || 1000; 
	for (var i = 0; i < 100; i++) {  
		(function(){
			var pos = i; 
			var x = posX(elem) + (xCoord-posX(elem)) * pos / 100;
			var y = posY(elem) + (yCoord-posY(elem)) * pos / 100;
			setTimeout(function(){ 
				setX(elem, x);
				setY(elem, y); 
			}, pos * (time/100)) 
		})(); 
	}
}

function resize (elem, xCoord, yCoord, time) {
	var xCoord = xCoord || fullWidth(elem);
	var yCoord = yCoord || fullHeight(elem);
	var time = time || 1000;
	for ( var i = 0; i <= 100; i++) {
		(function() {
			var pos = i;
			setTimeout(function() {
				elem.style.width = (fullWidth(elem)+((xCoord-fullWidth(elem))*pos)/100) + 'px';	
				elem.style.height = (fullHeight(elem)+((xCoord-fullHeight(elem))*pos)/100) + 'px';	
			}, pos* (time/100));
		})();
	}
}

function centerize (elem, xPos, yPos) {
	xPos = xPos || (windowWidth()-fullWidth(elem))/2;
	yPos = yPos || (windowHeight()-fullHeight(elem))/2;
	if (elem.style.position == '') elem.style.position = 'relative';
	setX(elem, xPos);
	setY(elem, yPos);
}

function slowCenterize (elem, xCoord, yCoord, time) {
	var xCoord = (windowWidth()-xCoord)/2 || (windowWidth()-fullWidth(elem))/2;
	var yCoord = (windowHeight()-yCoord)/2 || (windowHeight()-fullHeight(elem))/2;
	move(elem, xCoord, yCoord, time);
}

function animaResizeCenterize (elem, xCoord, yCoord, time, xPos, yPos) {
	if (elem.style.position=='') elem.style.position = 'relative';
	var xSize = xCoord || fullWidth(elem);
	var ySize = yCoord || fullHeight(elem);
	var xCoord = xPos || ((windowWidth()-xCoord)/2 || (windowWidth()-fullWidth(elem))/2);
	var yCoord = yPos || ((windowHeight()-yCoord)/2 || (windowHeight()-fullHeight(elem))/2);
	var time = time || 1000; 
	for (var i = 0; i < 100; i++) {  
		(function(){
			var pos = i; 
			var x = posX(elem) + (xCoord-posX(elem)) * pos / 100;
			var y = posY(elem) + (yCoord-posY(elem)) * pos / 100;
			var width = parseInt((fullWidth(elem)+((xSize-fullWidth(elem))*pos)/100)) + 'px';
			var height = parseInt((fullHeight(elem)+((ySize-fullHeight(elem))*pos)/100)) + 'px';
			setTimeout(function(){
				setX(elem, x);
				setY(elem, y); 
				elem.style.width = width;	
				elem.style.height = height;	
			}, pos * (time/100)) 
		})(); 
	}
}

// FOR GALLERY

function closeImg () {
	fadeIn(id('img_div'),300);
	fadeIn(id('overlay'),300,30);
	setTimeout(function() {
		setSize(id('img_div'),43,12);
		hide(id('img'));
		show(id('loading'));
		id('img').style.display = 'none';	
	},300);
	
}

function hideOld () {
	fadeIn(id('img'),300);
	setTimeout (function() {
		(navigator.userAgent.indexOf('MSIE 6.0') >= 0) ? 
			animaResizeCenterize(id('img_div'),43,8,300, null, pageY(id('gallery')) - 100) :
			animaResizeCenterize(id('img_div'),43,8,300);
		setTimeout(function() {
			show(id('loading'));
		},300);
	},300);
}

function changeImg (elem) {
	if (elem == null) return null;
	fadeIn(id('img'),300);
	id('control').style.display = 'none';
	id('close').style.display = 'none';
	setTimeout (function() {
		if (navigator.userAgent.indexOf('MSIE 6.0') >= 0) {
			animaResizeCenterize(id('img_div'),43,8,300, null, pageY(id('gallery')) - 100);
		}else{
			animaResizeCenterize(id('img_div'),43,8,300);
		}
		setTimeout(function() {
			show(id('loading'));
			setTimeout(function() {
				id('img').src = elem.href;
				current = elem;
			},300);
		},300);
	},300);
}

function showImg (elem) {
	setOpacity (id('overlay'), 30);
	setSize(id('img_div'),43,12);
	id('img').style.display = 'none';
	id('overlay').style.display = 'block';
	if (navigator.userAgent.indexOf('MSIE 6.0') >= 0) {
		id('overlay').style.position = 'absolute';
		id('overlay').style.height = pageY(id('footer')) + 'px';
		id('overlay').style.width = '1280px';
	}
	fadeOut(id('img_div'), 300);
	id('img_div').style.position = navigator.userAgent.indexOf('MSIE 6.0') >= 0 ? 'absolute' : 'fixed';
	if (navigator.userAgent.indexOf('MSIE 6.0') >= 0) {
		centerize(id('img_div'), null, pageY(id('gallery')) - id('img').height/2 - 100);
	}else{
		centerize(id('img_div'));
	}
	id('loading').style.display = 'block';
	id('img').src = elem.href;
	current = elem;
};
		
function loaded () {
	hide(id('loading'));
	id('img').style.visibility = 'hidden';
	id('img').style.display = 'block';
	(navigator.userAgent.indexOf('MSIE 6.0') >= 0) ?
		animaResizeCenterize(id('img_div'),(id('img').width + 6),(id('img').height + 50), 300, null, pageY(id('gallery')) - id('img').height/2 - 100) :
		animaResizeCenterize(id('img_div'),(id('img').width + 6),(id('img').height + 43), 300);
	if (navigator.userAgent.indexOf('MSIE 6.0') >= 0) {
		id('foto_title').style.top = '2px';
		id('prev').style.float = 'left';
		id('prev').style.right = '30px';
		id('prev').style.top = '-3px';
		id('prev').style.position = 'relative';
		id('next').style.float = 'right';
		id('next').style.left = '30px';
		id('next').style.top = '-3px';
		id('next').style.position = 'relative';
		id('overlay').style.position = 'absolute';
		id('overlay').style.height = pageY(id('footer')) + 'px';
		id('overlay').style.width = '1280px';
	}
	setTimeout(function() {
		hide(id('img'));
		id('img').style.visibility = 'visible';
		fadeOut(id('img'), 300);
		setSize(id('foto_title'), (id('img').width/100*98), 35);
	},301);
	// (first(prev(current.parentNode)) == undefined || first(prev(current.parentNode)) == null) ? id('prev').style.display = 'none' : id('prev').style.display = 'block';
	// (first(next(current.parentNode)) == undefined || first(prev(current.parentNode)) == null) ? id('next').style.display = 'none' : id('next').style.display = 'block';
	id('control').style.zIndex = '200'
	id('control').style.position = 'absolute';
}

function showControl () {
	id('control').style.display = 'block';
	id('close').style.display = 'block';
}

function hideControl () {
	id('control').style.display = 'none';
	id('close').style.display = 'none';
}