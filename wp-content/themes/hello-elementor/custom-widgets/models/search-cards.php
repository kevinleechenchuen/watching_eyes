<?php
    include(get_template_directory() . '/custom-widgets/utils/currencyChecker.php');
    function renderSearchResultsWithFilter($data, $filter, $page)
    {
        if(count($data) == 0)
        {
            echo "<div class='search-results-no-result'>no results found!</div>";
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
            <h4>PRICES RANGE</h4>
        </div>      
        <div class='slider'>
            <div class='progress'></div>
        </div>
        <div class='range-input'>
            <input type='range' class='range-min' min='0' max='1000000' value='0' step='1000'>
            <input type='range' class='range-max' min='0' max='1000000' value='1000000' step='1000'>
        </div>
         <div class='price-input'>
            <div class='field'>
                <input type='number' id='search-filter-price-range-min' class='input-min' value='0' >
            </div>
            <div class='field'>
                <input type='number' id='search-filter-price-range-max' class='input-max' value='1000000' >
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
        <div class='filter-button-container'>
            <button class='button-main-1' onclick=\"clearFilter()\" style='margin-bottom: 10px; width:100%;'>CLEAR ALL FILTERS</button>
            <button class='button-main-2' onclick=\"applyFilter()\" style='width:100%;'>APPLY FILTER</button>
        </div>
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
        echo "<div class='search-pagination'>Page: ";
        $domain = $_SERVER['HTTP_HOST'];
        $paginateUrl = "https://" . $domain . $_SERVER['REQUEST_URI'];
        $paginateUrl = str_replace("&pg=$page","",$paginateUrl);

        if($page <= 3)
        {
            for ($i = 1; $i <= 7; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 
        } else {
            for ($i = $page-3; $i <= $page; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 

            for ($i = $page+1; $i <= $page+3; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 
        }
        echo "</div>";
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
        <div class='filter-button-container'>
            <button class='button-main-1' onclick=\"clearAuctionFilter()\" style='margin-bottom: 10px; width:100%;'>CLEAR ALL FILTERS</button>
            <button class='button-main-2' onclick=\"applyAuctionFilter()\" style='width:100%;'>APPLY FILTER</button>
        </div>
        ";
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {
            renderAuctionCard($item);
        }   
        echo "</div>";
        echo "</div>";
    }

    function renderAuctionWatchesResultsWithFilter($data, $page)
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
            <h4>ESTIMATE PRICE</h4>
        </div>  
        <div class='filter-section-container'>
            <label class='filter-auction-label' for='auctionStartDate'>Custom</label>
            <div class='filter-auction-watches-range'>
                <input type='text' id='estMinPriceFilter' class='filterSearch price-range' placeholder='Low'>
                to
                <input type='text' id='estMaxPriceFilter' class='filterSearch price-range' placeholder='High'>
            </div>
        </div>
        ";
        echo " <div class='filter-divider'></div>";
        echo "
        <div class='filter-title'>
            <h4>CURRENT BID</h4>
        </div>  
        <div class='filter-section-container'>
            <label class='filter-auction-label'>Custom</label>
            <div class='filter-auction-watches-range'>
                <input type='text' id='minCurrentBidFilter' class='filterSearch price-range' placeholder='Low'>
                to
                <input type='text' id='maxCurrentBidFilter' class='filterSearch price-range' placeholder='High'>
            </div>
        </div>
        ";
        echo " <div class='filter-divider'></div>";
        echo " <div class='filter-title'>
            <h4>STATUS</h4>
            </div>  
            <div class='filter-section-container'>
                <div class=\"modelCheckbox\" value='Open Bid'><label class=\"container\">Open Bid
                    <input type=\"checkbox\" id='Open Bid' name=\"auctionStatusCheckbox\" value='Open Bid'>
                    <span class=\"checkmark\"></span>
                </label></div>
                <div class=\"modelCheckbox\" value='Closed Bid'><label class=\"container\">Closed Bid
                    <input type=\"checkbox\" id='Closed Bid' name=\"auctionStatusCheckbox\" value='Closed Bid'>
                    <span class=\"checkmark\"></span>
                </label></div>
                <div class=\"modelCheckbox\" value='Unsold'><label class=\"container\">Unsold
                    <input type=\"checkbox\" id='Unsold' name=\"auctionStatusCheckbox\" value='Unsold'>
                    <span class=\"checkmark\"></span>
                </label></div>
            </div>  
            ";
        echo "  
        <div class='filter-button-container'>
            <button class='button-main-1' onclick=\"clearAuctionWatchFilter()\" style='margin-bottom: 10px; width:100%;'>CLEAR ALL FILTERS</button>
            <button class='button-main-2' onclick=\"applyAuctionWatchFilter()\" style='width:100%;'>APPLY FILTER</button>
        </div>
        ";
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {
            renderAuctionWatchesCard($item);
        }   
        echo "</div>";
        echo "</div>";
        echo "<div class='search-pagination'>Page: ";
        $domain = $_SERVER['HTTP_HOST'];
        $paginateUrl = "https://" . $domain . $_SERVER['REQUEST_URI'];
        $paginateUrl = str_replace("&pg=$page","",$paginateUrl);
        if($page <= 3)
        {
            for ($i = 1; $i <= 7; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 
        } else {
            for ($i = $page-3; $i <= $page; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 

            for ($i = $page+1; $i <= $page+3; $i++) {
                if($i == $page)
                {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number current-page'>$i</a>";
                } else {
                    echo "<a href='$paginateUrl&pg=$i' class='pagination-number'>$i</a>";
                }
            } 
        }
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
        $price = ($item->current_bid == null) ? $item->sold_price : $item->current_bid;
        if($item->source_type != 'Auction') {
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
                                    <h3>
                                        $item->post_title
                                    </h3>
                                </a>
                            </div>
                            <h3 class='item-card-price'>
                                $currency$item->product_price
                            </h3>
                            <h7 class='item-card-source'>
                                $item->original_poster on $item->forum_name
                            </h7>
                        </div>
                </div>
            ";
        } else {
            echo "
                <div class='item-card'>
                        <a href='$item->watch_link' target='_blank'>
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
                                <a href='$item->watch_link' target='_blank'>
                                    <h3>
                                        $item->auction_title
                                    </h3>
                                </a>
                            </div>
                            <h3 class='item-card-price'>
                                $currency$price
                            </h3>
                            <h7 class='item-card-source'>
                                $item->auction_name
                            </h7>
                        </div>
                </div>
            ";
        }   
    }

    function renderAuctionCard($item){
        $startDate    = new DateTime($item->auction_start_date);
        $endDate    = new DateTime($item->auction_end_date);
        $stringStartDate = $startDate->format('d M Y');
        $stringEndDate = $endDate->format('d M Y');

        $cleanAuctionName = encodeURIComponent($item->auction_name);
        $cleanAuctionTitle = encodeURIComponent($item->auction_title);

        $liveAuctionClass = '';
        if($item->auction_type == 'Live Auction')
        {
            $liveAuctionClass = 'live-auction';
        }
        echo "
                <div class='item-card'> 
                    <a href='/auction-watches?auctionStartDate=$stringStartDate&auctionEndDate=$stringEndDate&auctionName=$cleanAuctionName&auctionType=$item->auction_type&auctionTitle=$cleanAuctionTitle'>
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
                            <h3>
                                $item->auction_title
                            </h3>
                        </div>
                    </div>
                    <h7 class='item-card-source'>
                        Start date: $stringStartDate <br>
                        End date: $stringEndDate
                    </h7>
                    <a href='$item->post_link' target='_blank'>
                                <h3>
                                    $item->post_title
                                </h3>
                    </a>
                    <a href='/auction-watches?auctionStartDate=$stringStartDate&auctionEndDate=$stringEndDate&auctionName=$cleanAuctionName&auctionType=$item->auction_type&auctionTitle=$cleanAuctionTitle'>
                        <button class='button-main-1'>BID</button>
                    </a>
            </div>";
    }

    function renderAuctionWatchesCard($item){
        $currency = convertCurrency($item->currency);
        $startDate    = new DateTime($item->auction_start_date);
        $endDate    = new DateTime($item->auction_end_date);
        $stringStartDate = $startDate->format('d M Y');
        $stringEndDate = $endDate->format('d M Y');

        $auctionStatus = '';
        if($item->status == 'Open Bid')
        {
            $auctionStatus = 'open-bid';
        } else if ($item->status == 'Closed Bid') {
            $auctionStatus = 'closed-bid';
        }

        $priceHTML = '';
        if($item->sold_price != null) {
            $priceHTML = "
                        <h7>
                            Sold Price:  
                        </h7>
                        <h5 class='item-card-price auction'>
                             $currency$item->sold_price
                        </h5>";
        } else if($item->current_bid != null) {
            $priceHTML = "
                        <h7>
                            Current Bid:  
                        </h7>
                        <h5 class='item-card-price auction'>
                             $currency$item->current_bid
                        </h5>";
        }
        echo "
                <div class='item-card'> 
                    <a href='$item->watch_link' target='_blank'>
                        <div>
                            <div class='item-card-status $auctionStatus'>$item->status</div>
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
                            <h5>
                                $item->model
                            </h5>
                        </div>
                    </div>
                    <h7 class='item-card-source'>
                        Estimate Pricing: <br>$currency$item->min_estimate_price - $currency$item->max_estimate_price <br>
                        Start date: $stringStartDate
                    </h7>
                    <div class='auction-watches'>
                        $priceHTML
                    </div>
                    <a href='$item->post_link' target='_blank'>
                                <h5>
                                    $item->post_title
                                </h5>
                    </a>
                    <a href='$item->watch_link' target='_blank'>
                        <button class='button-main-1'>PLACE BID</button>
                    </a>
            </div>";
    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }