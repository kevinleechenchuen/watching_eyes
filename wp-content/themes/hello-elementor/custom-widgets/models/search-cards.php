<?php

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
            $brandHTML = "$brandHTML<div><input type=\"checkbox\" id=$brand name=\"brandCheckbox\" value=$brand><label for=$brand> $brand</label></div>";
        }
        foreach ($filter->models as $model) {
            $modelHTML = "$modelHTML<div><input type=\"checkbox\" id=$model name=\"modelCheckbox\" value=$model><label for=$model> $model</label></div>";
        }
        foreach ($filter->sources as $source) {
            $sourceHTML = "$sourceHTML<div><input type=\"checkbox\" id=$source name=\"sourceCheckbox\" value=$source><label for=$source> $source</label></div>";
        }
        echo "<h4>BRAND</h4>
            <div class='filter-section-container'>
                $brandHTML
            </div>";
        echo "<h4>MODEL</h4>
            <div class='filter-section-container'>
                $modelHTML
            </div>";
        echo "<h4>SOURCE</h4>
            <div class='filter-section-container'> 
                $sourceHTML
            </div>";
        echo "  
        <script>
        function applyFilter(){
            var brandCheckedBoxes = document.querySelectorAll('input[name=brandCheckbox]:checked');
            var modelCheckedBoxes = document.querySelectorAll('input[name=modelCheckbox]:checked');
            var sourceCheckedBoxes = document.querySelectorAll('input[name=sourceCheckbox]:checked');

            var brandList = [];
            var modelList = [];
            var sourceList = [];
            for(var i=0; brandCheckedBoxes[i]; ++i){
                brandList.push(brandCheckedBoxes[i].value);
            }
            for(var i=0; modelCheckedBoxes[i]; ++i){
                modelList.push(modelCheckedBoxes[i].value);
            }
            for(var i=0; sourceCheckedBoxes[i]; ++i){
                sourceList.push(sourceCheckedBoxes[i].value);
            }

            var brandsParams = brandList.length > 0 ? '&brand='+brandList.join(',') : '';
            var modelsParams = modelList.length > 0 ? '&model='+modelList.join(',') : '';
            var sourceParams = sourceList.length > 0 ? '&sourceName='+sourceList.join(',') : '';

            window.location.href = '/search?'+brandsParams+modelsParams+sourceParams;
        }

        function clearFilter(){
            var brandCheckedBoxes = document.querySelectorAll('input[name=brandCheckbox]:checked');
            var modelCheckedBoxes = document.querySelectorAll('input[name=modelCheckbox]:checked');
            var sourceCheckedBoxes = document.querySelectorAll('input[name=sourceCheckbox]:checked');

            for(var i=0; brandCheckedBoxes[i]; ++i){
                brandCheckedBoxes[i].checked = false;
            }
            for(var i=0; modelCheckedBoxes[i]; ++i){
                modelCheckedBoxes[i].checked = false;
            }
            for(var i=0; sourceCheckedBoxes[i]; ++i){
                sourceCheckedBoxes[i].checked = false;
            }
        }
        </script>
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

    function renderHorizontalListing($data){
        echo "<div class='home-listing-container'>";
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
        echo "
            <div class='item-card'>
                <a href='$item->post_link' target='_blank'>
                    <div class='item-card-image-container'>
                        <img class='item-card-img-top' src='$item->main_img_url' alt=''>
                    </div>
                    <div class='item-card-desc'>
                        <div class='item-card-desc-brand'>
                            <h6>
                                $item->brand
                            </h6>
                        </div>
                        <div class='item-card-desc-title'>
                            <h5>
                                $item->post_title
                            </h5>
                        </div>
                        <h5 class='item-card-price'>
                            $item->product_price
                        </h5>
                        <h7 class='item-card-source'>
                            $item->original_poster on $item->forum_name
                        </h7>
                    </div>
                </a>
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