/* eslint-disable no-unused-vars */
const copyToClipboard = ( e ) => {
	const textToCopy = e.parentNode.nextElementSibling.textContent;

	document.querySelector( '.copy-toast' ).classList.add( 'toast-fade-in' );

	const el = document.createElement( `textarea` );
	el.value = textToCopy;
	el.setAttribute( `readonly`, `` );
	el.style.position = `absolute`;
	el.style.left = `-9999px`;
	document.body.appendChild( el );
	el.select();
	document.execCommand( `copy` );
	document.body.removeChild( el );

	setTimeout( () => {
		document.querySelector( '.copy-toast' ).classList.remove( 'toast-fade-in' );
	}, 3200 );
};

