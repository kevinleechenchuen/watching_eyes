jQuery(document).ready(function () {
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
    var brandsParams = brandList.length > 0 ? '&brand=' + brandList.join(',') : '';
    var modelsParams = modelList.length > 0 ? '&model=' + modelList.join(',') : '';
    var sourceParams = sourceList.length > 0 ? '&sourceName=' + sourceList.join(',') : '';

    window.location.href = '/search?' + brandsParams + modelsParams + sourceParams + queryParams;
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

// function scrollContainer(container, direction) {
//     console.log(container, direction);
//     if (direction === 'left') {
//         jQuery(container).animate({ scrollRight: "+=" + 500 });
//     } else {
//         jQuery(container).animate({ scrollRight: "-=" + 500 });
//     }
// }
