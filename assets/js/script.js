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


});

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