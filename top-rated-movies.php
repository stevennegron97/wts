<?php
//include files
include_once 'includes/config.php';
include_once 'includes/functions.php';

// Latest Update SUB
$topratedmovies = $APIbaseURL . $topratedmovie . $api_key . $language;
if (isset($_GET['page'])) {
    $topratedmovies = $APIbaseURL . $topratedmovie . $api_key . $language . "&page=" . $_GET['page'];
}
//handle errors
$headers = get_headers($topratedmovies);
if (stripos($headers[0], '40') !== false || stripos($headers[0], '50') !== false) {
    include '404.php';
    exit();
}
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);
$ambil = file_get_contents($topratedmovies, false, stream_context_create($arrContextOptions));
$tprtdmvs = json_decode($ambil, true);
/*----meta---*/
$canonical = "top-rated-movies";
$metatitle = 'Top Rated Movies -'.$SiteTitle;
$metadesc = 'Watch and download latest movies and TV Shows for free in HD streaming with multiple language subtitles.';
?>
<?php include_once 'includes/header.php'; ?>
        <div id="container">
            <div class="module">
                <div class="content right full">
                    <h1 class="Featured">Top Rated Movies</h1>
                    <div class="animation-2 items full arch"><?php foreach ($tprtdmvs["results"] as $data) : ?>
                            <article class="item">
                                <div class="poster"><img src="<?php if ($data["poster_path"]) echo "https://image.tmdb.org/t/p/w185".$data["poster_path"]; else echo "/img/noposter.png"; ?>" alt="<?php echo $data["title"]; ?>">
                                    <div class="rating"><i class="fa fa-star"></i> <?php echo Ratingtwo($data["vote_average"]); ?></div>
                                    <div class="mepo"> </div>
                                    <a href="/movies/<?php echo $data["id"]; ?>/<?php echo slugify($data["title"]); ?>">
                                        <div class="see play3"></div>
                                    </a>
                                </div>
                                <div class="data">
                                    <h3><a href="/movies/<?php echo $data["id"]; ?>/<?php echo slugify($data["title"]); ?>"><?php echo $data["title"]; ?></a></h3> <span><?php if ($data["release_date"]) echo $data["release_date"]; else echo "N/A"; ?></span>
                                </div>
                            </article><?php endforeach ?>
                    </div>
                    <div class="pagination">
                        <?php
                        $wrap = "<ul class='pagination'>";
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $nextpage = $current_page + 1;
                        $prevpage = $current_page - 1;

                        if ($current_page >= 2) {
                            $wrap .= "<li class='previous'><a href='?page=$prevpage' data-page='$prevpage'> < </a></li>";
                        }

                        for ($i = $current_page - 1; $i <= $current_page + 4; $i++) {
                            if ($i == 0) {
                                continue;
                            }
                            $active = "";
                            if ($i == $current_page) {
                                $active = "active";
                            }

                            $wrap .= "<li class='$active'><a href='?page=" . $i . "'>" . $i . "</a><li>";
                        }
                        echo $wrap . "<li class='next'><a href='?page=$nextpage' data-page='$nextpage'> > </a></li></ul>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div><!--breadcrumbs-start-->
            <div class="breadcrumb">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li>Top Rated Movies</li>
                </ul>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>