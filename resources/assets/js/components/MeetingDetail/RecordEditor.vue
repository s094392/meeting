<template>
  <div class="markdown-editor">
    <button class="uk-button uk-button-primary uk-align-right edit-button"
            @click="finishEdit">完成</button>
    <textarea ref="textarea"></textarea>

    <div ref="backup-modal" class="uk-modal-container" uk-modal="bg-close: false;esc-close: false;">
      <div class="uk-modal-dialog">
        <div class="uk-modal-header">
          <h4>以下為上次未完成的紀錄<br>是否回復紀錄？</h4>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>
          <span class="pre-wrap">{{ backupRecord }}</span>
        </div>
        <div class="uk-modal-footer uk-text-right">
          <button class="uk-button uk-button-default uk-modal-close" type="button">放棄</button>
          <button class="uk-button uk-button-primary" type="button"
                  @click="restoreRecord">回復</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import "~easymde/dist/easymde.min.css";
.edit-button {
  margin: 5px 5px 0 0;
  z-index: 5;
  position: relative;
}
</style>

<style>
  @import "https://use.fontawesome.com/releases/v5.3.1/css/all.css";
</style>

<script>
import EasyMDE from 'easymde';

export default {
  props: ['value', 'renderedHTML', 'meeting'],
  data() {
    return {
      backupRecord: '',
    };
  },
  mounted() {
    this.$store.commit('startEditRecord');
    this.checkLocalStorage();
    this.init();
  },
  methods: {
    checkLocalStorage() {
      this.backupRecord = localStorage.getItem(`${this.meeting.id}_record`);
      if (this.backupRecord !== null) {
        UIkit.modal(this.$refs['backup-modal']).show();
      }
    },
    restoreRecord() {
      this.$emit('input', this.backupRecord);
      UIkit.modal(this.$refs['backup-modal']).hide();
    },
    init() {
      const self = this;
      this.easymde = new EasyMDE({
        autoDownloadFontAwesome: false,
        element: this.$refs.textarea,
        initialValue: self.value,
        spellChecker: false,
        previewRender() {
          return self.renderedHTML;
        },
      });
      this.easymde.codemirror.on('change', () => {
        this.$emit('input', this.easymde.value());
      });
    },
    saveRecord() {
      this.$store.commit('startLoad');
      axios.put(`/api/meetings/${this.meeting.id}`, {
        record: this.meeting.record,
      }).then(() => {
        this.edit = false;
        localStorage.removeItem(`${this.meeting.id}_record`);
        this.$store.commit('endLoad');
      });
    },
    finishEdit() {
      this.saveRecord();
      this.$emit('finish');
      this.$store.commit('endEditRecord');
    },
  },
  destroyed() {
    this.easymde = null;
  },
  watch: {
    value(val) {
      if (val === this.easymde.value()) return;
      this.easymde.value(val);
    },
    renderedHTML() {
      const preview = document.getElementsByClassName('editor-preview-active-side')[0];
      if (preview) preview.innerHTML = this.renderedHTML;
    },
  },
};
</script>
