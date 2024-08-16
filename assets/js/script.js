var timer;

$(document).ready(function() {

    //click event for the URL title being displayed
	$(".result").on("click", function() { //reference to the result function that contains the URL (title) being displayed that is clickable
		
        //getting the URL : 
		var url = $(this).attr("href");  // refers to the 'href' attribute of the URL in class=result, and gets it.
		
        //getting the ID : 
		var id = $(this).attr("data-linkId"); // refers to the custom attribute 'data-linkId' of the class = result.

        if(!id)
        {
            alert("data-linkId attribute not found.");
        }

        increaseLinkClicks(id, url); // calling the function   

		return false; // stops the URL from executing normal behaviour, like going to the URL clicked.
	});

    var grid = $(".imageResults");

    grid.on("layoutComplete", function() {
        $(".gridItem img").css("visibility", "visible");//this makes it so that as soon as the layout is finished, the visibility of images becomes visible, before it remains hidden
    });

    grid.masonry({
        itemSelector: ".gridItem",
        columnWidth: 220,
        gutter: 6,
        transitionTimer: '0.2s',
        isInitLayout: false //we have done this so that we can load images dynamically using js and not show them if they dont work.
    });


});

function loadImage(src, className)//function called in js of imageResultsProvider.php for masonry layout
{
    
    var image = $("<img>"); //this is a Jquery 'image' Object

    image.on("load", function() {
        $("." + className + " a").append(image); //we put it under the 'a' attribute of class=image$count.
        
        clearTimeout(timer);//built-in js function, makes it so that the masonry code isnt called again and again

        timer = setTimeout(function() {
            $(".imageResults").masonry();//this fixes the issue of first search being broken
        }, 500);//500 milliseconds wait
        
        
    });//does this function if the image loads successfully. 

    image.on("error", function() {

        $("." + className).remove();//removes any empty element from the page based on the passed class - className

        $.post("ajax/setBroken.php", {src: src});//AJAX call to a file - setBroken.php, to set broken = 1 for urls.

    });//updates the value of "broken" in the Images database, and doesnt display it ever again.

    image.attr("src", src);//sets the src attribute of page-> <img src="  sets here   ">



}

//funciton to get the clicks with 2 parameters, linkId for knowing which link's clicks to increase, and the URL as we are returning false, so now we also need to actually go to the URL clicked.
function increaseLinkClicks(linkId, url) {

    $.post("ajax/updateLinkCount.php",{linkId: linkId})// passing the id to updateLinkCount.php AJAX file
    .done(function(result) { //this contians the output from the updateLinkCount.php file, whatever it may be (like the echo statement or the URL)
        if(result != "")
        {
            alert(result); //if the else statement of the ajax file ran, this runs then.
            return;
        } //mostly, there will be no errors, so the 'result var' might be empty here

        window.location.href = url; // this takes us to the URL after updating the clicks value.
        
    }); //following the upper line still

}