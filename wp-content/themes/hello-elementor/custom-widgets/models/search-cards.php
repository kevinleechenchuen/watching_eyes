<?php
    include(get_template_directory() . '/custom-widgets/utils/currencyChecker.php');
    function renderSearchResultsWithFilter($data, $filter, $page, $maxPage, $minPrice, $maxPrice)
    {
        if(count($data) == 0)
        {
            echo "<div class='search-results-no-result'>no results found!</div>";
            return;
        }

        echo "<div class='search-result-container'>";
        echo "<div class='filter-sticky'>";
        echo "<div id='search-result-filter'>";
        $brandHTML = '';
        $modelHTML = '';
        $sourceHTML = '';

        global $wpdb;
        $brands = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watching_brands", OBJECT );

        foreach ($brands as $brand) {
            $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value='$brand->Name'><label class=\"container\">$brand->Name
                <input type=\"checkbox\" id='$brand->Name' name=\"brandCheckbox\" value='$brand->Name' onclick='filterCheckboxOnClick(\"brand\", \"$brand->Name\")'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }

        if($_GET['brand'] != ''){
            $q_brand = explode(",", $_GET['brand']);
            $selectedBrands = array_map( 'esc_sql', (array) $q_brand );
            $selectedBrands_string = "'" . implode( "', '", $selectedBrands ) . "'";

            $models = $wpdb->get_results( "SELECT m.Name FROM {$wpdb->prefix}watching_models m
            INNER JOIN {$wpdb->prefix}watching_brands b
            ON b.ID = m.BrandID
            WHERE b.Name IN ($selectedBrands_string)
            ORDER BY m.Name ASC", OBJECT );
        } else {
            $models = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watching_models ORDER BY Name ASC", OBJECT );
        }

        foreach ($models as $model) {
            $modelHTML = "$modelHTML<div class=\"modelCheckbox\" value='$model->Name'><label class=\"container\">$model->Name
                <input type=\"checkbox\" id='$model->Name' name=\"modelCheckbox\" value='$model->Name' onclick='filterCheckboxOnClick(\"model\", \"$model->Name\")'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }
        foreach ($filter->sources as $source) {
            $sourceHTML = "$sourceHTML<div class=\"sourceCheckbox\" value='$source'><label class=\"container\">$source
                <input type=\"checkbox\" id='$source' name=\"sourceCheckbox\" value='$source' onclick='filterCheckboxOnClick(\"source\", \"$source\")'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }
        $sortByHTML = "<option value='' selected='selected'>Latest</option>";
        foreach ($auctionList as $auction) {
            $sortByHTML = "$sortByHTML<option value='$auction'>$auction</option>";
        }
        echo "
        <div class='filter-title' style='margin-bottom: 5px;'>
            <h4>SORT BY</h4>
        </div>      
        <div style='margin-bottom: 10px;'>
            <select name='filter-sortby' id='filter-sortby'>
                <option value='created_at' selected='selected'>Latest created</option>
                <option value='updated_at'>Latest updated</option>
                <option value='price_asc'>Price lowest to highest</option>
                <option value='price_desc'>Price highest to lowest</option>
            </select>
        </div>
        <div class='filter-divider'></div>
        <div class='filter-title' style='margin-bottom: 5px;'>
            <h4>ACCESSORIES</h4>
        </div>      
        <div style='margin-bottom: 10px;'>
            <select name='filter-acc' id='filter-acc'>
                <option value='false' selected='selected'>ALL</option>
                <option value='true'>Only Accessory</option>
            </select>
        </div>
        <div class='filter-divider'></div>
        <div class='filter-title' style='margin-bottom: 5px;'>
            <h4>Last Updated</h4>
        </div>      
        <div style='margin-bottom: 10px;'>
            <select name='filter-last-updated' id='filter-last-updated'>
                <option value='m_6' selected='selected'>6 Months</option>
                <option value='m_3'>3 Months</option>
                <option value='m_1'>1 Months</option>
                <option value='w_1'>1 Week</option>
            </select>
        </div>
        <div class='filter-divider'></div>
        ";
    //     echo "<div class='filter-title'>
    //     <h4>PRICES RANGE</h4>
    // </div>      
    //  <div class='price-input'>
    //     <div class='field'>
    //         <input type='number' id='search-filter-price-range-min' class='input-min' pattern='[0-9]+' value='$minPrice'>
    //     </div>
    //     <div style='display: flex;'>
    //         <p style='margin-bottom: 0px !important; align-self: center;'>~</p>
    //     </div>
    //     <div class='field'>
    //         <input type='number' id='search-filter-price-range-max' class='input-max' pattern='[0-9]+' value='$maxPrice'>
    //     </div>
    // </div>
    // <div>
    //     <button class='button-main-2' onclick=\"applyFilter()\" style='width:100%;'>APPLY FILTER</button>
    // </div>
    // <div class='filter-divider'></div>";
        echo " <div class='filter-title'>
                <h4>BRAND</h4>
                <i class='clickable material-icons filter-brand-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible brand'>
                <input type='text' id='brandFilterSearch' class='filterSearch' placeholder='Enter brand name here...'>
                <div class='filter-section-container'>
                    $brandHTML
                </div>
            </div>";
        echo " <div class='filter-divider'></div>";
        if($_GET['brand'] != ''){
            echo "<div class='filter-title'>
                <h4>MODEL</h4>
                <i class='clickable material-icons filter-model-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible model'>
                <input type='text' id='modelFilterSearch' class='filterSearch' placeholder='Enter model here...'>
                <div class='filter-section-container'>
                    $modelHTML
                </div>
            </div>";
        echo " <div class='filter-divider'></div>";
        } 
        echo "<div class='filter-title'>
                <h4>SOURCE</h4>
                <i class='clickable material-icons filter-source-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible source'>
                <div class='filter-section-container'> 
                    $sourceHTML
                </div>
            </div>";
        // echo "  
        // <div class='filter-button-container'>
        //     <button class='button-main-1' onclick=\"clearFilter()\" style='margin-bottom: 10px; width:100%;'>CLEAR ALL FILTERS</button>
        //     <button class='button-main-2' onclick=\"applyFilter()\" style='width:100%;'>APPLY FILTER</button>
        // </div>
        // ";
        echo "</div>";
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {

            if(strcasecmp($item->source_type, 'Auction') == 0){
                renderAuctionWatchesCard($item);
            } else {
                renderCard($item);
            }
        }   
        echo "</div>";
        echo "</div>";
        echo "<div class='search-pagination'>Page: ";
        $domain = $_SERVER['HTTP_HOST'];
        $paginateUrl = "https://" . $domain . $_SERVER['REQUEST_URI'];
        $paginateUrl = str_replace("pg=$page","",$paginateUrl);

        if($page <= 3)
        {
            for ($i = 1; $i <= $maxPage && $i <= 7; $i++) {
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

            for ($i = $page+1; $i <= $page+3 && $i < $maxPage; $i++) {
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
        echo "<div class='filter-sticky'>";
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
        echo "</div>";
        echo "<div class='search-results'>";
        foreach ($data as $item) {
            renderAuctionCard($item);
        }   
        echo "</div>";
        echo "</div>";
    }

    function renderAuctionWatchesResultsWithFilter($data, $page, $maxPage)
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
        echo "<div class='filter-sticky'>";
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
            for ($i = 1; $i <= $maxPage && $i <= 7; $i++) {
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

            for ($i = $page+1; $i <= $page+3 && $i < $maxPage; $i++) {
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

        $sourceText = '';
        $formattedCreatedAt = date_format(date_create($item->created_at), 'd/m/y');
        if(strcasecmp($item->source_type, 'Retail') == 0){
            $sourceText = $item->original_poster;
        } else {
            $sourceText = "$item->original_poster on $item->forum_name $formattedCreatedAt";
            $formattedUpdatedAt = date_format(date_create($item->last_post_date), 'd/m/y');
            $updatedAtText = "Last post date: $formattedUpdatedAt";
        }

        $formattedPrice = number_format((int)$item->product_price);
        $itemStatusHTML = "";
        if(strcasecmp($item->source_type, 'Forum') != 0) {
            $itemStatusHTML = "<div class='item-card-status'>$item->status</div>";
        }
        if(strcasecmp($item->source_type, 'Auction') != 0) {
            echo "
                <div class='item-card'>
                        <a href='$item->post_link' target='_blank'>
                            <div>
                                $itemStatusHTML
                                <div class='item-card-image-container'>
                                    <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                                </div>
                            </div>
                        </a>
                        <div class='item-card-desc'>
                            <div class='item-card-desc-title'>
                                <a href='$item->post_link' target='_blank'>
                                    <h3>
                                        $item->post_title
                                    </h3>
                                </a>
                            </div>
                            <div class='item-card-desc-brand'>
                                <h6>
                                    $item->brand
                                </h6>
                                <h7 class='item-card-model'>
                                    $item->model
                                </h7>
                            </div>
                            <h3 class='item-card-price'>
                                $currency$formattedPrice
                            </h3>
                            <h7 class='item-card-source'>
                                $updatedAtText
                            </h7>
                            <h7 class='item-card-source'>
                                $sourceText
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
                                $currency$formattedPrice
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

        $buttonText = ($endDate < new DateTime()) ? 'CLOSED' : 'BID';
        echo "
                <div class='item-card auction'> 
                    <div class='item-card-desc'>
                        <div class='item-card-desc-brand'>
                            <h6>
                                $item->auction_name
                            </h6>
                        </div>
                        <div class='item-card-desc-title'>
                            <a href='/auction-watches?auctionStartDate=$stringStartDate&auctionEndDate=$stringEndDate&auctionName=$cleanAuctionName&auctionType=$item->auction_type&auctionTitle=$cleanAuctionTitle'>
                                <h3>
                                    $item->auction_title
                                </h3>
                            </a>
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
                        <button class='button-main-1'>$buttonText</button>
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

        $formattedSoldPrice = number_format((int)$item->sold_price);
        $formattedCurrentBid = number_format((int)$item->current_bid);
        $formattedMinEst = number_format((int)$item->min_estimate_price);
        $formattedMaxEst = number_format((int)$item->max_estimate_price);
        $priceHTML = '';
        if($item->sold_price != null) {
            $priceHTML = "
                        <h7>
                            Sold Price:  
                        </h7>
                        <h5 class='item-card-price auction'>
                             $currency$formattedSoldPrice
                        </h5>";
        } else if($item->current_bid != null) {
            $priceHTML = "
                        <h7>
                            Current Bid:  
                        </h7>
                        <h5 class='item-card-price auction'>
                             $currency$formattedCurrentBid
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
                            <h3>
                                $item->model
                            </h3>
                        </div>
                    </div>
                    <h7 class='item-card-source'>
                        Estimate Pricing: <br>$currency$formattedMinEst - $currency$formattedMaxEst <br>
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