( function( $ ) {

    var h2s = $( 'body' ).find('h2,h3');
    h2s.each( function (){
        let header = $( this );
        var link = header.text().replace(/([^A-Za-z0-9[\]{}_.:-])\s?/g, "-").replace(/-$/, "");
        header.innerHTML = '\n\t\t<a href="#'
        .concat(link.toLowerCase(), '" id="')
        .concat(link.toLowerCase(), '" class="bsf-changelog-anchors">\n\t\t\t<i class="dashicons dashicons-paperclip"></i>\n\t\t\t')
        .concat(header.text(), "\n\t\t</a>\n\t");

        header.html(header.innerHTML);
       
    });

} )( jQuery )