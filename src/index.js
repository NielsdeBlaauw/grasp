import Vue from 'vue';
import Grasp from './Grasp.vue';

wp.api.init( { 'versionString' : 'grasp/v1/' } );

wp.api.loadPromise.done(function() {
	wp.api.models.ImageChecker = Backbone.Model.extend({
		get_displayed_alt: function(){
			return jQuery('[src="'+this.attributes.url+'"]').attr('alt');
		}
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
		
			beforeMount() {
				
			}
		});
	});
});