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
        
        <div class="paginationContainer">



        </div>



	</div>

</body>
</html>