<template>
<div>
  <div>
    <button class="uk-button uk-button-primary visibility-hidden" >編輯{{aa}}</button>
    <button class="uk-button uk-button-primary uk-align-right" @click="edit = !edit">編輯{{aa}}</button>
  </div>
  <VueMarkdown v-if="!edit" :toc="true" toc-id="toc" toc-class="uk-list uk-list-bullet" :source="meeting.record" />
  <markdown-editor v-if="edit" v-model="meeting.record" :configs="configs" ref="markdownEditor"></markdown-editor>
</div>
</template>

<style>
@import "~simplemde/dist/simplemde.min.css";
</style>


<script>
import VueMarkdown from "vue-markdown";
import markdownEditor from "vue-simplemde/src/markdown-editor";

export default {
  props: ["meeting"],
  data: function() {
    return {
      source: "",
      edit: false,
      configs: {
        spellChecker: false
      }
    };
  },
  components: {
    VueMarkdown,
    markdownEditor
  },
  mounted: function() {
    console.log(this.meeting);
  }
};
</script>
