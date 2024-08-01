<?php
class DomDocumentParser {

	private $doc;

	public function __construct($url) {

		$options = array(
			'http'=>array('method'=>"GET", 'header'=>"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3\r\n")
			);
			
		// $options = array(
		// 	'http'=>array('method'=>"GET", 'header'=>"User-Agent: doodleBot/0.1\n")
		// 	);
	
		$context = stream_context_create($options);

		$this->doc = new DomDocument();

		$html = @file_get_contents($url, false, $context);
        if($html === FALSE) {
            echo "Failed to retrieve content from $url";
            return;
        }

        @$this->doc->loadHTML($html);
		//@$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getlinks() {
		return $this->doc->getElementsByTagName("a");
	}

	public function getTitleTags() {
		return $this->doc->getElementsByTagName("title");
	}

	public function getMetaTags() {
		return $this->doc->getElementsByTagName("meta");
	}

	public function getImages() {
		return $this->doc->getElementsByTagName("img");
	}

}
?>