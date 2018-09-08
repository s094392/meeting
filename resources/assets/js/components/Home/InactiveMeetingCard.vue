<template>
<div>
	<div class="uk-margin-small-bottom uk-card-default uk-card uk-card-body uk-card-small">
		<p><router-link :to="{name:'detail', params: {id: 1, view: 'data'}}">
			{{meeting.title}}
		</router-link>
		<br>
		{{meeting.end_time}}
		</p>
	</div>
</div>
</template>


<script>
export default {
  props: ["meeting"]
};
</script>
