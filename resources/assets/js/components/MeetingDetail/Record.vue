<template>
<div>
    <button class="uk-button uk-button-primary uk-align-right edit-button" v-if="canModify && !edit" @click="edit = true">編輯</button>
    <button class="uk-button uk-button-primary uk-align-right edit-button" v-if="canModify && edit" @click="saveClicked">完成</button>
  <VueMarkdown v-if="!edit" :toc-anchor-link="false" :toc="true" toc-id="toc" :source="meeting.record" />
  <markdown-editor v-if="edit" v-model="meeting.record" :configs="configs" ref="markdownEditor"></markdown-editor>
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
import VueMarkdown from "vue-markdown";
import markdownEditor from "vue-simplemde/src/markdown-editor";
import { mapState } from "vuex";

export default {
  props: ["meeting"],
  computed: {
    canModify: function() {
      return (
        this.meeting.status != this.$meetingStatus.Archive &&
        this.meeting.status != this.$meetingStatus.Initialize &&
        this.meeting.owner == this.user.user_id
      );
    },
    ...mapState(["user"])
  },
  data() {
    return {
      edit: false,
      recordTimer: "",
      configs: {
        spellChecker: false
      }
    };
  },
  components: {
    VueMarkdown,
    markdownEditor
  },
  created: function() {
    this.recordTimer = setInterval(this.saveRecord, 10000);
  },
  beforeDestroy: function() {
    clearInterval(this.recordTimer);
  },
  methods: {
    saveClicked: function() {
      this.saveRecord();
      this.edit = false;
    },
    editClicked: function() {
      this.edit = true;
    },
    saveRecord: function() {
      if (this.edit) {
        axios.put(`/api/meeting/${this.meeting.id}`, {
          record: this.meeting.record
        });
      }
    }
  }
};
</script>
