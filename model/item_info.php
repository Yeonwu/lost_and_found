<?php if($_GET['page']%2) {?>
{
    "lostItems": [
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "03.png", "href": "1"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "02.png", "href": "2"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "01.png", "href": "3"},
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "04.png", "href": "4"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "05.png", "href": "5"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "06.png", "href": "6"},
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "07.png", "href": "7"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "08.png", "href": "8"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "09.png", "href": "9"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "10.png", "href": "10"},
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "03.png", "href": "1"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "02.png", "href": "2"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "01.png", "href": "3"},
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "04.png", "href": "4"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "05.png", "href": "5"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "06.png", "href": "6"},
        {"title": "hello wolrd!", "dateAgo": "1", "imgName": "07.png", "href": "7"},
        {"title": "hello wolrd!", "dateAgo": "2", "imgName": "08.png", "href": "8"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "09.png", "href": "9"},
        {"title": "hello wolrd!", "dateAgo": "3", "imgName": "10.png", "href": "10"}
    ],
	"page": {
		"num": 10,
		"current": <?php echo $_GET['page'];?>
	}
}
<?php } else { ?>
{
	"lostItems": [
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "03.png", "href": "1"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "02.png", "href": "2"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "01.png", "href": "3"},
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "04.png", "href": "4"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "05.png", "href": "5"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "06.png", "href": "6"},
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "07.png", "href": "7"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "08.png", "href": "8"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "09.png", "href": "9"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "10.png", "href": "10"},
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "03.png", "href": "1"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "02.png", "href": "2"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "01.png", "href": "3"},
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "04.png", "href": "4"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "05.png", "href": "5"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "06.png", "href": "6"},
        {"title": "goodbye wolrd!", "dateAgo": "1", "imgName": "07.png", "href": "7"},
        {"title": "goodbye wolrd!", "dateAgo": "2", "imgName": "08.png", "href": "8"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "09.png", "href": "9"},
        {"title": "goodbye wolrd!", "dateAgo": "3", "imgName": "10.png", "href": "10"}
    ],
	"page": {
		"num": 10,
		"current": <?php echo $_GET['page'];?>
	}
}
<?php } ?>