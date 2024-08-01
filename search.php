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

                            <input class="searchBox" type="text" name="keyword">
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

            $numResults = $resultsProvider->getNumResults($keyword);

            echo "<p class='resultsCount'>$numResults results found</p>";

            echo $resultsProvider->getResultsHtml(1, 20, $keyword);
            ?>

        </div>



	</div>

</body>
</html>