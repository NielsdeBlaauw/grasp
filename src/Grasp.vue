<template>
	<li id='grasp'>
		<div class='grasp-container'>
			<a href='#' class='ab-item grasp-container__trigger' v-on:click="toggleMenu">
				Grasp
			</a>
			<div v-if="active" class='grasp-container__content'>
				<grasp-content />
			</div>
		</div>
	</li>
</template>

<script>
import GraspContent from './components/GraspContent.vue'
export default {
	components: {
		'grasp-content': GraspContent,
	},
	data: function(){
		return {
			active: false
		}
	},
	methods: {
		toggleMenu: function(){
			this.active = ! this.active;
		}
	}
}
</script>

<style>
	#grasp .grasp-container__content{
		background: #23282d;
		border-radius: 0 0 5px 5px;
		max-width: 320px;
	}
</style>