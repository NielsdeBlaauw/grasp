<template>
	<ul class='grasp-list'>
		<li class='grasp-list__item' v-for="item in items" :key='item.id'>
			<img style='height: 32px; width: 32px' :src='item.attributes.thumbnail[0]' />
			<div v-if='item.attributes.alt.length === 0'>No alt text! This is a missed opportunity.</div>
			<div v-else-if='item.get_displayed_alt().length === 0'>You have an alt text, but it's not shown on your site. Your work is going to waste.</div>
			<div v-else-if='item.get_displayed_alt() !== item.attributes.alt'>The plugin or theme is showing a different alt text then you defined. This might be hurting your user experience and SEO.</div>
			<div v-else>This image is fine!</div>
		</li>
	</ul>
</template>
<script>
export default {
	props: {
		items: Array
	}
}
</script>
<style>
#grasp .grasp-list__item{
	float: none;
	display: flex;
}

#grasp .grasp-list__item > div{
	line-height: 20px;
	align-self: center;
}

#grasp .grasp-list__item ~ .grasp-list__item{
	margin-top: 5px;
	padding-top: 5px;
	border-top: 1px solid #444;
}

#grasp .grasp-list__item img{
	margin-right: 5px;
	align-self: center;
}
</style>