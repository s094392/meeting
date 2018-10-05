<template>
<div class="uk-overflow-auto">
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && !edit" @click="edit = true">編輯</button>
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && edit" @click="saveClicked">完成</button>
  <div class="meeting-record" v-if="!edit" v-html="renderedHTML">
  </div>
  <markdownEditor v-if="edit" v-model="meeting.record" :configs="configs"
                   ref="markdownEditor"></markdownEditor>
</div>
</template>

<style lang="scss" scoped>
@import "~simplemde/dist/simplemde.min.css";
.edit-button {
  margin: 5px 5px 0 0;
  z-index: 5;
  position: relative;
}
</style>


<script>
import markdownIt from 'markdown-it';
import { mapState } from 'vuex';
import markdownEditor from 'vue-simplemde/src/markdown-editor';
import markdownItTocAndAnchor from 'markdown-it-toc-and-anchor';

export default {
  props: ['view', 'meeting'],
  computed: {
    canModify() {
      return (
        this.meeting.status <= this.$meetingStatus.End
        && this.meeting.owner_id === this.user.user_id
      );
    },
    meetingRecord() {
      return this.meeting.record;
    },
    ...mapState(['user']),
  },
  watch: {
    meetingRecord() {
      this.renderedHTML = this.md.render(this.meeting.record);
      const preview = document.getElementsByClassName('editor-preview-active-side')[0];
      if (preview) preview.innerHTML = this.renderedHTML;
    },
    view() {
      if (this.view !== 'record' && this.edit) {
        this.saveClicked();
      }
    },
  },
  data() {
    const self = this;
    return {
      edit: false,
      recordTimer: setInterval(this.saveRecord, 30000),
      renderedHTML: '',
      md: markdownIt({
        html: true,
        linkify: true,
        typographer: true,
      }).use(markdownItTocAndAnchor, {
        tocCallback(tocMarkdown, tocArray, tocHtml) {
          document.getElementById('toc').innerHTML = tocHtml;
        },
        anchorLink: false,
      }),
      configs: {
        spellChecker: false,
        previewRender() {
          return self.renderedHTML;
        },
      },
    };
  },
  components: {
    markdownEditor,
  },
  mounted() {
    this.renderedHTML = this.md.render(this.meeting.record);
  },
  beforeDestroy() {
    clearInterval(this.recordTimer);
  },
  methods: {
    saveClicked() {
      this.saveRecord();
      this.edit = false;
    },
    editClicked() {
      this.edit = true;
    },
    saveRecord() {
      if (this.edit) {
        axios.put(`/api/meetings/${this.meeting.id}`, {
          record: this.meeting.record,
        });
      }
    },
  },
};
</script>
