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

function toggle (elem) {
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
	elem.style.height = '0px';
	elem.style.overflow = 'hidden';
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
			hide(elem);
			elem.$animating = false;
		},time);
	}
}

function toggleSlide (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	if (getStyle(elem, 'display') == 'none') {
		slideDown(elem, time);
	}else{
		slideUp(elem, time);
	};
}

function fadeOut (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	var time = time || 1000;
	elem.$animating = true;
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

function fadeIn (elem, time) {
	if (elem.$animating && elem.style.display != 'none') return false;
	var time = time || 1000;
	elem.$animating = true;
	setOpacity(elem, 100);
	show(elem);
	for ( var i = 100; i > 0; i-- ) {
		(function() {
			var pos = i;
			setTimeout(function() {
				setOpacity(elem, pos)
			}, ( 100 - pos + 1) * (time/100));
		})();
	}
	setTimeout(function() {
		elem.$animating = false;
		elem.$hidden = true;
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