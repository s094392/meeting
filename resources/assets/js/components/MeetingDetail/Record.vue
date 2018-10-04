<template>
<div class="uk-overflow-auto">
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && !edit" @click="edit = true">編輯</button>
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            v-if="canModify && edit" @click="saveClicked">完成</button>
  <div class="meeting-record">
    <VueMarkdown v-if="!edit && mounted" :toc-anchor-link="false" :toc="true"
                 toc-id="toc" :source="meeting.record"/>
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
import VueMarkdown from 'vue-markdown';
import markdownEditor from 'vue-simplemde/src/markdown-editor';
import { mapState } from 'vuex';

export default {
  props: ['meeting'],
  computed: {
    canModify() {
      return (
        this.meeting.status <= this.$meetingStatus.End
        && this.meeting.owner_id === this.user.user_id
      );
    },
    ...mapState(['user']),
  },
  mounted() {
    this.mounted = true;
  },
  data() {
    return {
      edit: false,
      recordTimer: '',
      configs: {
        spellChecker: false,
      },
      mounted: false,
    };
  },
  components: {
    VueMarkdown,
    markdownEditor,
  },
  created() {
    this.recordTimer = setInterval(this.saveRecord, 30000);
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
