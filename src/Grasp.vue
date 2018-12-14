<template>
	<li id='grasp'>
		<div class='grasp-container'>
			<a href='#' class='ab-item grasp-container__trigger' @click="toggleMenu($event)">
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
		toggleMenu: function(event){
			event.preventDefault();
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
		max-height: calc( 100vh - 80px);
		overflow-y: scroll;
	}

	#grasp .grasp-container__trigger:hover, #grasp .grasp-container__trigger:focus{
		background: #32373c;
	}
</style>