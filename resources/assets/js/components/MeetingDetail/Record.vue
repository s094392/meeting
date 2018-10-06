<template>
<div class="uk-overflow-auto">
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && !edit" @click="startEdit">編輯</button>
  <div class="meeting-record" v-if="!edit" v-html="renderedHTML">
  </div>
  <component v-if="edit" :is="recordEditor" v-model="meeting.record"
            :renderedHTML="renderedHTML" :meeting="meeting" @finish="edit = false">
  </component>
</div>
</template>

<style lang="scss" scoped>
.edit-button {
  margin: 5px 5px 0 0;
  z-index: 5;
  position: relative;
}
</style>


<script>
import markdownIt from 'markdown-it';
import { mapState } from 'vuex';
import markdownItTocAndAnchor from 'markdown-it-toc-and-anchor';

export default {
  props: ['meeting'],
  methods: {
    startEdit() {
      this.$store.commit('startLoad');
      import('./RecordEditor' /* webpackChunkName: "js/mde" */).then((mde) => {
        this.edit = true;
        this.recordEditor = mde;
        this.$store.commit('endLoad');
      });
    },
  },
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
    ...mapState(['user', 'loading']),
  },
  watch: {
    meetingRecord() {
      this.renderedHTML = this.md.render(this.meeting.record);
    },
  },
  data() {
    return {
      edit: false,
      renderedHTML: '',
      recordEditor: null,
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
    };
  },
  mounted() {
    this.renderedHTML = this.md.render(this.meeting.record);
  },
};
</script>
