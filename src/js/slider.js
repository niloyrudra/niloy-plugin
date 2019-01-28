//  global varials
const sliderView = document.querySelector( '.niloy-slider--view > ul' ),
      sliderViewSlides = document.querySelectorAll( '.niloy-slider--view__slides' ),
      arrowLeft = document.querySelector( '.niloy-slider--arrows__left' ),
      arrowRight = document.querySelector( '.niloy-slider--arrows__right' ),
      sliderLength = sliderViewSlides.length;


//  sliding function
const sliderMe = ( sliderViewItems, isActiveItem ) => {

    // Update the classes
    isActiveItem.classList.remove( 'is-active' );
    sliderViewItems.classList.add( 'is-active' );

    // CSS transform the active slide position
    sliderView.setAttribute( 'style', 'transform:translateX(-' + sliderViewItems.offsetLeft + 'px)' );

}

//  before sliding function
const beforeSliding = (i) => {
    
    let isActiveItem = document.querySelector( '.niloy-slider--view__slides.is-active' ),
        currentItem = Array.from( sliderViewSlides ).indexOf( isActiveItem ) + i,
        nextItem = currentItem + i,
        sliderViewItems = document.querySelector( `.niloy-slider--view__slides:nth-child(${ nextItem })` );

        // If nextItem is bigger than the # of the slides
        if( nextItem > sliderLength ) {
            sliderViewItems = document.querySelector( '.niloy-slider--view__slides:nth-child(1)' );
        }

        // if nectItem is 0
        if( nextItem == 0 ) {
            sliderViewItems = document.querySelector( `.niloy-slider--view__slides:nth-child(${ sliderLength })` );
        }

        // trigger the slider method
        sliderMe( sliderViewItems, isActiveItem );
    
}

//  triggers arrows
arrowRight.addEventListener( 'click', () => beforeSliding(1) );
arrowLeft.addEventListener( 'click', () => beforeSliding(0) );