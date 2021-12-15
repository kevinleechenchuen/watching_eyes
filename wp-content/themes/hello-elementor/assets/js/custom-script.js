jQuery(document).ready(function () {
    const params = new URLSearchParams(window.location.search)
    var sourceTypes = params.get('sourceType');
    if (sourceTypes) {
        var sourceTypesList = sourceTypes.split(',');
        var sourceTypeCheckedBoxes = document.querySelectorAll('input[name=source-search-checkbox]');
        jQuery('#all-search-checkbox').prop('checked', false);
        sourceTypeCheckedBoxes.forEach((checkbox) => {
            if (sourceTypesList.includes(checkbox.value)) {
                checkbox.checked = true;    
            } else {
                checkbox.checked = false;
            }
        });
    }
    
    jQuery('#brandFilterSearch').on('input', function () {
        let filter = jQuery(this).val();
        if (filter === '') {
            jQuery('div[class=brandCheckbox]').each(function () {
                jQuery(this).show();
            });
            
        } else {    
            jQuery('div[class=brandCheckbox]').each(function () {
                if (jQuery(this).attr("value").toLowerCase().indexOf(filter.toLowerCase()) === -1) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).show();
                }
            });
        }
    });

    jQuery('#modelFilterSearch').on('input', function () {
        let filter = jQuery(this).val();
        if (filter === '') {
            jQuery('div[class=modelCheckbox]').each(function () {
                jQuery(this).show();
            });

        } else {
            jQuery('div[class=modelCheckbox]').each(function () {
                if (jQuery(this).attr("value").toLowerCase().indexOf(filter.toLowerCase()) === -1) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).show();
                }
            });
        }
    });

    jQuery(".scroll-arrow-left").click(function () {
        jQuery(".home-listing-container").animate({ scrollLeft: "-=" + 400 });
    });
    jQuery(".scroll-arrow-right").click(function () {
        jQuery(".home-listing-container").animate({ scrollLeft: "+=" + 400 });
    });

    jQuery('#forum-search-checkbox').on('change', function () {
        jQuery('#all-search-checkbox').prop('checked', false);
    });
    jQuery('#auction-search-checkbox').on('change', function () {
        jQuery('#all-search-checkbox').prop('checked', false);
    });
    jQuery('#dealers-search-checkbox').on('change', function () {
        jQuery('#all-search-checkbox').prop('checked', false);
    });
});


function applyFilter() {
    var minPrice = document.getElementById("search-filter-price-range-min").value;
    var maxPrice = document.getElementById("search-filter-price-range-max").value;
    var brandCheckedBoxes = document.querySelectorAll('input[name=brandCheckbox]:checked');
    var modelCheckedBoxes = document.querySelectorAll('input[name=modelCheckbox]:checked');
    var sourceCheckedBoxes = document.querySelectorAll('input[name=sourceCheckbox]:checked');

    var brandList = [];
    var modelList = [];
    var sourceList = [];
    for (var i = 0; brandCheckedBoxes[i]; ++i) {
        brandList.push(brandCheckedBoxes[i].value);
    }
    for (var i = 0; modelCheckedBoxes[i]; ++i) {
        modelList.push(modelCheckedBoxes[i].value);
    }
    for (var i = 0; sourceCheckedBoxes[i]; ++i) {
        sourceList.push(sourceCheckedBoxes[i].value);
    }

    const params = new URLSearchParams(window.location.search)
    var q = params.get('q');
    var queryParams = '&q=' + q;
    var sourceType = params.get('sourceType');
    var sourceTypeParams = '&sourceType=' + sourceType;

    var minPriceParams = minPrice > 0 ? '&priceFrom=' + minPrice : '';
    var maxPriceParams = maxPrice < 1000000 ? '&priceTo=' + maxPrice : '';
    var brandsParams = brandList.length > 0 ? '&brand=' + brandList.join(',') : '';
    var modelsParams = modelList.length > 0 ? '&model=' + modelList.join(',') : '';
    var sourceParams = sourceList.length > 0 ? '&sourceName=' + sourceList.join(',') : '';

    window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams + minPriceParams + maxPriceParams + sourceTypeParams;
}

function applyAuctionFilter() {
    var auctionTypeCheckBoxes = document.querySelectorAll('input[name=auctionTypeCheckbox]:checked');
    var auctionName = document.getElementById("filter-auction-name").value;
    var auctionDateFrom = document.getElementById("auctionStartDate").value;
    var auctionDateTo = document.getElementById("auctionEndDate").value;

    var auctionTypeList = [];
    for (var i = 0; auctionTypeCheckBoxes[i]; ++i) {
        auctionTypeList.push(auctionTypeCheckBoxes[i].value);
    }

    var auctionTypeParams = auctionTypeList.length > 0 ? '&auctionType=' + auctionTypeList.join(',') : '';
    var auctionNameParams = '&auctionName=' + auctionName;
    var auctionDateFromParams = '&auctionStartDate=' + auctionDateFrom;
    var auctionDateToParams = '&auctionEndDate=' + auctionDateTo;

    window.location.href = '/auction-calendar?' + auctionTypeParams + auctionNameParams + auctionDateFromParams + auctionDateToParams;
}

function applyAuctionWatchFilter() {
    const params = new URLSearchParams(window.location.search)
    var auctionStatusCheckBoxes = document.querySelectorAll('input[name=auctionStatusCheckbox]:checked');
    var estMinPriceFilter = document.getElementById("estMinPriceFilter").value;
    var estMaxPriceFilter = document.getElementById("estMaxPriceFilter").value;
    var minCurrentBidFilter = document.getElementById("minCurrentBidFilter").value;
    var maxCurrentBidFilter = document.getElementById("maxCurrentBidFilter").value;

    var auctionStatusList = [];
    for (var i = 0; auctionStatusCheckBoxes[i]; ++i) {
        auctionStatusList.push(auctionStatusCheckBoxes[i].value);
    }

    var auctionName = encodeURIComponent(params.get('auctionName'));
    var auctionType = encodeURIComponent(params.get('auctionType'));
    var auctionTitle = encodeURIComponent(params.get('auctionTitle'));

    var auctionStatusParams = auctionStatusList.length > 0 ? '&auctionStatus=' + auctionStatusList.join(',') : '';
    var auctionNameParams = '&auctionName=' + auctionName;
    var auctionTypeParams = '&auctionType=' + auctionType;
    var auctionTitleToParams = '&auctionTitle=' + auctionTitle;
    var auctionMinEstPriceParams = '&auctionMinEstPrice=' + estMinPriceFilter;
    var auctionMaxEstPriceParams = '&auctionMaxEstPrice=' + estMaxPriceFilter;
    var auctionMinBidParams = '&auctionMinBid=' + minCurrentBidFilter;
    var auctionMaxBidParams = '&auctionMaxBid=' + maxCurrentBidFilter;

    window.location.href = '/auction-watches?'
        + auctionStatusParams
        + auctionNameParams
        + auctionTypeParams
        + auctionTitleToParams
        + auctionMinEstPriceParams
        + auctionMaxEstPriceParams
        + auctionMinBidParams
        + auctionMaxBidParams;
}

function clearFilter() {
    var brandCheckedBoxes = document.querySelectorAll('input[name=brandCheckbox]:checked');
    var modelCheckedBoxes = document.querySelectorAll('input[name=modelCheckbox]:checked');
    var sourceCheckedBoxes = document.querySelectorAll('input[name=sourceCheckbox]:checked');

    for (var i = 0; brandCheckedBoxes[i]; ++i) {
        brandCheckedBoxes[i].checked = false;
    }
    for (var i = 0; modelCheckedBoxes[i]; ++i) {
        modelCheckedBoxes[i].checked = false;
    }
    for (var i = 0; sourceCheckedBoxes[i]; ++i) {
        sourceCheckedBoxes[i].checked = false;
    }
}

function clearSpecificFilter(name) {
    var checkedBoxes = document.querySelectorAll(`input[name=${name}]:checked`);

    for (var i = 0; checkedBoxes[i]; ++i) {
        checkedBoxes[i].checked = false;
    }
}
function removeSaveSearch(id, name) {

    if (confirm(`Are you sure you want to remove ${name} from your saved search?`)) {
        jQuery.ajax({
            type: 'DELETE',
            url: `https://${window.location.hostname}/wp-json/custom/v1/save_search/` + id,
            data: { id: id },

            success: function (data) {
                console.log(data);
                if (data == 'success') {
                    location.reload();
                } else {
                    jQuery('#save-search-textbox-error').html('Something went wrong! Please try again.');
                }
            }
        });
    }
}
function saveSearch(userId) {
    var saveQuery = document.getElementsByName('save-search-textbox')[0].value;

    if (saveQuery === '') {
        jQuery('#save-search-textbox-error').html('Keyword cannot be empty!');
        return null;
    } else {
        jQuery.ajax({
            type: 'POST',
            url: `https://${window.location.hostname}/wp-json/custom/v1/save_search`,
            data: { userid: userId, query: saveQuery, name: saveQuery },

            success: function (data) {
                console.log(data);
                if (data == 'success') {
                    location.reload();
                } else {
                    jQuery('#save-search-textbox-error').html('Something went wrong! Please try again.');
                }
            }
        });
        jQuery('#save-search-textbox-error').html('');
    }
}

function saveSearchWithoutQuery(userId) {
    var query = document.getElementsByName('header-search-textbox')[0].value;

    jQuery.ajax({
        type: 'POST',
        url: `https://${window.location.hostname}/wp-json/custom/v1/save_search`,
        data: { userid: userId, query: query, name: query },

        success: function (data) {
            console.log(data);
            if (data == 'success') {
                window.location.href = `https://${window.location.hostname}/profile-saved-search/`;
            }
        }
    });
}

// function scrollContainer(container, direction) {
//     console.log(container, direction);
//     if (direction === 'left') {
//         jQuery(container).animate({ scrollRight: "+=" + 500 });
//     } else {
//         jQuery(container).animate({ scrollRight: "-=" + 500 });
//     }
// }
