document.addEventListener( 'DOMContentLoaded', () => {

    const showAuthButton = document.querySelector( '#niloy-show-auth-form' ),
          authContainer = document.querySelector( '#niloy-auth-container' ),
          close = document.querySelector( '#niloy-auth-close' ),
          authForm = document.querySelector( '#niloy-auth-form' ),
          status = authForm.querySelector( '[data-message="status"]' );

    showAuthButton.addEventListener( 'click', (e) => {
        authContainer.classList.add( 'show' );
        showAuthButton.parentElement.classList.add( 'hide' );
    } );

    close.addEventListener( 'click', (e) => {
        authContainer.classList.remove( 'show' );
        showAuthButton.parentElement.classList.remove( 'hide' );
    } );

    authForm.addEventListener( 'submit', e => {

        e.preventDefault();

        // reset the form messages
        resetMessages();

        //  collect all the data
        let data = {
            name: authForm.querySelector( '[name="username"]' ).value,
            password: authForm.querySelector( '[name="password"]' ).value,
            nonce: authForm.querySelector( '[name="niloy-auth"]' ).value
        };

        // validate everything
        if( !data.name || !data.password ) {
            status.innerHTML = "Missing data";
            status.classList.add( 'error' );

            return;

        }

        // ajax http post request
        let url = authForm.dataset.url;
        let params = new URLSearchParams( new FormData( authForm ) );

        authForm.querySelector( '[name="submit"]' ).value = 'Login in...';
        authForm.querySelector( '[name="submit"]' ).disabled = true;

        fetch( url, {
            method: "POST",
            body: params
        } )
        .then( results => results.json() )
        .catch( error => {
            resetMessages();
        } )
        .then( response => {

            resetMessages();

            if( response === 0 || !response.status ) {

                status.innerHTML = response.message;
                status.classList.add( 'error' );

                return;

            }

            status.innerHTML = response.message;
            status.classList.add( 'success' );
            authForm.reset();

            window.location.reload();


        } );

    } );

    function resetMessages(){
        // reset all the mesaages
        status.innerHTML = '';
        status.classList.remove( 'success', 'error' );

        authForm.querySelector( '[name="submit"]' ).value = 'Login';
        authForm.querySelector( '[name="submit"]' ).disabled = false;
    }

} );