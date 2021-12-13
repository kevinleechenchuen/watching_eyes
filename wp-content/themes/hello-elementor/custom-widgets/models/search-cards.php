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
            $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value='$brand'><label class=\"container\">$brand
                <input type=\"checkbox\" id='$brand' name=\"brandCheckbox\" value='$brand'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }
        foreach ($filter->models as $model) {
            $modelHTML = "$modelHTML<div class=\"modelCheckbox\" value='$model'><label class=\"container\">$model
                <input type=\"checkbox\" id='$model' name=\"modelCheckbox\" value='$model'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }
        foreach ($filter->sources as $source) {
            $sourceHTML = "$sourceHTML<div class=\"sourceCheckbox\" value='$source'><label class=\"container\">$source
                <input type=\"checkbox\" id='$source' name=\"sourceCheckbox\" value='$source'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }
        echo "
        <div class='filter-title'>
            <h4>AUCTION TYPE</h4>
        </div>      
        <div class='slider'>
            <div class='progress'></div>
        </div>
        <div class='range-input'>
            <input type='range' class='range-min' min='0' max='100000' value='0' step='500'>
            <input type='range' class='range-max' min='0' max='100000' value='100000' step='500'>
        </div>
         <div class='price-input'>
            <div class='field'>
                <input type='number' class='input-min' value='0' >
            </div>
            <div class='field'>
                <input type='number' class='input-max' value='100000' >
            </div>
        </div>
        <script src='/wp-content/themes/hello-elementor/assets/js/slider.js'></script>";
        echo " <div class='filter-divider'></div>";
        echo " <div class='filter-title'>
                <h4>BRAND</h4>
                <h4><a href='#' onclick=\"clearSpecificFilter('brandCheckbox');\">Clear</a></h4>
            </div>
            <input type='text' id='brandFilterSearch' class='filterSearch' placeholder='Enter brand name here...'>
            <div class='filter-section-container'>
                $brandHTML
            </div>";
        echo " <div class='filter-divider'></div>";
        echo "<div class='filter-title'>
                <h4>MODEL</h4>
                <h4><a href='#' onclick=\"clearSpecificFilter('modelCheckbox');\">Clear</a></h4>
            </div>
            <input type='text' id='modelFilterSearch' class='filterSearch' placeholder='Enter model here...'>
            <div class='filter-section-container'>
                $modelHTML
            </div>";
        echo " <div class='filter-divider'></div>";
        echo "<div class='filter-title'>
                <h4 style='font-size:24px;'>Source</h4>
                <h4><a href='#' onclick=\"clearSpecificFilter('sourceCheckbox');\">Clear</a></h4>
            </div>
            <div class='filter-section-container'> 
                $sourceHTML
            </div>";
        echo "  
            <button onclick=\"clearFilter()\" style='margin-bottom: 20px;'>CLEAR ALL FILTERS</button>
            <button onclick=\"applyFilter()\" style='background-color: #2255FB;'>APPLY FILTER</button>
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
        echo "<div class='search-pagination'>Page 1 2 3 4 5 6 7 8 9 ...</div>";
    }

    function renderAuctionResultsWithFilter($data, $filter)
    {
        $auctionList=array();
        foreach ($data as $item) {
            if (!in_array($item->auction_name, $auctionList)) {
                array_push($auctionList,$item->auction_name);
            }
        }

        $auctionListHTML = "<option value='' selected='selected'>Please Select</option>";
        foreach ($auctionList as $auction) {
            $auctionListHTML = "$auctionListHTML<option value='$auction'>$auction</option>";
        }
        if(count($data) == 0)
        {
            echo "<div class='search-results'>no results found!</div>";
            return;
        }

        echo "<div class='search-result-container'>";
        echo "<div id='search-result-filter' class='auction'>";  
        echo "
        <div class='filter-title'>
            <h4>AUCTION TYPE</h4>
        </div>  
        <div class='filter-section-container'>
            <div class=\"modelCheckbox\" value='Online Auction'><label class=\"container\">Online Auction
                <input type=\"checkbox\" id='Online Auction' name=\"auctionTypeCheckbox\" value='Online Auction'>
                <span class=\"checkmark\"></span>
            </label></div>
            <div class=\"modelCheckbox\" value='Live Auction'><label class=\"container\">Live Auction
                <input type=\"checkbox\" id='Live Auction' name=\"auctionTypeCheckbox\" value='Live Auction'>
                <span class=\"checkmark\"></span>
            </label></div>
        </div>
        ";
        echo " <div class='filter-divider'></div>";
        echo " <div class='filter-title'>
                <h4>SEARCH</h4>
                </div>
                <div class='filter-section-container'>
                    <label class='filter-auction-label' for='auctionEndDate'>Auction name</label>
                    <select name='filter-auction-name' id='filter-auction-name'>
                        $auctionListHTML
                    </select>
                </div>   
                <div class='filter-section-container'>
                    <label class='filter-auction-label' for='auctionStartDate'>Start Date</label>
                    <input type='date' class='datePicker' id='auctionStartDate' name='auctionStartDate'>
                </div>
                <div class='filter-section-container'>
                    <label class='filter-auction-label' for='auctionEndDate'>End date</label>
                    <input type='date' class='datePicker' id='auctionEndDate' name='auctionEndDate'>
                </div>    
            ";
        echo "  
            <button onclick=\"clearAuctionFilter()\" style='margin-bottom: 20px;'>CLEAR ALL FILTERS</button>
            <button onclick=\"applyAuctionFilter()\" style='background-color: #2255FB;'>APPLY FILTER</button>
        ";
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {
            renderAuctionCard($item);
        }   
        echo "</div>";
        echo "</div>";
        echo "<div class='search-pagination'>Page 1 2 3 4 5 6 7 8 9 ...</div>";
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
                        <div>
                            <div class='item-card-status'>$item->status</div>
                            <div class='item-card-image-container'>
                                <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                            </div>
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
        $startDate    = new DateTime($item->auction_start_date);
        $endDate    = new DateTime($item->auction_end_date);
        $stringStartDate = $startDate->format('d M Y');
        $stringEndDate = $endDate->format('d M Y');

        $liveAuctionClass = '';
        if($item->auction_type == 'Live Auction')
        {
            $liveAuctionClass = 'live-auction';
        }
        echo "
                <div class='item-card'> 
                    <a href='$item->auction_link' target='_blank'>
                        <div>
                            <div class='item-card-status $liveAuctionClass'>$item->auction_type</div>
                            <div class='item-card-image-container'>
                                <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                            </div>
                        </div>
                    </a>
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
                    <h7 class='item-card-source'>
                        Start date: $stringStartDate <br>
                        End date: $stringEndDate
                    </h7>
                    <a href='$item->post_link' target='_blank'>
                                <h5>
                                    $item->post_title
                                </h5>
                    </a>
                    <button onclick=\"window.location.href = '$item->auction_link';\">BID</button>
            </div>";
    }