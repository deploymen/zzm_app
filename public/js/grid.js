/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );


var docElem = window.document.documentElement,
	transEndEventNames = {
		'WebkitTransition': 'webkitTransitionEnd',
		'MozTransition': 'transitionend',
		'OTransition': 'oTransitionEnd',
		'msTransition': 'MSTransitionEnd',
		'transition': 'transitionend'
	},
	transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
	support = {
		pointerevents : Modernizr.pointerevents,
		csstransitions : Modernizr.csstransitions,
		csstransforms3d : Modernizr.csstransforms3d
	};

function scrollX() {
	return window.pageXOffset || docElem.scrollLeft; 
}

function scrollY() {
	return window.pageYOffset || docElem.scrollTop;
}

// from http://responsejs.com/labs/dimensions/
function getViewportW() {
	var client = docElem['clientWidth'],
		inner = window['innerWidth'];
	
	if( client < inner )
		return inner;
	else
		return client;
}

function getViewportH() {
	var client = docElem['clientHeight'],
		inner = window['innerHeight'];
	
	if( client < inner )
		return inner;
	else
		return client;
}

function extend( a, b ) {
	for( var key in b ) { 
		if( b.hasOwnProperty( key ) ) {
			a[key] = b[key];
		}
	}
	return a;
}

/**
 * grid3d.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {
	
	'use strict';

	function grid3D( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
  		extend( this.options, options );
  		this._init();
	}

	// any options you might want to configure
	grid3D.prototype.options = {};

	grid3D.prototype._init = function() {
		// grid wrapper
		this.gridWrap = this.el.querySelector( 'div.grid-wrap' );
		// grid element
		this.grid = this.gridWrap.querySelector( 'div.grid' );
		// main grid items
		this.gridItems = [].slice.call( this.grid.children );
		// default sizes for grid items
		this.itemSize = { width : this.gridItems[0].offsetWidth, height : this.gridItems[0].offsetHeight };
		// content
		this.contentEl = this.el.querySelector( 'div.content' );
		// content items
		this.contentItems = [].slice.call( this.contentEl.children );
		// close content cross
		this.close = this.contentEl.querySelector( 'span.close-content' );
		// loading indicator
		this.loader = this.contentEl.querySelector( 'span.loading' );
		// support: support for pointer events, transitions and 3d transforms
		this.support = support.pointerevents && support.csstransitions && support.csstransforms3d;
		// init events
		this._initEvents();
	};

	grid3D.prototype._initEvents = function() {
		var self = this;
		
		// open the content element when clicking on the main grid items
		this.gridItems.forEach( function( item, idx ) {
			item.addEventListener( 'click', function() {
				self._showContent( idx );
			} );
		} );

		// close the content element
		this.close.addEventListener( 'click', function() {
			self._hideContent();
		} );

		if( this.support ) {
			// window resize
			window.addEventListener( 'resize', function() { self._resizeHandler(); } );

			// trick to prevent scrolling when animation is running (opening only)
			// this prevents that the back of the placeholder does not stay positioned in a wrong way
			window.addEventListener( 'scroll', function() {
				if ( self.isAnimating ) {
					window.scrollTo( self.scrollPosition ? self.scrollPosition.x : 0, self.scrollPosition ? self.scrollPosition.y : 0 );
				}
				else {
					self.scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
					// change the grid perspective origin as we scroll the page
					self._scrollHandler();
				}
			});
		}
	};

	// creates placeholder and animates it to fullscreen
	// in the end of the animation the content is shown
	// a loading indicator will appear for 1 second to simulate a loading period
	grid3D.prototype._showContent = function( pos ) {
		if( this.isAnimating ) {
			return false;
		}
		this.isAnimating = true;

		var self = this,
			loadContent = function() {
				// simulating loading...
				setTimeout( function() {
					// hide loader
					classie.removeClass( self.loader, 'show' );
					// in the end of the transition set class "show" to respective content item
					classie.addClass( self.contentItems[ pos ], 'show' );
				}, 1000 );
				// show content area
				classie.addClass( self.contentEl, 'show' );
				// show loader
				classie.addClass( self.loader, 'show' );
				classie.addClass( document.body, 'noscroll' );
				self.isAnimating = false;
			};

		// if no support just load the content (simple fallback - no animation at all)
		if( !this.support ) {
			loadContent();
			return false;
		}

		var currentItem = this.gridItems[ pos ],
			itemContent = currentItem.innerHTML;
		
		// create the placeholder
		this.placeholder = this._createPlaceholder(itemContent );
		
		// set the top and left of the placeholder to the top and left of the clicked grid item (relative to the grid)
		this.placeholder.style.left = currentItem.offsetLeft + 'px';
		this.placeholder.style.top = currentItem.offsetTop + 'px';
		
		// append placeholder to the grid
		this.grid.appendChild( this.placeholder );

		// and animate it
		var animFn = function() {
			// give class "active" to current grid item (hides it)
			classie.addClass( currentItem, 'active' );
			// add class "view-full" to the grid-wrap
			classie.addClass( self.gridWrap, 'view-full' );
			// set width/height/left/top of placeholder
			self._resizePlaceholder();
			var onEndTransitionFn = function( ev ) {
				if( ev.propertyName.indexOf( 'transform' ) === -1 ) return false;
				this.removeEventListener( transEndEventName, onEndTransitionFn );
				loadContent();
			};
			self.placeholder.addEventListener( transEndEventName, onEndTransitionFn );
		};

		setTimeout( animFn, 25 );
	};

	grid3D.prototype._hideContent = function() {
		var self = this,
			contentItem = this.el.querySelector( 'div.content > .show' ),
			currentItem = this.gridItems[ this.contentItems.indexOf( contentItem ) ];
		
		classie.removeClass( contentItem, 'show' );
		classie.removeClass( this.contentEl, 'show' );
		// without the timeout there seems to be some problem in firefox
		setTimeout( function() { classie.removeClass( document.body, 'noscroll' ); }, 25 );
		// that's it for no support..
		if( !this.support ) return false;

		classie.removeClass( this.gridWrap, 'view-full' );

		// reset placeholder style values
		this.placeholder.style.left = currentItem.offsetLeft + 'px';
		this.placeholder.style.top = currentItem.offsetTop + 'px';
		this.placeholder.style.width = this.itemSize.width + 'px';
		this.placeholder.style.height = this.itemSize.height + 'px';

		var onEndPlaceholderTransFn = function( ev ) {
			this.removeEventListener( transEndEventName, onEndPlaceholderTransFn );
			// remove placeholder from grid
			self.placeholder.parentNode.removeChild( self.placeholder );
			// show grid item again
			classie.removeClass( currentItem, 'active' );
		};
		this.placeholder.addEventListener( transEndEventName, onEndPlaceholderTransFn );
	}

	// function to create the placeholder
	/*
	<div class="placeholder">
		<div class="front">[content]</div>
		<div class="back"></div>
	</div>
	*/
	grid3D.prototype._createPlaceholder = function( content ) {
		var front = document.createElement( 'div' );
		front.className = 'front';
		front.innerHTML = content;
		var back = document.createElement( 'div' );
		back.className = 'back';
		back.innerHTML = '&nbsp;';
		var placeholder = document.createElement( 'div' );
		placeholder.className = 'placeholder';
		placeholder.appendChild( front );
		placeholder.appendChild( back );
		return placeholder;
	};

	grid3D.prototype._scrollHandler = function() {
		var self = this;
		if( !this.didScroll ) {
			this.didScroll = true;
			setTimeout( function() { self._scrollPage(); }, 60 );
		}
	};

	// changes the grid perspective origin as we scroll the page
	grid3D.prototype._scrollPage = function() {
		var perspY = scrollY() + getViewportH() / 2;
		this.gridWrap.style.WebkitPerspectiveOrigin = '50% ' + perspY + 'px';
		this.gridWrap.style.MozPerspectiveOrigin = '50% ' + perspY + 'px';
		this.gridWrap.style.perspectiveOrigin = '50% ' + perspY + 'px';
		this.didScroll = false;
	};

	grid3D.prototype._resizeHandler = function() {
		var self = this;
		function delayed() {
			self._resizePlaceholder();
			self._scrollPage();
			self._resizeTimeout = null;
		}
		if ( this._resizeTimeout ) {
			clearTimeout( this._resizeTimeout );
		}
		this._resizeTimeout = setTimeout( delayed, 50 );
	}

	grid3D.prototype._resizePlaceholder = function() {
		// need to recalculate all these values as the size of the window changes
		this.itemSize = { width : this.gridItems[0].offsetWidth, height : this.gridItems[0].offsetHeight };
		if( this.placeholder ) {
			// set the placeholders top to "0 - grid offsetTop" and left to "0 - grid offsetLeft"
			this.placeholder.style.left = Number( -1 * ( this.grid.offsetLeft - scrollX() ) ) + 'px';
			this.placeholder.style.top = Number( -1 * ( this.grid.offsetTop - scrollY() ) ) + 'px';
			// set the placeholders width to windows width and height to windows height
			this.placeholder.style.width = getViewportW() + 'px';
			this.placeholder.style.height = getViewportH() + 'px';
		}
	}

	// add to global namespace
	window.grid3D = grid3D;

})( window );