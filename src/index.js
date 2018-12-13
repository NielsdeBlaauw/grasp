import Vue from 'vue';
import Grasp from './Grasp.vue';

wp.api.init( { 'versionString' : 'grasp/v1/' } );

wp.api.loadPromise.done(function() {
	wp.api.models.ImageChecker = Backbone.Model.extend({
		get_displayed_alt: function(){
			return jQuery('[src="'+this.attributes.url+'"]').attr('alt');
		},
		get_class: function(){
			if( ! this.wp_has_alt() ){
				return 'grasp-list__item--critical';
			}
			if( ! this.has_alt_on_page() ){
				return 'grasp-list__item--warning';
			}
			if( ! this.wp_alt_same_as_on_page() ){
				return 'grasp-list__item--warning';
			}
			return 'grasp-list__item--okay';
		},
		wp_has_alt(){
			return this.attributes.alt.length > 0;
		},
		
		has_alt_on_page(){
			return this.get_displayed_alt().length > 0;
		},

		wp_alt_same_as_on_page(){
			return this.attributes.alt === this.get_displayed_alt();
		},
	});

	wp.api.collections.ImageChecker = wp.api.collections.ImageChecker.extend({
		model: function(attrs, options){
			return new wp.api.models.ImageChecker( attrs, options );
		}
	});

	window.addEventListener('load', function () {

		document.Grasp = new Vue({
			el: '#wp-admin-bar-grasp_container',
			render: h => h(Grasp),
		});
	});
});