jQuery(document).ready(function () {
    var input = document.getElementById('header-search-textbox');
    var isMobile = false
    if(window.matchMedia("(max-width: 600px)").matches){
        jQuery('#header-search-textbox').removeAttr('id');
        isMobile = true;
    }
    input.addEventListener('keyup', function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById('header-menu-search').click();
    }
    });
    
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

    var brandsInParams = params.get('brand');
    if (brandsInParams) {
        var brandsInParamsList = brandsInParams.split(',');
        var brandCheckedBoxes = document.querySelectorAll('input[name=brandCheckbox]');
        brandCheckedBoxes.forEach((checkbox) => {
            if (brandsInParamsList.includes(checkbox.value)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    }

    var modelsInParams = params.get('model');
    if (modelsInParams) {
        var modelsInParamsList = modelsInParams.split(',');
        var modelCheckedBoxes = document.querySelectorAll('input[name=modelCheckbox]');
        modelCheckedBoxes.forEach((checkbox) => {
            if (modelsInParamsList.includes(checkbox.value)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    }

    var sourceInParams = params.get('sourceName');
    if (sourceInParams) {
        var sourceInParamsList = sourceInParams.split(',');
        var sourceCheckedBoxes = document.querySelectorAll('input[name=sourceCheckbox]');
        sourceCheckedBoxes.forEach((checkbox) => {
            if (sourceInParamsList.includes(checkbox.value)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    }

    jQuery(".filter-brand-expandable").on('click', function(){
        jQuery(".filter-expandable").css("transform", "rotate(0deg)");
        jQuery(".filter-collapsible").css("max-height", "0px");

        if(jQuery(".filter-collapsible.brand").css("max-height") === "0px"){
            jQuery(".filter-brand-expandable").css("transform", "rotate(180deg)");
            jQuery(".filter-collapsible.brand").css("max-height", "250px");
        } else {
            jQuery(".filter-brand-expandable").css("transform", "rotate(0deg)");
            jQuery(".filter-collapsible.brand").css("max-height", "0px");
        }
    });
    jQuery(".filter-model-expandable").on('click', function(){
        jQuery(".filter-expandable").css("transform", "rotate(0deg)");
        jQuery(".filter-collapsible").css("max-height", "0px");

        if(jQuery(".filter-collapsible.model").css("max-height") === "0px"){
            jQuery(".filter-model-expandable").css("transform", "rotate(180deg)");
            jQuery(".filter-collapsible.model").css("max-height", "250px");
        } else {
            jQuery(".filter-model-expandable").css("transform", "rotate(0deg)");
            jQuery(".filter-collapsible.model").css("max-height", "0px");
        }
    });
    jQuery(".filter-source-expandable").on('click', function(){
        jQuery(".filter-expandable").css("transform", "rotate(0deg)");
        jQuery(".filter-collapsible").css("max-height", "0px");

        if(jQuery(".filter-collapsible.source").css("max-height") === "0px"){
            jQuery(".filter-source-expandable").css("transform", "rotate(180deg)");
            jQuery(".filter-collapsible.source").css("max-height", "250px");
        } else {
            jQuery(".filter-source-expandable").css("transform", "rotate(0deg)");
            jQuery(".filter-collapsible.source").css("max-height", "0px");
        }
    });
    
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

    var sortInParam = params.get('sort');
    if (sortInParam) {
        var sortCheckedBoxes = document.querySelectorAll('#filter-sortby option[value='+sortInParam+']');
        sortCheckedBoxes.forEach((checkbox) => {
            checkbox.selected = 'selected'
        });
    }

    var accInParam = params.get('acc');
    if (accInParam) {
        var accCheckedBoxes = document.querySelectorAll('#filter-acc option[value='+accInParam+']');
        accCheckedBoxes.forEach((checkbox) => {
            checkbox.selected = 'selected'
        });
    }

    var lastUpdatedInParam = params.get('lastUpdated');
    if (lastUpdatedInParam) {
        var lastUpdatedCheckedBoxes = document.querySelectorAll('#filter-last-updated option[value='+lastUpdatedInParam+']');
        lastUpdatedCheckedBoxes.forEach((checkbox) => {
            checkbox.selected = 'selected'
        });
    }

    jQuery( "#filter-sortby" ).change(function() {
        var sort = jQuery('#filter-sortby').find(":selected").val();
        var url = new URL(window.location.href);
        url.searchParams.set("sort", sort);
        window.location.href = url.href;
    });
    jQuery( "#filter-acc" ).change(function() {
        var acc = jQuery('#filter-acc').find(":selected").val();
        var url = new URL(window.location.href);
        url.searchParams.set("acc", acc);
        window.location.href = url.href;
    });
    jQuery( "#filter-last-updated" ).change(function() {
        var lastUpdated = jQuery('#filter-last-updated').find(":selected").val();
        var url = new URL(window.location.href);
        url.searchParams.set("lastUpdated", lastUpdated);
        window.location.href = url.href;
    });
});

function filterCheckboxOnClick(type, value) {
    const params = new URLSearchParams(window.location.search);
    var sourceType = params.get('sourceType');
    var q = params.get('q');
    let queryParams = '';
    if (q) {
        queryParams = '&q=' + encodeURIComponent(q);
    }
    if (type === 'brand') {
        var brandCheckedBox = document.getElementById(value);
        let brandsParams;
        if (brandCheckedBox.checked) {
            const brands = params.get('brand');
            if (brands == null || brands === '') {
                brandsParams = '&brand=' + encodeURIComponent(value);
            } else {
                brandsParams = '&brand=' + encodeURIComponent(brands) + `,${value}`;
            }
        } else {
            let brands;
            if (params.get('brand').indexOf(',') > 0) {
                brands = params.get('brand').replace(`,${value}`, '');
            } else {
                brands = params.get('brand').replace(`${value}`, '');
            }
            brandsParams = '&brand=' + encodeURIComponent(brands);
        }
        console.log(brandsParams);
        let sourceTypeParams = '';
        if (sourceType) {
            sourceTypeParams = '&sourceType=' + encodeURIComponent(sourceType);
        }
        var minPriceParams = (params.get('priceFrom') !== null) ? '&priceFrom=' + params.get('priceFrom') : '';
        var maxPriceParams = (params.get('priceTo') !== null) ? '&priceTo=' + params.get('priceTo') : '';
        var modelsParams = (params.get('model') !== null) ? '&model=' + params.get('model') : '';
        var sourceParams = (params.get('sourceName') !== null) ? '&sourceName=' + params.get('sourceName') : '';

        console.log('brandsParams',brandsParams);
        console.log('modelsParams',modelsParams);
        console.log('sourceParams',sourceParams);
        console.log('queryParams',queryParams);
        console.log('minPriceParams',minPriceParams);
        console.log('maxPriceParams',maxPriceParams);
        console.log('sourceTypeParams',sourceTypeParams);

        window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams + minPriceParams + maxPriceParams + sourceTypeParams;
    } else if (type === 'model') {
        var modelCheckedBox = document.getElementById(value);
        let modelsParams;
        if (modelCheckedBox.checked) {
            const models = params.get('model');
            if (models == null || models === '') {
                modelsParams = '&model=' + encodeURIComponent(value); 
            } else {
                modelsParams = '&model=' + encodeURIComponent(models) + `,${value}`;
            }
        } else {
            let models;
            if (params.get('model').indexOf(',') > 0) {
                models = params.get('model').replace(`,${value}`, '');
            } else {
                models = params.get('model').replace(`${value}`, '');
            }
            modelsParams = '&model=' + encodeURIComponent(models);
        }
        let sourceTypeParams = '';
        if (sourceType) {
            sourceTypeParams = '&sourceType=' + encodeURIComponent(sourceType);
        }
        var minPriceParams = (params.get('priceFrom') !== null) ? '&priceFrom=' + params.get('priceFrom') : '';
        var maxPriceParams = (params.get('priceTo') !== null) ? '&priceTo=' + params.get('priceTo') : '';
        var brandsParams = (params.get('brand') !== null) ? '&brand=' + params.get('brand') : '';
        var sourceParams = (params.get('sourceName') !== null) ? '&sourceName=' + params.get('sourceName') : '';

        console.log('brandsParams',brandsParams);
        console.log('modelsParams',modelsParams);
        console.log('sourceParams',sourceParams);
        console.log('queryParams',queryParams);
        console.log('minPriceParams',minPriceParams);
        console.log('maxPriceParams',maxPriceParams);
        console.log('sourceTypeParams',sourceTypeParams);

        window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams + minPriceParams + maxPriceParams + sourceTypeParams;
    } else if (type === 'source') {
        var sourceCheckedBox = document.getElementById(value);
        let sourceParams;
        if (sourceCheckedBox.checked) {
            const source = params.get('sourceName');
            if (source == null || source === '') {
                sourceParams = '&sourceName=' + encodeURIComponent(value);
            } else {
                sourceParams = '&sourceName=' + encodeURIComponent(source) + `,${value}`;
            }
        } else {
            let source;
            if (params.get('sourceName').indexOf(',') > 0) {
                source = params.get('sourceName').replace(`,${value}`, '');
            } else {
                source = params.get('sourceName').replace(`${value}`, '');
            }
            sourceParams = '&sourceName=' + encodeURIComponent(source);
        }
        let sourceTypeParams = '';
        if (sourceType) {
            sourceTypeParams = '&sourceType=' + encodeURIComponent(sourceType);
        }
        var minPriceParams = (params.get('priceFrom') !== null) ? '&priceFrom=' + params.get('priceFrom') : '';
        var maxPriceParams = (params.get('priceTo') !== null) ? '&priceTo=' + params.get('priceTo') : '';
        var brandsParams = (params.get('brand') !== null) ? '&brand=' + params.get('brand') : '';
        var modelsParams = (params.get('model') !== null) ? '&model=' + params.get('model') : '';

        console.log('brandsParams',brandsParams);
        console.log('modelsParams',modelsParams);
        console.log('sourceParams',sourceParams);
        console.log('queryParams',queryParams);
        console.log('minPriceParams',minPriceParams);
        console.log('maxPriceParams',maxPriceParams);
        console.log('sourceTypeParams',sourceTypeParams);

        window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams + minPriceParams + maxPriceParams + sourceTypeParams;
    }
}

function removeSearchFilter(type, value) {
    const params = new URLSearchParams(window.location.search);
    let brandsParams = (params.get('brand') !== null) ? '&brand=' + params.get('brand') : '';
    let modelsParams = (params.get('model') !== null) ? '&model=' + params.get('model') : '';
    let sourceParams = (params.get('sourceName') !== null) ? '&sourceName=' + params.get('sourceName') : '';

    if (type === 'brand') {
        let brands;
        if (params.get('brand').indexOf(',') > 0) {
            brands = params.get('brand').replace(`${value},`, '');
            brands = brands.replace(`,${value}`, '');
        } else {
            brands = params.get('brand').replace(`${value}`, '');
        }
        brandsParams = '&brand=' + encodeURIComponent(brands);

    } else if (type === 'model') {
        let models;
        if (params.get('model').indexOf(',') >= 0) {
            models = params.get('model').replace(`${value},`, '');
            models = models.replace(`,${value}`, '');
        } else {
            models = params.get('model').replace(`${value}`, '');
        }
        modelsParams = '&model=' + encodeURIComponent(models);
    } else if (type === 'source') {
        let sources;
        if (params.get('sourceName').indexOf(',') >= 0) {
            sources = params.get('sourceName').replace(`${value},`, '');
            sources = sources.replace(`,${value}`, '');
        } else {
            sources = params.get('sourceName').replace(`${value}`, '');
        }
        sourceParams = '&sourceName=' + encodeURIComponent(sources);
    } 
    var q = params.get('q');
    var sourceType = params.get('sourceType');

    let queryParams = '';
    if (q) {
        queryParams = '&q=' + encodeURIComponent(q);
    }

    if (type === 'query') {
        queryParams = '&q=';
    }

    let sourceTypeParams = '';
    if (sourceType) {
        sourceTypeParams = '&sourceType=' + encodeURIComponent(sourceType);
    }
    var minPriceParams = (params.get('priceFrom') !== null) ? '&priceFrom=' + params.get('priceFrom') : '';
    var maxPriceParams = (params.get('priceTo') !== null) ? '&priceTo=' + params.get('priceTo') : '';
    console.log('brandsParams',brandsParams);
    console.log('modelsParams',modelsParams);
    console.log('sourceParams',sourceParams);
    console.log('queryParams',queryParams);
    console.log('minPriceParams',minPriceParams);
    console.log('maxPriceParams',maxPriceParams);
    console.log('sourceTypeParams',sourceTypeParams);
    window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams + minPriceParams + maxPriceParams + sourceTypeParams;

}

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
    var queryParams = '';
    if (q) {
        queryParams = '&q=' + encodeURIComponent(q);
    }
    var sourceType = params.get('sourceType');
    let sourceTypeParams = '';

    if (sourceType) {
        sourceTypeParams = '&sourceType=' + encodeURIComponent(sourceType);  
    }

    var minPriceParams = minPrice > 0 ? '&priceFrom=' + minPrice : '';
    var maxPriceParams = maxPrice < 1000000 ? '&priceTo=' + maxPrice : '';
    var brandsParams = brandList.length > 0 ? '&brand=' + encodeURIComponent(brandList.join(',')) : '';
    var modelsParams = modelList.length > 0 ? '&model=' + encodeURIComponent(modelList.join(',')) : '';
    var sourceParams = sourceList.length > 0 ? '&sourceName=' + encodeURIComponent(sourceList.join(',')) : '';

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


function search(){
    var searchParam = encodeURIComponent(document.getElementById('header-search-textbox').value);
    var sourceTypeCheckedBoxes = document.querySelectorAll('input[name=source-search-checkbox]:checked');
    var sourceTypes = [];

    for(var i=0; sourceTypeCheckedBoxes[i]; ++i){
        sourceTypes.push(sourceTypeCheckedBoxes[i].value);
    }

    var sourceParams = sourceTypes.length > 0 ? '&sourceType='+encodeURIComponent(sourceTypes.join(',')) : '';

    console.log('/search?q='+searchParam+sourceParams);
    window.location.href = '/search?q='+searchParam+sourceParams;
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
