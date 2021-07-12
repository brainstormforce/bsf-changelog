function addAnchorLink( heading ) {
    var link = heading.innerText;
    var linkToLowerCase = link.toLowerCase().replace(/\s+/g, '-').replace(/[&\/\\#,^!+()$~%.\[\]'":*?;-_<>{}@‘’”“|]/g, '-');
    heading.innerHTML = '\n\t\t<a href="#'
        .concat( linkToLowerCase, '" id="' )
        .concat( linkToLowerCase, '" class="bsf-changelog-anchors">\n\t\t\t<i class="dashicons dashicons-paperclip"></i>\n\t\t\t' )
        .concat( heading.innerHTML, '\n\t\t</a>\n\t' );
}

function bsfChangelogScrollToView() {
    var hash = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
    if ( "" == hash ) return;
    element = document.querySelector(hash);
    if ( null === element ) return;
    element.scrollIntoView({ behavior: "smooth", block: "start" });
}

var headingTag3 = Array.from(document.querySelectorAll( "#content h3" ));
headingTag3.forEach( function ( h3 ) {
    return addAnchorLink( h3 );
});

hash = window.location.hash;
bsfChangelogScrollToView( hash );