<?php
include("config.php");
include("classes/SiteResultsProvider.php");

    if(isset($_GET["keyword"]))
    {
        $keyword = $_GET["keyword"];
    }
    else
    {
        exit("You must enter a search term");
    }

    if(isset($_GET["type"]))
    {
        $type = $_GET["type"];
    }
    else
    {
        $type="sites";
    }

    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Doodle</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> <!--Jquery inclusion for use (CDN)-->
</head>
<body>


	<div class="wrapper">

        <div class="header">

            <div class="headerContent">

                <div class="logoContainer">
                    <a href="index.php">
                    <img src="assets/images/Logo.png">
                    </a>
                </div>

                <div class="searchContainer">

                    <form action="search.php" method="GET">

                        <div class="searchBarContainer"> <!--this is the form that gets the keyword and also the 'type' now.-->

                            <input type="hidden" name="type" value="<?php echo $type; ?>"><!--gets the 'type' to pass to the URL.-->

                            <input class="searchBox" type="text" name="keyword" value="<?php echo $keyword; ?>">
                            <button class="searchButton">
                                <img src="assets/images/icons/search.png">
                            </button>

                        </div>


                    </form>



                </div>
                

            </div>

            <div class="tabsContainer">

                <ul class="tabList">

                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?keyword=$keyword&type=sites"; ?>'>
                        Sites
                        </a>
                    </li>

                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?keyword=$keyword&type=images"; ?>'>
                        Images
                        </a>
                    </li>

                </ul>

            </div>



        </div>
		
        <div class="mainResultsSection">

            <?php
            $resultsProvider = new SiteResultsProvider($con);

            $pageSize = 20;  //variable for passing limit of URLs to display on one page.

            $numResults = $resultsProvider->getNumResults($keyword);

            echo "<p class='resultsCount'>$numResults results found</p>";

            echo $resultsProvider->getResultsHtml($page, $pageSize, $keyword);
            ?>

        </div>

        <div class="paginationContainer"> <!-- new class for paging -->
        
            <div class="pageButtons"> <!--sub-class for all the imgs and funcitons on them-->


                <div class="pageNumberContainer">
                    <img src="assets/images/pageStart.png">
                </div>

                <?php // shows the images with the page number on the search page.

                $pagesToShow = 10;
                $numPages = ceil($numResults / $pageSize);//this calculates the total pages we would need to have accord=ding to the numebr of URLs found, and gives the GINT value (to avoid decimals)
                $pagesLeft = min($pagesToShow, $numPages); // to see how many pages to show, as we could also have less than 10 pages

                $currentPage = $page - floor($pagesToShow / 2); //this variable will help us to keep some pags on either side of the current page btton below.

                if($currentPage < 1)
                {
                    $currentPage = 1; // this makes it so that if the current page was less than floor value, then we cant show '0', so default to 1.
                }

                if($currentPage + $pagesLeft > $numPages + 1)
                {
                    $currentPage = $numPages + 1 - $pagesLeft;//this handles the edge case of 10 links not being displayed
                }

                while($pagesLeft != 0 && $currentPage <= $numPages)
                {

                    if($currentPage == $page)
                    {
                        echo "<div class='pageNumberContainer'>
                                <img src='assets/images/pageSelected.png'> 
                                <span class='pageNumber'>$currentPage</span>                    
                            </div>"; //this also makes it so that the current page we are on is not clickable, while the otehrs will be
                            // displays the red image of page, along with page number(span class=pageNumber shows the current page number)
                    }
                    else 
                    {
                        echo "<div class='pageNumberContainer'>
                                <a href='search.php?keyword=$keyword&type=$type&page=$currentPage'>
                                    <img src='assets/images/page.png'> 
                                    <span class='pageNumber'>$currentPage</span>  
                                </a>                  
                            </div>"; //this displays the images with page numebr, along with it being clickable to go to that page
                            //the <a> links the image and the number to the page link we create
                            // displays the images, along with page number(span class=pageNumber shows the current page number)
                    }

                    

                    $currentPage++;
                    $pagesLeft--;
                }


                ?>

                <div class="pageNumberContainer">
                    <img src="assets/images/pageEnd.png">
                </div>


            </div>

        </div>



	</div>
    <script type="text/javascript" src="assets/js/script.js"></script><!--including the js file at end as the page loads first, then js shld run-->
</body>
</html>