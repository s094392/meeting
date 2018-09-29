<script>
import Multiselect from 'vue-multiselect';

export default {
  extends: Multiselect,
  props: {
    selectedLabel: {
      default: '✓',
    },
    selectLabel: {
      default: '⏎',
    },
    deselectLabel: {
      default: '✗',
    },
    placeholder: {
      default: '請選擇',
    },
  },
};
</script>
