<?php
    include(get_template_directory() . '/custom-widgets/utils/currencyChecker.php');
    function renderSearchResultsWithFilter($data, $filter)
    {
        if(count($data) == 0)
        {
            echo "<div class='search-results'>no results found!</div>";
            return;
        }

        echo "<div class='search-result-container'>";
        echo "<div id='search-result-filter'>";
        $brandHTML = '';
        $modelHTML = '';
        $sourceHTML = '';
        foreach ($filter->brands as $brand) {
            $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value='$brand'><input type=\"checkbox\" id='$brand' name=\"brandCheckbox\" value='$brand'><label class='filterLabel' for='$brand'>$brand</label></div>";
        }
        foreach ($filter->models as $model) {
            $modelHTML = "$modelHTML<div class=\"modelCheckbox\" value='$model'><input type=\"checkbox\" id='$model' name=\"modelCheckbox\" value='$model'><label class='filterLabel' for='$model'>$model</label></div>";
        }
        foreach ($filter->sources as $source) {
            $sourceHTML = "$sourceHTML<div class=\"sourceCheckbox\" value='$source'><input type=\"checkbox\" id='$source' name=\"sourceCheckbox\" value='$source'><label class='filterLabel' for='$source'>$source</label></div>";
        }
        echo "<h4>BRAND</h4>
            <a href='#' onclick=\"clearSpecificFilter('brandCheckbox');\">CLEAR</a>
            <input type='text' id='brandFilterSearch' placeholder='Enter brand name here...'>
            <div class='filter-section-container'>
                $brandHTML
            </div>";
        echo "<h4>MODEL</h4>
            <a href='#' onclick=\"clearSpecificFilter('modelCheckbox');\">CLEAR</a>
            <input type='text' id='modelFilterSearch' placeholder='Enter model here...'>
            <div class='filter-section-container'>
                $modelHTML
            </div>";
        echo "<h4>SOURCE</h4>
            <a href='#' onclick=\"clearSpecificFilter('sourceCheckbox');\">CLEAR</a>
            <div class='filter-section-container'> 
                $sourceHTML
            </div>";
        echo "  
        <button onclick=\"clearFilter()\">CLEAR ALL FILTERS</button>
        <button onclick=\"applyFilter()\">APPLY FILTER</button>
        ";
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {

            if($item->source_type == 'auction'){
                renderAuctionCard($item);
            } else {
                renderCard($item);
            }
        }
        echo "</div>";
        echo "</div>";
    }

    function renderHorizontalListing($data, $class){
        echo "<div class='home-listing-container $class'>";
        foreach ($data as $item) {
            renderCard($item);
        }
        echo "</div>";

    }

    function renderUpcomingAuction($data){
        echo "<div class='home-listing-container'>";
        foreach ($data as $item) {
            renderAuctionCard($item);
        }
        echo "</div>";

    }

    function renderCard($item){
        $currency = convertCurrency($item->currency);
        echo "
            <div class='item-card'>
                    <a href='$item->post_link' target='_blank'>
                        <div class='item-card-image-container'>
                            <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                        </div>
                    </a>
                    <div class='item-card-desc'>
                        <div class='item-card-desc-brand'>
                            <h6>
                                $item->brand
                            </h6>
                        </div>
                        <div class='item-card-desc-title'>
                            <a href='$item->post_link' target='_blank'>
                                <h5>
                                    $item->post_title
                                </h5>
                            </a>
                        </div>
                        <h5 class='item-card-price'>
                            $currency$item->product_price
                        </h5>
                        <h7 class='item-card-source'>
                            $item->original_poster on $item->forum_name
                        </h7>
                    </div>
            </div>
        ";
    }

    function renderAuctionCard($item){
        echo "
                <div class='item-card'>
                <a href='$item->auction_link' target='_blank'>
                    <div class='item-card-image-container'>
                        <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                    </div>
                    <div class='item-card-desc'>
                        <div class='item-card-desc-brand'>
                            <h6>
                                $item->auction_name
                            </h6>
                        </div>
                        <div class='item-card-desc-title'>
                            <h5>
                                $item->auction_title
                            </h5>
                        </div>
                    </div>
                    <div>
                        <button onclick=\"window.location.href = '$item->auction_link';\">BID</button>
                    </div>
                </a>
            </div>";
    }