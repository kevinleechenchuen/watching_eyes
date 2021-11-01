<?php
namespace Elementor;
class Filter_Widget extends Widget_Base {

	public function get_name() {
		return 'filter-widget';
	}
	
	public function get_title() {
		return 'filter-widget';
	}
	
	public function get_icon() {
		return 'fa fa-font';
	}
	
	public function get_categories() {
		return [ 'basic' ];
    }
	
	protected function render() {
        echo "<div id='search-filter'>No Filters</div>
            <script>
                function getFilter(){
                    var elem = document.querySelector('#search-filter');
                    var availableFilters = JSON.parse(localStorage.getItem('availableFilters'));

                    var brandHTML = '';
                    for (let brand of availableFilters.brands) {
                        brandHTML = brandHTML + '<div><input type=\"checkbox\" id=' + brand + ' name=\"brandCheckbox\" value=' + brand + '><label for=' + brand + '>' + brand + '</label></div>';
                    }

                    var modelHTML = '';
                    for (let model of availableFilters.models) {
                        modelHTML = modelHTML + '<div><input type=\"checkbox\" id=' + model + ' name=\"modelCheckbox\" value=' + model + '><label for=' + model + '>' + model + '</label></div>';
                    }

                    var sourceHTML = '';
                    for (let source of availableFilters.sources) {
                        sourceHTML = sourceHTML + '<div><input type=\"checkbox\" id=' + source + ' name=\"sourceCheckbox\" value=' + source + '><label for=' + source + '>' + source + '</label></div>';
                    }

                    // elem.innerHTML = brandHTML+'<br>'+modelHTML+'<br>'+sourceHTML;
                    elem.innerHTML = brandHTML+'<br>'+sourceHTML;
                }
                getFilter();

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
                    window.location.href = '/search?brand='+brandList.join(',')+'&model='+modelList.join(',')+'&sourceName='+sourceList.join(',');
                }
            </script>
            <button>CLEAR ALL FILTERS</button>
            <button onclick=\"applyFilter()\">APPLY FILTER</button>";
    }
	
	protected function _content_template() {

    }

    
	
	
}