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

    var brandsParams = brandList.length > 0 ? '&brand=' + brandList.join(',') : '';
    var modelsParams = modelList.length > 0 ? '&model=' + modelList.join(',') : '';
    var sourceParams = sourceList.length > 0 ? '&sourceName=' + sourceList.join(',') : '';

    window.location.href = '/search?' + brandsParams + modelsParams + sourceParams;
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


