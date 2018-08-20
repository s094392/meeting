<template>
<div>
  <div>
    <button class="uk-button uk-button-primary hidden" >編輯</button>
    <button class="uk-button uk-button-primary uk-align-right" @click="edit = !edit">編輯</button>
  </div>
  <VueMarkdown v-if="!edit" :toc="true" toc-id="toc" toc-class="uk-list uk-list-bullet" :source="source" />
  <markdown-editor v-if="edit" v-model="source" :configs="configs" ref="markdownEditor"></markdown-editor>
</div>
</template>

<style>
@import "~simplemde/dist/simplemde.min.css";
.hidden {
  visibility: hidden;
}
</style>


<script>
import VueMarkdown from "vue-markdown";
import markdownEditor from "vue-simplemde/src/markdown-editor";

export default {
  data: function() {
    return {
      source: "",
      edit: false,
      configs: {
        spellChecker: false
      }
    };
  },
  mounted: function() {
    this.source = `**BSD 組咪 - 180815**
===

## 工作站負責人

\- bsd1: yca
\- bsd2: syujy
\- bsd3: fuyu0425
\- bsd4: hchsu0426
\- bsd7: wwchung
\- bsd8: linsc04
\- alumni: hwlin1414
\- builder: linsc04
\- csrdr[01, 02]: zjlin
\- csws[01, 02, 03]: zjlin
\- ccws[01, 02, 03]: zjlin
\- tbsd1: youwei1129
\- tbsd2: jbliao
\- tbsd3: tzute
\- tbsd5: ycliang
\- tbsd6: wengyc
\- tbsd7: kuohh
\- tbsd8: austin
\- tbsd9: tsengcy
\- tbsd10: yuanchen
\- tbsd11: ykzheng


## JOB

### auditd 測試
- 文件

### csbackup 清查 - syujy
- 備份哪些檔案、config
- 文件
- 下次組咪

### nrpe3(Nagios Remote Plugin Executor) - yaowen
- nagios client 端 plugin

### autofs map 更新 - syujy
- 更新工作站 map
- 切兩張 map, 改 soft
- 已完成
- 文件

### FreeBSD 11.2-RELEASE
- builder 編 package
- bsd7 已升至 11.2
- 請大家上去測試

### 測試限制使用者 vmemory 使用量 - jbliao


### periodic mutt 監控權限是否跑掉 - yca

### Survey netgroup 替代方案 - tzute
- 登入權限控管
- sudoers file



## 大禮包

## Discussion

### LDAP NIS 密碼同步
- mail 組吃 NIS, 會不同步, 等 mail 組驗證切成 LDAP
- 備案: 建一台改 password 用的機器
- 目前: 待各組 dependency 處理完，認證再轉

## Announce
### FreeBSD Security Advisory FreeBSD-SA-18:08.tcp
- 聽說 8 月底要停電停兩天

### 新生測驗結果
- 考卷自行找答案，確認完答案跟 zjlin 約時間檢討

### Job 報時數注意事項
- https://help.cs.nctu.edu.tw/wiki/index.php?title=Job%E6%99%82%E6%95%B8%E8%88%87%E5%AF%A9%E6%A0%B8%E6%A8%99%E6%BA%96

## 臨時動議`;
  },
  components: {
    VueMarkdown,
    markdownEditor
  }
};
</script>
