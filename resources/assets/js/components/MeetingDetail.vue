<template>
<div uk-grid>
  <div class="uk-width-3-4@m">
    <h2>WWW 新生訓練</h2>
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
      <ul uk-tab>
        <li class="uk-active" @click="content = 1">
          <a href="#">
            <span class="uk-text-large uk-text-lead">會議資料</span>
          </a>
        </li>
        <li @click="content = 2">
          <a href="#">
            <span class="uk-text-large uk-text-lead">參與人員</span>
          </a>
        </li>
        <li @click="content = 3">
          <a href="#">
            <span class="uk-text-large uk-text-lead">會議內容</span>
          </a>
        </li>
      </ul>
      <div v-show="content == 1">
        <table class="uk-table uk-table-small ">
          <tr>
            <th >會議名稱:</th>
            <td>NET Meeting 暨 新生報告</td>
          </tr>
          <tr>
            <th>會議分類:</th>
            <td>Network</td>
          </tr>
          <tr>
            <th>預定開始時間:</th>
            <td>Not set</td>
          </tr>
          <tr>
            <th>開始時間:</th>
            <td>2018-08-16 19:36:03</td>
          </tr>
          <tr>
            <th>結束時間:</th>
            <td>Not set</td>
          </tr>
          <tr>
            <th>發起人:</th>
            <td>calee (李家安)</td>
          </tr>
          <tr>
            <th>會議狀態:</th>
            <td>會議結束，但會議記錄未確認</td>
          </tr>
          <tr>
            <th>會議時數:</th>
            <td>270 分鐘</td>
          </tr>
          <tr>
            <th>會議說明:</th>
            <td>我要吃雞雞叫 雞雞叫的菜單呢</td>
          </tr>
        </table>
        <hr class="uk-divider-icon">
        <MeetingControl />
      </div>

      <div v-show="content == 2">
        <h3>準時成員</h3>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>tzuyu</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>ycchang</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yaowen</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yahsieh</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
        <h3>遲到成員</h3>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>yahsieh</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
        <h3>早退成員</h3>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color">
            <span uk-icon="plus"></span>
          </button>
        <h3>請假成員</h3>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wangth</button>
        <h3>翹咪成員</h3>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>wwchung</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>syujy</button>
          <button class="uk-button uk-button-default uk-button-small disabled-normal-color" disabled>youwei1129</button>
      </div>
      <VueMarkdown v-show ="content == 3" toc="true" toc-id="toc" toc-class="uk-list uk-list-bullet" >
  ## Processing Jobs
  - calee
  ** 切網段規則 (8/16)
  ** Colocation 新規劃
  ** 網管訓練 -- 網路 debug SOP (8/31)
  ** 小內網整理
  ==== 小內網 EC318
  ==== 防火牆規則
  ==== 小內網 NAT ip 209 轉 235
  ==== IPMI 網路
  - syujy
  ** cacti (8/31)
  ** 2.4 G 取締
  ==== DEADLINE: 9/21
  ==== 發信: 8/23
  ==== 網管訓練宣導: 9/7
  ==== 開始取締實驗室: 21
  ** 網管訓練 -- 工三實驗室網路架構 (8/31)
  ** 網管訓練 -- cacti 使用 (8/31)
  ** 172.17 下線
  - wwchung
  ** tacacs+
  - yahsieh
  ** PRTG
  ** Cisco Switch 安全設定 survey
  - yaowen
  ** wifi 維護公告 (8/20)
  ** nagios 新架構
  ==== 8/20 前重灌 netmon
  ==== 8/22 前設定完成 nagios
  ** net 組服務優先序、dead lock (8/22)
  ** 網管訓練 -- colocation 申請流程、進出規則、使用資源規範 (8/31)
  - youwei1129
  ** EC037 網路架構 (8/31)
  ** 2018 網管調查
  ** 網管訓練 -- 資安通報流程 (8/31)
  - 各樓層
  ** 2960/3750 config 確認
  - 各機器負責人

  ## 本日大綱:
  - 新生報告
  - PRTG 進度報告
  - EC037 網路架構規劃
  - 實驗室網路架構 (N7K)
  - 切網段規則
  - CCNA 考試
  - nagios 簡單報告
  - net 組服務優先序 (忘記了)
  - 8/25, 26 斷電
  - 8/22 wifi
  - 2.4G 取締 (syujy)
  - 兩天內報 JOB
  - 新 colocation 規則
  - 小內網進度

  ====================
  ## Schedule
  8/10
  - NCTU Wireless 貼紙 (O)
  - Core Router 備援 (8/10 -> 235)
  - VPN 方案 (送交 團長)
  - PC Room 網路架構 (等 1G 光網卡)
  - pm2.5 (回報壞掉 1 台)
  8/31
  - 內網整理
  - EC037
  - cacti + weather map
  - PRTG
  9/21
  - New Colocation 規劃、規範 calee
  - Colocation IPMI

  ====================
  ## New job
  - KVM 規劃
  - config 備份 daemon
  - Colocation port security

  ====================
  呆 Job (大禮包 Queue)
  - wiki 整理
  - KVM 整理
  - IP 分配表整理
  - DHCP 重建

  ## 臨時動議

  ## 提醒
  ** 時數建議當天做完馬上填寫，並且詳細紀錄過程、Debug、日期、時間 **
  * 把 job 當 log 寫，把 wiki 當 code 寫
  * 寫 wiki、上 gitlab

  - 2960 config
  == 2960 / 3750 留 physical interface description: 查線，有線的都要留 des 到哪一個 int，請不要直接用 sh int status，沒有線的 interface default 掉並 disable，description 要知道連到哪一間實驗室，不需要知道教授 (教授是跟 vlan 的) ex. ### 318 ###
  == 2960 / 3750 確認 enable 密碼有存在
  == 3750 vlan 要有 description，井字號，哪一間實驗室，哪一個教授 ex. ### 318 cscc's lab ###
  == 如果 2960 沒在使用的 vlan 請把 uplink trunk 中拿掉
  == 2960 uplink 到 3750 要用 port-channel
  == 2960-3750, 3750-3750, 3750-N9K 檢查一下是用 port-channel
  == 端點 no cdp enable
  == VLAN 是否有帶錯
  == no lldp trasmit
  == vlan 1 shutdown
  == wiki net 2960 上基本設定確認都有: https://help.cs.nctu.edu.tw/wiki/index.php?title=Cisco_2960%E8%A8%AD%E5%AE%9A
  == wiki net 3750 上基本設定確認都有: https://help.cs.nctu.edu.tw/wiki/index.php?title=Cisco_3750%E8%A8%AD%E5%AE%9A

  - CSCC 使用網段 切割規則
  == 網段: 17, 23, 88, 168, 235
  == 分區
  **** vhosting
  **** YCC
  **** NASA
  **** TA in VM
  **** lxc
  **** TA in EC318
  **** tmachine (tlinux 15, tbsd 15, tmail 5, twww ?, tnet ?)

  - VPN Spec.
  == 支援 SSL VPN
  == NTD 10w 以下
  == 30 - 50 人 / 20 人 同時在線
  == 支援 LDAP
  == 支援 Windows, mac, Linux
  == 支援 mobile (optional)
  == 控制不同路由不同存取權限
  == 100M throughput (如果 feature, 也可以考慮 10M)
  == cisco / juniper / fortinet

  ## 備註:
  - 網管部分討論
  **** 網管交接事項
  **** 網管須知
  **** mail group
  **** 網路 debug SOP
  **** 工三網路架構
  **** 機房進出流程、規則

  ## 下次 Meeting:
  8/22 19:30
  -----
  OSPF Loopback IP
  EC B1, 1F yaowen
  EC 3F,4F calee
  EC 5F, 6F, 7F yahsieh, youwei1129
  EIC 7F syujy

  netmon -- calee
  prtg -- syujy
  dhcp -- yaowen
      </VueMarkdown>
    </div>
  </div>

  <div class="uk-width-1-4@m" v-show="content==3">
    <h4>目錄</h4>
    <div class="uk-card uk-card-small uk-card-default uk-card-body" id="toc" uk-sticky="offset:40;"></div>
  </div>
</div>

</template>

<style lang="scss">
.disabled-normal-color {
  color: #333 !important;
}
</style>


<script>
import VueMarkdown from "vue-markdown";
import MeetingControl from "./MeetingControl";

export default {
  data: function() {
    return {
      content: 1
    };
  },
  components: {
    VueMarkdown,
    MeetingControl
  }
};
</script>