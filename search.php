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

                        <div class="searchBarContainer">

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

            $pageLimit = 20;  //variable for passing limit of URLs to display on one page.

            $numResults = $resultsProvider->getNumResults($keyword);

            echo "<p class='resultsCount'>$numResults results found</p>";

            echo $resultsProvider->getResultsHtml($page, $pageLimit, $keyword);
            ?>

        </div>

        <div class="paginationContainer"> <!-- new class for paging -->
        
            <div class="pageButtons"> <!--sub-class for all the imgs and funcitons on them-->


                <div class="pageNumberContainer">
                    <img src="assets/images/pageStart.png">
                </div>

                <?php // shows the images with the page number on the search page.

                $currentPage = 1;
                $pagesLeft = 10;

                while($pagesLeft != 0)
                {
                    echo "<div class='pageNumberContainer'>
                                <img src='assets/images/page.png'> 
                                <span class='pageNumber'>$currentPage</span>                    
                            </div>"; // displays the images, along with page number(span class=pageNumber shows the current page number)

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

</body>
</html>