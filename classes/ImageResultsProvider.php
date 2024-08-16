<?php
class ImageResultsProvider {

    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function getNumResults($term) {

        $query = $this->con->prepare("SELECT COUNT(*) as total
                                        FROM images 
                                        WHERE (title LIKE :term
                                        OR alt LIKE :term)
                                        AND broken=0"); //gets the images which are not broken

        $searchTerm = "%" . $term . "%";
        $query->bindParam(":term", $searchTerm);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row["total"];

    }

    public function getResultsHtml($page, $pageSize, $term) {

        $fromLimit = ($page - 1) * $pageSize;

        $query = $this->con->prepare("SELECT *
                                        FROM images 
                                        WHERE (title LIKE :term
                                        OR alt LIKE :term)
                                        AND broken=0
                                        ORDER BY  clicks DESC
                                        LIMIT :fromLimit, :pageSize"); //this gets the images that matched

        $searchTerm = "%" . $term . "%";
        $query->bindParam(":term", $searchTerm);
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT); // telling that it is an INT variable
        $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
        $query->execute();

        $resultsHtml = "<div class='imageResults'>"; //image results instead of siteResults

        $count = 0;//setting this for distinguishing count for each image, as we are having a unique class along with gridItem
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {

            $count++;

            $id = $row["id"];
            $imageUrl = $row["imageUrl"];
            $siteUrl = $row["siteUrl"];
            $title = $row["title"];
            $alt = $row["alt"];

            //this is for showing the info when we hover over an image.

            if($title)
            {
                $displayText = $title;
            }
            else if($alt)
            {
                $displayText = $alt;
            }
            else
            {
                $displayText = $imageUrl;//if there is no title or alt of the image, then display its url
            }
            //here, the class=gridItem is the class being used for the Masonry Layout call, to arrange all images
            //we inject js here so that we can do masonry layout successfully.
            //the document.ready executes when the doc is ready to execute it.
            //we are calling a function made in script.js called loadImage, and using escape characters to use double quotes for the input, withput ending the actual string code.
            // this class becomes -> gridItem image1, then gridItem image2, etc etc for every image so on.
            //we also pass the class name as a variable to the loadImage funciton
            //we can now append the image to this class as we have passed one as a prameter
            $resultsHtml .= "<div class='gridItem image$count'> 

                                <a href='$imageUrl' data-fancybox data-siteurl='$siteUrl' data-caption='$displayText'> 
                                    
                                    <script>
                                    $(document).ready(function() {
                                        loadImage(\"$imageUrl\", \"image$count\");
                                    });

                                    </script>

                                    <span class='details'>$displayText</span>
                                </a>

                            </div>"; //this gets the images to display on the page, the <span> gets the info to display that we fetched in the $displayText variable.

        }

        $resultsHtml .= "</div>";

        return $resultsHtml;

    }

}



?>