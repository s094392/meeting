<template>
<div uk-grid>
  <div class="uk-width-3-4@l">
    <span class="page-title">使用手冊</span>
    <div class="uk-card uk-card-default uk-card-body uk-card-small markdown-body"
         v-html="rederedHtml">
    </div>
  </div>
  <div class="uk-visible@l uk-width-1-4@l">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body toc markdown-body"
         uk-sticky="offset:40;" v-html="tocHtml"></div>
  </div>
</div>
</template>

<script>
import { mavonEditor } from 'mavon-editor';

export default {
  beforeRouteEnter(to, from, next) {
    axios.get('/manual_assets/manual.md').then((response) => {
      next(vm => vm.setData(response.data));
    });
  },
  data() {
    return {
      md: null,
      tocHtml: null,
      rederedHtml: null,
    };
  },
  methods: {
    setData(md) {
      this.md = md;
      const self = this;
      this.rederedHtml = mavonEditor.getMarkdownIt().set({
        html: false,
        linkify: true,
        tocCallback(tocMarkdown, tocArray, tocHtml) {
          self.tocHtml = tocHtml;
        },
      }).render(this.md);
    },
  },
};
</script>
