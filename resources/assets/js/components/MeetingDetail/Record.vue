<template>
<div class="uk-overflow-auto">
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && !edit" @click="edit = true">編輯</button>
  <div class="meeting-record" v-if="!edit" v-html="renderedHTML">
  </div>
  <RecordEditor v-if="edit" v-model="meeting.record" :renderedHTML="renderedHTML"
                :meeting="meeting" @finish="edit = false"></RecordEditor>
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
import RecordEditor from './RecordEditor';

export default {
  props: ['meeting'],
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
      localStorage.setItem(`${this.meeting.id}_record`, this.meetingRecord);
      this.renderedHTML = this.md.render(this.meeting.record);
    },
  },
  data() {
    return {
      edit: false,
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
    };
  },
  components: {
    RecordEditor,
  },
  mounted() {
    this.renderedHTML = this.md.render(this.meeting.record);
  },
  methods: {

  },
};
</script>
