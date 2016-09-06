ready(function(){
    console.log(document.readyState);
    isempty();
    // remove focus style on clicked elements
    unfocus.style('box-shadow: none !important;');

    setTimeout(function(){
        isempty();

    },500);
});
