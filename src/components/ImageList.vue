<template>
	<div class='container'>
		<div class='grasp-detail' :class='activeItem.get_class()' v-if='activeItem'>
			<div class='grasp-detail__header'>
				<div class='grasp-icon'><span class="ab-icon"></span></div>
				<p v-if='!activeItem.wp_has_alt()'><b>No alt text in WordPress</b><br />Alt texts are good for accessibility and SEO.</p>
				<p v-else-if='!activeItem.has_alt_on_page()'><b>Alt not showing correctly</b><br />You have an alt text. But it is not used on the current page.</p>
				<p v-else-if='!activeItem.wp_alt_same_as_on_page()'><b>Different alt showing</b><br />The plugin or theme is showing a different alt then you entered.</p>
				<p v-else>Fully optimised</p>
			</div>
			<img class='grasp-detail__image' :src='activeItem.attributes.url' role='presentation' />
			<div class='grasp-detail__content'>
				<div v-if='!activeItem.wp_has_alt()'>
					<p>This image does not have an alt text in your WordPress installation. An alt text is used to describe what the image you are using is about.</p>
					<p>&nbsp;</p>
					<p><b>Why do you need an alt text?</b></p>
					<p>- Search engines use this text to known when your image is relevant to searchers. Adding a good alt text will get more views on your images and site.</p>
					<p>- Visitors with screen-readers and other accessibility tools use this text to know what the rich media on your page is about.</p>
					<p>&nbsp;</p>
					<p><b>Fix it now</b></p>
					<input type='text' v-model='activeImage.attributes.alt_text'/>
					<button @click='submitActiveImage(activeImage)'>Save</button>
				</div>
			</div>
			<button @click='activateItem(false, $event)'>Back to overview</button>
		</div>
		<ul v-else class='grasp-list'>
			<li class='grasp-list__wrapper' v-for="item in items" :key='item.id'>
				<a href='#' class='grasp-list__item' :class='item.get_class()' @click='activateItem(item, $event)'>
					<img class='grasp-item__image' role='presentation' style='' :src='item.attributes.thumbnail[0]' />
					<div class='grasp-item__outline'>
						<div class='grasp-item__description'>
							<p v-if='!item.wp_has_alt()'><b>No alt text in WordPress</b><br />Alt texts are good for accessibility and SEO.</p>
							<p v-else-if='!item.has_alt_on_page()'><b>Alt not showing correctly</b><br />You have an alt text. But it is not used on the current page.</p>
							<p v-else-if='!item.wp_alt_same_as_on_page()'><b>Different alt showing</b><br />The plugin or theme is showing a different alt then you entered.</p>
							<p v-else>Fully optimised</p>
						</div>
						<div class='grasp-icon'><span class="ab-icon"></span></div>
					</div>
				</a>
			</li>
		</ul>
	</div>
</template>
<script>
export default {
	data: function(){
		return {
			activeItem: false,
			activeImage: false
		}
	},
	props: {
		items: Array
	},
	methods: {
		activateItem: function( item, event ){
			event.preventDefault();
			this.activeItem = item;
			if(item){
				this.activeImage = new wp.api.models.Media({id: item.id});
				this.activeImage.fetch();
			}else{
				this.activeImage = false;
			}
		},
		submitActiveImage: function(image){
			image.attributes.status = 'publish';
			image.save();
		}
	}
}
</script>
<style>
#grasp .grasp-detail__image{
	width: 100%;
	max-height: 180px;
	object-fit: cover;
}

#grasp .grasp-detail__header{
	display: flex;
	padding: 21px 16px 16px;
	align-items: center;
}

#grasp .grasp-detail__content{
	padding: 16px;
}

#grasp .grasp-detail__header .grasp-icon .ab-icon{
	margin-right: 16px !important;
	font-size: 40px !important;
}

#grasp .grasp-item__description{
	flex-grow: 1;
	margin-top: -4px;
}

#grasp .grasp-list__wrapper:last-child .grasp-item__outline{
	border-bottom: none;
}

#grasp .grasp-item__image{
	height: 40px; 
	width: 40px; 
	padding-bottom: 16px;
}

#grasp .grasp-list{
	padding: 8px 0;
}

#grasp .grasp-list__item--okay .grasp-item__image{
	padding-bottom: 8px;
}

#grasp .grasp-item__outline{
	display: flex;
	flex-grow: 1;
	border-bottom: 1px solid #32373c;
	padding-bottom: 16px;
}
#grasp:hover ul li a, #grasp:hover ul li .ab-icon:before{
	color: inherit;
}
#grasp .grasp-list__item--okay .grasp-icon {
	align-self: center;
	color: #A1F9BA;
}
#grasp .grasp-list__item--critical .grasp-icon {
	color: #F9A1A1;
}
#grasp .grasp-list__item--warning .grasp-icon {
	color: #FAF9BB;
}
#grasp .grasp-list__item--okay .ab-icon:before {
    content: "\f502";
	color: inherit;
}
#grasp .grasp-list__item--critical .ab-icon:before {
    content: "\f153";
	color: inherit;
}
#grasp .grasp-list__item--warning .ab-icon:before {
    content: "\f534";
	color: inherit;
}

#grasp .grasp-list__wrapper .grasp-icon{
	margin-left: 16px;
}

#grasp .grasp-icon .ab-icon{
	margin-right: 0 !important;
	padding: 0 !important;
}

#grasp .grasp-list__wrapper{
	float: none;
}

#wpadminbar #grasp .grasp-list__item{
	display: flex;
	height: auto;
	color: #ccc;
	padding: 16px 16px 0;
}

#wpadminbar  #grasp .grasp-list__item--okay{
	padding-top: 8px;
}

#grasp .grasp-list__item:hover,#grasp .grasp-list__item:focus{
	background: #32373c;
}

#grasp .grasp-list__item--okay .grasp-item__description {
	margin-top: 0;
	align-self: center;
}
#grasp .grasp-list__item--okay .grasp-item__outline {
	padding-bottom: 8px;
}

#grasp .grasp-item__description b, #grasp .grasp-detail b{
	font-weight: bold;
}
#grasp .grasp-item__description *, #grasp .grasp-detail *{
	line-height: 20px;
}

#grasp .grasp-list__item img{
	margin-right: 16px;
}
</style>