<template>
	<div class='grasp-content'>
		<div v-if='loading' class='grasp-content__loader'>Checking images on current page...</div>
		<div class='grasp-content__list'>
			<image-list :items='items'/>
		</div>
	</div>
</template>
<script>
import ImageList from './ImageList.vue'
export default {
	components: {
		'image-list': ImageList,
	},
	data: function(){
		return {
			items: [],
			loading: true,
		}
	},
	beforeMount: function(){
		var self = this;
		this.items = [];
		this.loading = true;
		var imageChecker = new wp.api.collections.ImageChecker();
		var image_urls = [];
		jQuery('img').each(function(el){
			var src = jQuery(this).attr('src');
			if( src.search(document.domain) !== -1 ){
				image_urls.push(src);
			}
		});
		imageChecker.fetch({data:{'images':image_urls}}).then(function(){
			self.items = imageChecker.models;
			self.loading = false;
		});
	}
}
</script>
<style>
</style>