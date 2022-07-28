<?php
    include(get_template_directory() . '/custom-widgets/utils/currencyChecker.php');
    function renderSearchResultsWithFilter($data, $filter, $page, $maxPage, $minPrice, $maxPrice, $sourceType)
    {
        $current_user = wp_get_current_user();
        if(count($data) == 0)
        {
            echo "<div class='search-results-no-result'>No results found!</div>";
            echo "<div style='display:flex; justify-content:center;'>
                <button class='button-main-2' onclick=\"history.back()\">Back</button>
            </div>";
            return;
        }
        echo "<div class='search-filter-mobile'>
            <button class='button-main-3' onclick=\"toggleMobileFilter()\">FILTER & SORT</button>  
        </div>";
        echo "<div class='item-card-desc-title'>
            <h2>Filters</h2>
        </div>";

        echo "<div class='search-result-container'>";
        echo "<div class='filter-sticky mobile-hide'>";
        echo "<div id='search-result-filter'>";
        $brandHTML = '';
        $modelHTML = '';
        $sourceHTML = '';

        echo "<div id='search-result-filter-mobile-header'>
            <div class='filter-mobile-title'>
                <h4>FILTER & SORT</h4>
                <i class='clickable material-icons search-result-filter-mobile-close'>close</i>
            </div>
        </div>
        ";

        // global $wpdb;
        // $brands = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watching_brands", OBJECT );

        // foreach ($brands as $brand) {
        //     $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value='$brand->Name'><label class=\"container\">$brand->Name
        //         <input type=\"checkbox\" id='$brand->Name' name=\"brandCheckbox\" value='$brand->Name' onclick='filterCheckboxOnClick(\"brand\", \"$brand->Name\")'>
        //         <span class=\"checkmark\"></span>
        //     </label></div>";
        // }

        foreach ($filter->brands as $brand) {
            $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value=\"$brand\"><label class=\"container\">
                <p>$brand</p>
                <input type=\"checkbox\" id=\"$brand\" name=\"brandCheckbox\" value=\"$brand\" onclick='filterCheckboxOnClick(\"brand\", \"$brand\")'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }

       

        // if($_GET['brand'] != ''){
        //     $q_brand = explode(",", $_GET['brand']);
        //     $selectedBrands = array_map( 'esc_sql', (array) $q_brand );
        //     $selectedBrands_string = "'" . implode( "', '", $selectedBrands ) . "'";

        //     $models = $wpdb->get_results( "SELECT m.Name FROM {$wpdb->prefix}watching_models m
        //     INNER JOIN {$wpdb->prefix}watching_brands b
        //     ON b.ID = m.BrandID
        //     WHERE b.Name IN ($selectedBrands_string)
        //     ORDER BY m.Name ASC", OBJECT );
        // } else {
        //     $models = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}watching_models ORDER BY Name ASC", OBJECT );
        // }

        // foreach ($models as $model) {
        //     $modelHTML = "$modelHTML<div class=\"modelCheckbox\" value='$model->Name'><label class=\"container\">
        //         <p>$model->Name</p>
        //         <input type=\"checkbox\" id='$model->Name' name=\"modelCheckbox\" value='$model->Name' onclick='filterCheckboxOnClick(\"model\", \"$model->Name\")'>
        //         <span class=\"checkmark\"></span>
        //     </label></div>";
        // }
        foreach ($filter->sources as $source) {
            $sourceHTML = "$sourceHTML<div class=\"sourceCheckbox\" value='$source'><label class=\"container\">
                <p>$source</p>
                <input type=\"checkbox\" id='$source' name=\"sourceCheckbox\" value='$source' onclick='filterCheckboxOnClick(\"source\", \"$source\")'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }


        if ($sourceType == 'Auction') {
            $sortOptions = "<option value='price_asc'>Price lowest to highest</option>
            <option value='price_desc'>Price highest to lowest</option>";
        } else {
            $sortOptions = "<option value='created_at' selected='selected'>Latest entry</option>
            <option value='updated_at'>Latest updated</option>
            <option value='price_asc'>Price lowest to highest</option>
            <option value='price_desc'>Price highest to lowest</option>";
        }

        echo "
        <div class='filter-title' style='margin-bottom: 5px;'>
            <h4>SORT BY</h4>
            <i class='clickable material-icons filter-expandable filter-sort-expandable'>&#xE5CE;</i>
        </div>      
        <div class='filter-collapsible sort'>
            <select name='filter-sortby' id='filter-sortby'>
                $sortOptions
            </select>
        </div>
        <div class='filter-divider'></div>";
        // echo "<div class='filter-title' style='margin-bottom: 5px;'>
        //     <h4>LAST UPDATED</h4>
        //     <i class='clickable material-icons filter-expandable filter-last-updated-expandable'>&#xE5CE;</i>
        // </div>      
        // <div class='filter-collapsible last-updated'>
        //     <select name='filter-last-updated' id='filter-last-updated'>
        //         <option value='m_6' selected='selected'>6 Months</option>
        //         <option value='m_3'>3 Months</option>
        //         <option value='m_1'>1 Months</option>
        //         <option value='w_1'>1 Week</option>
        //     </select>
        // </div>
        // <div class='filter-divider'></div>
        // ";
        echo " <div class='filter-title'>
            <h4>BRAND</h4>
            <i class='clickable material-icons filter-expandable filter-brand-expandable'>&#xE5CE;</i>
        </div>
        <div class='filter-collapsible brand'>
            <input type='text' id='brandFilterSearch' class='filterSearch' placeholder='Enter brand name here...'>
            <div class='filter-section-container'>
                $brandHTML
            </div>
        </div>
        <div class='filter-divider'></div>";
        // if($_GET['brand'] != ''){
        //     echo "<div class='filter-title'>
        //         <h4>MODEL</h4>
        //         <i class='clickable material-icons filter-expandable filter-model-expandable'>&#xE5CE;</i>
        //     </div>
        //     <div class='filter-collapsible model'>
        //         <input type='text' id='modelFilterSearch' class='filterSearch' placeholder='Enter model here...'>
        //         <div class='filter-section-container'>
        //             $modelHTML
        //         </div>
        //     </div>
        //     <div class='filter-divider'></div>";
        // }
        echo "<div class='filter-title'>
                <h4>SOURCE</h4>
                <i class='clickable material-icons filter-expandable filter-source-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible source'>
                <div class='filter-section-container'> 
                    $sourceHTML
                </div>
            </div>
            <div class='filter-divider'></div>";

        if ($sourceType == 'Forum') {
            echo " <div class='filter-title' style='margin-bottom: 5px;'>
                <h4>ACCESSORIES</h4>
                <i class='clickable material-icons filter-expandable filter-acc-expandable'>&#xE5CE;</i>
            </div>      
            <div class='filter-collapsible acc'>
                <select name='filter-acc' id='filter-acc'>
                    <option value='false' selected='selected'>All</option>
                    <option value='true'>Only Accessory</option>
                </select>
            </div>
            <div class='filter-divider'></div>";
        }

        if ($sourceType == 'Retail' || $sourceType == 'Auction') {
            $statusHTML = "";
            foreach ($filter->status as $status) {
                $statusHTML = "$statusHTML<div class=\"statusCheckbox\" value='$status'>
                    <label class=\"container\">
                        <p>$status</p>
                        <input type=\"checkbox\" id='$status' name=\"statusCheckbox\" value='$status'>
                        <span class=\"checkmark\"></span>
                    </label>
                </div>";
            }

            echo " <div class='filter-title'>
                    <h4>STATUS</h4>
                    <i class='clickable material-icons filter-expandable filter-status-expandable'>&#xE5CE;</i>
                </div>
                <div class='filter-collapsible status'>
                    <div class='filter-section-container'>
                        $statusHTML
                    </div>
                    <div>
                        <button class='button-main-2' onclick=\"applyFilter()\" style='width:100%;'>APPLY FILTER</button>
                    </div>
                </div>
                <div class='filter-divider'></div>";
        }

        echo " <div class='filter-title'>
                <h4>CURRENCY</h4>
                <i class='clickable material-icons filter-expandable filter-currency-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible currency'>
                <div class='filter-section-container'>
                    <div class=\"currencyCheckbox\" value='USD'>
                        <label class=\"container\">
                            <p>USD</p>
                            <input type=\"checkbox\" id='currencyUSD' name=\"currencyCheckbox\" value='USD' onclick='filterCheckboxOnClick(\"currency\", \"USD\")'>
                            <span class=\"checkmark\"></span>
                        </label>
                    </div>
                    <div class=\"currencyCheckbox\" value='HKD'>
                        <label class=\"container\">
                            <p>HKD</p>
                            <input type=\"checkbox\" id='currencyHKD' name=\"currencyCheckbox\" value='HKD' onclick='filterCheckboxOnClick(\"currency\", \"HKD\")'>
                            <span class=\"checkmark\"></span>
                        </label>
                    </div>
                    <div class=\"currencyCheckbox\" value='EUR'>
                        <label class=\"container\">
                            <p>EUR</p>
                            <input type=\"checkbox\" id='currencyEUR' name=\"currencyCheckbox\" value='EUR' onclick='filterCheckboxOnClick(\"currency\", \"EUR\")'>
                            <span class=\"checkmark\"></span>
                        </label>
                    </div>
                    <div class=\"currencyCheckbox\" value='GBP'>
                        <label class=\"container\">
                            <p>GBP</p>
                            <input type=\"checkbox\" id='currencyGBP' name=\"currencyCheckbox\" value='GBP' onclick='filterCheckboxOnClick(\"currency\", \"GBP\")'>
                            <span class=\"checkmark\"></span>
                        </label>
                    </div>
                    <div class=\"currencyCheckbox\" value='CHF'>
                        <label class=\"container\">
                            <p>CHF</p>
                            <input type=\"checkbox\" id='currencyCHF' name=\"currencyCheckbox\" value='CHF' onclick='filterCheckboxOnClick(\"currency\", \"CHF\")'>
                            <span class=\"checkmark\"></span>
                        </label>
                    </div>
                </div>
            </div>  
            ";
        echo "<div class='filter-divider'></div>";

        echo "<div class='filter-title'>
            <h4>PRICES RANGE</h4>
            <i class='clickable material-icons filter-expandable filter-price-expandable'>&#xE5CE;</i>
        </div>      
        <div class='filter-collapsible price'>
            <div class='price-input'>
                <div class='field'>
                    <input type='number' id='search-filter-price-range-min' class='input-min' pattern='[0-9]+' value='$minPrice'>
                </div>
                <div style='display: flex;'>
                    <p style='margin-bottom: 0px !important; align-self: center;'>~</p>
                </div>
                <div class='field'>
                    <input type='number' id='search-filter-price-range-max' class='input-max' pattern='[0-9]+' value='$maxPrice'>
                </div>
            </div>
            <div>
                <button class='button-main-2' onclick=\"applyFilter()\" style='width:100%;'>APPLY FILTER</button>
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

        if($current_user->data->ID == ''){
            $userId = 0;
        } else {
            $userId = $current_user->data->ID;
        }
        global $wpdb;
        $bookmarkedWatches = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookmarked_watches WHERE UserID = $userId;", OBJECT );
        // echo json_encode($bookmarkedWatches);
        foreach ($data as $item) {
            if(strcasecmp($item->source_type, 'Auction') == 0){
                renderAuctionWatchesCard($item, $userId, $bookmarkedWatches);
            } else {
                renderCard($item, $userId, $bookmarkedWatches);
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
        if(count($data) == 0)
        {
            echo "<div class='search-results-no-result'>No results found!</div>";
            echo "<div style='display:flex; justify-content:center;'>
                <button class='button-main-2' onclick=\"history.back()\">Back</button>
            </div>";
            return;
        }
        echo "<div class='search-filter-mobile'>
                <button class='button-main-3' onclick=\"toggleMobileFilter()\">FILTER & SORT</button>  
            </div>";
        echo "<div class='item-card-desc-title'>
                <h2>Filters</h2>
            </div>";

        $auctionList=array();
        foreach ($data as $item) {
            if (!in_array($item->auction_name, $auctionList)) {
                array_push($auctionList,$item->auction_name);
            }
        }
        
        $auctionListHTML = "";
        foreach ($auctionList as $auction) {
            $auctionListHTML = "$auctionListHTML<div class=\"auctionNameCheckbox\" value='$auction'><label class=\"container\">
                <p>$auction</p>
                <input type=\"checkbox\" id='$auction' name=\"auctionNameCheckbox\" value='$auction'>
                <span class=\"checkmark\"></span>
            </label></div>";
        }

        echo "<div class='search-result-container'>";
        echo "<div class='filter-sticky mobile-hide'>";
        echo "<div id='search-result-filter' class='auction'>";  
        echo "<div id='search-result-filter-mobile-header'>
            <div class='filter-mobile-title'>
                <h4>FILTER & SORT</h4>
                <i class='clickable material-icons search-result-filter-mobile-close'>close</i>
            </div>
        </div>
        ";
        echo "
        <div class='filter-title'>
            <h4>AUCTION TYPE</h4>
        </div>  
        <div class='filter-section-container'>
            <div class=\"modelCheckbox\" value='Online Auction'><label class=\"container\">
                <p>Online Auction</p>
                <input type=\"checkbox\" id='Online Auction' name=\"auctionTypeCheckbox\" value='Online Auction'>
                <span class=\"checkmark\"></span>
            </label></div>
            <div class=\"modelCheckbox\" value='Live Auction'><label class=\"container\">
                <p>Live Auction</p>
                <input type=\"checkbox\" id='Live Auction' name=\"auctionTypeCheckbox\" value='Live Auction'>
                <span class=\"checkmark\"></span>
            </label></div>
        </div>
        ";
        echo " <div class='filter-divider'></div>";
        echo " <div class='filter-title'>
                    <h4>AUCTION NAME</h4>
                    <i class='clickable material-icons filter-expandable filter-auction-name-expandable'>&#xE5CE;</i>
                </div>
                <div class='filter-section-container'>
                    <div class='filter-collapsible auction'>
                        <input type='text' id='auctionNameFilterSearch' class='filterSearch' placeholder='Enter auction name here...'>
                        <div class='filter-section-container'>
                            $auctionListHTML
                        </div>
                    </div>
                </div>   
                ";
        echo "<div class='filter-divider'></div>";
        echo "<div class='filter-section-container'>
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

    function renderAuctionWatchesResultsWithFilter($data, $page, $filter, $maxPage, $auctionTitleList, $currencies)
    {
        if(count($data) == 0)
        {
            echo "<div class='search-results-no-result'>No results found!</div>";
            echo "<div style='display:flex; justify-content:center;'>
                <button class='button-main-2' onclick=\"history.back()\">Back</button>
            </div>";
            return;
        }
        echo "<div class='search-filter-mobile'>
            <button class='button-main-3' onclick=\"toggleMobileFilter()\">FILTER & SORT</button>  
        </div>";
        echo "<div class='item-card-desc-title'>
                <h2>Filters</h2>
            </div>";

        $auctionList=array();
        foreach ($data as $item) {
            if (!in_array($item->auction_name, $auctionList)) {
                array_push($auctionList,$item->auction_name);
            }
        }

        $brandHTML = "";

        foreach ($filter->brands as $brand) {
            $brandHTML = "$brandHTML<div class=\"brandCheckbox\" value=\"$brand\"><label class=\"container\">
                <p>$brand</p>
                <input type=\"checkbox\" id=\"$brand\" name=\"brandCheckbox\" value=\"$brand\">
                <span class=\"checkmark\"></span>
            </label></div>";
        }


        $auctionListHTML = "<option value='' selected='selected'>Please Select</option>";
        foreach ($auctionList as $auction) {
            $auctionListHTML = "$auctionListHTML<option value='$auction'>$auction</option>";
        }

        echo "<div class='search-result-container'>";
        echo "<div class='filter-sticky mobile-hide'>";
        echo "<div id='search-result-filter' class='auction'>";  
        echo "<div id='search-result-filter-mobile-header'>
            <div class='filter-mobile-title'>
                <h4>FILTER & SORT</h4>
                <i class='clickable material-icons search-result-filter-mobile-close'>close</i>
            </div>
        </div>
        ";
        echo "<div class='filter-title'>
            <h4>BRAND</h4>
            <i class='clickable material-icons filter-expandable filter-brand-expandable'>&#xE5CE;</i>
        </div>
        <div class='filter-collapsible brand'>
            <input type='text' id='brandFilterSearch' class='filterSearch' placeholder='Enter brand name here...'>
            <div class='filter-section-container'>
                $brandHTML
            </div>
        </div>
        <div class='filter-divider'></div>";



        $statusHTML = "";
        foreach ($filter->status as $status) {
            $statusHTML = "$statusHTML<div class=\"statusCheckbox\" value='$status'>
                <label class=\"container\">
                    <p>$status</p>
                    <input type=\"checkbox\" id='$status' name=\"statusCheckbox\" value='$status'>
                    <span class=\"checkmark\"></span>
                </label>
            </div>";
        }

        echo " <div class='filter-title'>
                <h4>STATUS</h4>
                <i class='clickable material-icons filter-expandable filter-status-expandable'>&#xE5CE;</i>
            </div>
            <div class='filter-collapsible status'>
                <div class='filter-section-container'>
                    $statusHTML
                </div>
            </div>
            <div class='filter-divider'></div>";

        if(count($currencies) > 0){
            $currencyListHTML = "";
            foreach ($currencies as $curr) {
                $currencyListHTML = "$currencyListHTML<div class=\"currencyCheckbox\" value='$curr'><label class=\"container\">
                    <p>$curr</p>
                    <input type=\"checkbox\" id='$curr' name=\"currencyCheckbox\" value='$curr'>
                    <span class=\"checkmark\"></span>
                </label></div>";
            }

            echo " <div class='filter-title'>
                    <h4>CURRENCY</h4>
                    <i class='clickable material-icons filter-expandable filter-currency-expandable'>&#xE5CE;</i>
                </div>
                <div class='filter-collapsible currency'>
                    <div class='filter-section-container'>
                        $currencyListHTML
                    </div>
                </div>
                ";
        }
        echo "<div class='filter-divider'></div>";

        if(count($auctionTitleList) > 0){
            $auctionTitleListHTML = "";
            foreach ($auctionTitleList as $auction) {
                $auctionTitleListHTML = "$auctionTitleListHTML<div class=\"auctionTitleCheckbox\" value='$auction'><label class=\"container\">
                    <p>$auction</p>
                    <input type=\"checkbox\" id='$auction' name=\"auctionTitleCheckbox\" value='$auction'>
                    <span class=\"checkmark\"></span>
                </label></div>";
            }

            echo " <div class='filter-title'>
                    <h4>AUCTION TITLE</h4>
                    <i class='clickable material-icons filter-expandable filter-auction-title-expandable'>&#xE5CE;</i>
                </div>
                <div class='filter-collapsible auction'>
                    <div class='filter-section-container'>
                        $auctionTitleListHTML
                    </div>
                </div>
                ";
        }
        
        echo "  
        <div class='filter-button-container'>
            <button class='button-main-1' onclick=\"clearAuctionWatchFilter()\" style='margin-bottom: 10px; width:100%;'>CLEAR ALL FILTERS</button>
            <button class='button-main-2' onclick=\"applyAuctionWatchFilter()\" style='width:100%;'>APPLY FILTER</button>
        </div>
        ";
        echo "</div>";
        echo "</div>";
        echo "<div class='search-results'>";
        $current_user = wp_get_current_user();
        if($current_user->data->ID == ''){
            $userId = 0;
        } else {
            $userId = $current_user->data->ID;
        }
        global $wpdb;
        $bookmarkedWatches = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookmarked_watches WHERE UserID = $userId;", OBJECT );
        
        foreach ($data as $item) {
            renderAuctionWatchesCard($item, $userId, $bookmarkedWatches);
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
        $current_user = wp_get_current_user();
        if($current_user->data->ID == ''){
            $userId = 0;
        } else {
            $userId = $current_user->data->ID;
        }
        global $wpdb;
        $bookmarkedWatches = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookmarked_watches WHERE UserID = $userId;", OBJECT );

        echo "<div class='home-listing-container $class'>";
        foreach ($data as $item) {
            renderCard($item, $current_user->data->ID, $bookmarkedWatches);
        }
        echo "</div>";

    }

    function renderBookmarkedWatches($data, $userId, $page, $maxPage){
        global $wpdb;
        $bookmarkedWatches = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}bookmarked_watches WHERE UserID = $userId;", OBJECT );

        echo "<div class='bookmark-results'>";
        foreach ($data as $item) {
            if(strcasecmp($item->source_type, 'Auction') == 0){
                renderAuctionWatchesCard($item, $userId, $bookmarkedWatches);
            } else {
                renderCard($item, $userId, $bookmarkedWatches);
            }
        }   
        echo "</div>";


        if(count($data) > 0){
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
    }

    

    function renderUpcomingAuction($data){
        echo "<div class='home-listing-container'>";
        if($data != null) {
            foreach ($data as $item) {
                $endDate = new DateTime($item->auction_end_date);
                $endDate->modify('+1 day');
                if ($endDate >= new DateTime()) {
                    renderAuctionCard($item);
                }
            }
        }
        echo "</div>";

    }

    function renderCard($item, $userId, $bookmarkedWatches){
        $currency = convertCurrency($item->currency);

        $sourceText = '';
        $updatedAtText = '';
        if(strcasecmp($item->source_type, 'Retail') == 0){
            $formattedCreatedAt = date_format(date_create($item->created_at), 'd/m/y');
            $sourceText = $item->original_poster;
            $formattedUpdatedAt = date_format(date_create($item->first_post_date), 'd M, Y');
            $updatedAtText = "Listed on: $formattedUpdatedAt";
        } else {
            $formattedCreatedAt = date_format(date_create($item->first_post_date), 'd/m/y');
            $formattedUpdatedAt = date_format(date_create($item->last_post_date), 'd/m/y');
            $sourceText = "$item->original_poster on $item->forum_name $formattedCreatedAt";
            $updatedAtText = "Last post date: $formattedUpdatedAt";
        }

        $formattedPrice = number_format((int)$item->product_price);
        $itemStatusHTML = "";
        if(strcasecmp($item->source_type, 'Forum') != 0) {
            $itemStatusHTML = "<div class='item-card-status'>$item->status</div>";
        }
        if(strcasecmp($item->source_type, 'Auction') != 0) {
            $imageUrl = $item->main_img_url;
            if($item->forum_name == 'Ponti') {
                $imageUrl = "http://128.199.148.89/full/retail/$item->forum_name/$item->img_local_path";
            }

            $post_title = strip_tags($item->post_title);

            $hasBookmarkedClass = "";
            if(existsInBookmarkArray($item->id, $bookmarkedWatches)) {
                $hasBookmarkedClass = "active";
            }

            // <svg version='1.1' class='bookmark-icon $item->id $hasBookmarkedClass' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'
            //                                 viewBox='0 0 512 512' xml:space='preserve'>
            //                             <g>
            //                                 <g>
            //                                     <polygon points='68.267,0 68.267,512 85.333,512 256,341.333 426.667,512 443.733,512 443.733,0'/>
            //                                 </g>
            //                             </g>
            //                         </svg>
            echo "
                <div class='item-card'>
                        <div class='item-card-bookmark $item->id $hasBookmarkedClass'>
                            <a class='item-card-bookmark-action' onclick='bookmarkWatch($userId, $item->id, \"$item->source_type\");'>
                                <div style='width: 40px; height:40px;cursor: pointer;'>
                                </div>
                            </a>
                        </div>
                        <a href='$item->post_link' target='_blank'>
                            <div class='item-card-top'>
                                $itemStatusHTML
                                <div class='item-card-image-container'>
                                    <img class='item-card-img-top' src='$imageUrl' alt=''>
                                </div>
                            </div>
                        </a>
                        <div class='item-card-desc'>
                            <div class='item-card-desc-title'>
                                <a href='$item->post_link' target='_blank'>
                                    <h3>
                                        $post_title
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
        $endDate->modify('+1 day');
        $stringStartDate = $startDate->format('Y-m-d');
        $stringEndDate = $endDate->format('Y-m-d');

        $cleanAuctionName = encodeURIComponent($item->auction_name);
        $cleanAuctionTitle = encodeURIComponent($item->auction_title);

        // $post_link = '';
        // if($post_link != null) {
        //     $post_link = $item->post_link;
        // }
        // $post_title ='';
        // if($post_title != null) {
        //     $post_title = $item->post_title;
        // }

        $post_link = isset($item->post_link) ? strip_tags($item->post_link) : '';
        $post_title = isset($item->post_title) ? strip_tags($item->post_title) : '';

        // $liveAuctionClass = '';
        // if($item->auction_type == 'Live Auction')
        // {
        //     $liveAuctionClass = 'live-auction';
        // }

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
                    <a href='$post_link' target='_blank'>
                                <h3>
                                    $post_title
                                </h3>
                    </a>
                    <a href='/auction-watches?auctionStartDate=$stringStartDate&auctionEndDate=$stringEndDate&auctionName=$cleanAuctionName&auctionType=$item->auction_type&auctionTitle=$cleanAuctionTitle'>
                        <button class='button-main-1'>$buttonText</button>
                    </a>
            </div>";
    }

    function renderAuctionWatchesCard($item, $userId, $bookmarkedWatches){
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

        $post_title = strip_tags($item->post_title);
        $hasBookmarkedClass = "";
        if(existsInBookmarkArray($item->id, $bookmarkedWatches)) {
            $hasBookmarkedClass = "active";
        }

        if($userId == ''){
            $userId = 0;
        }

        $buttonText = ($item->status == 'Closed Bid' || $item->status == 'Unsold') ? 'VIEW LOT' : 'PLACE BID';
        echo "
                <div class='item-card'> 
                    <div class='item-card-bookmark $item->id $hasBookmarkedClass'>
                        <a class='item-card-bookmark-action' onclick='bookmarkWatch($userId, $item->id, \"$item->source_type\");'>
                            <div style='width: 40px; height:40px;cursor: pointer;'>
                            </div>
                        </a>
                    </div>
                    <a href='$item->watch_link' target='_blank'>
                        <div>
                            <div class='item-card-status $auctionStatus'>$item->status</div>
                            <div class='item-card-image-container'>
                                <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                            </div>
                        </div>
                    </a>
                    <div class='item-card-desc'>
                        <div class='item-card-desc-title'>
                            <h3>
                                $item->reference_id: $item->lot_title
                            </h3>
                        </div>
                        <div class='item-card-desc-brand'>
                            <h6>
                                $item->brand
                            </h6>
                        </div>
                    </div>
                    <div>
                        <h7 class='item-card-model'>
                            $item->model
                        </h7>
                    </div>
                    <h7 class='item-card-source'>
                        $item->auction_name ($item->currency) <br>
                        $currency$formattedMinEst - $currency$formattedMaxEst <br>
                        Start date: $stringStartDate
                    </h7>
                    <div class='auction-watches'>
                        $priceHTML
                    </div>
                    <a href='$item->post_link' target='_blank'>
                                <h5>
                                    $post_title
                                </h5>
                    </a>
                    <a href='$item->watch_link' target='_blank'>
                        <button class='button-main-1'>$buttonText</button>
                    </a>
            </div>";
    }

    function encodeURIComponent($str) {
        return str_replace('&', '%26', $str);
    }

    function existsInBookmarkArray($watchId, $array) {
        foreach ($array as $compare) {
            if ($compare->watchId == $watchId) {
                return true;
            }
        }
    }