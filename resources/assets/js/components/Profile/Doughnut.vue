<script>
import { Doughnut } from 'vue-chartjs';

export default {
  extends: Doughnut,
  props: ['timePerGroup'],
  watch: {
    timePerGroup() {
      this.updateChart();
    },
  },
  mounted() {
    this.updateChart();
  },
  methods: {
    updateChart() {
      let pairs = _.toPairs(this.timePerGroup);
      pairs = _.sortBy(pairs, el => el[0]);
      this.renderChart({
        labels: pairs.map(el => el[0]),
        datasets: [
          {
            backgroundColor: [
              '#e6194b',
              '#3cb44b',
              '#ffe119',
              '#4363d8',
              '#f58231',
              '#911eb4',
              '#46f0f0',
              '#f032e6',
              '#bcf60c',
              '#fabebe',
              '#008080',
              '#e6beff',
              '#9a6324',
              '#fffac8',
              '#800000',
              '#aaffc3',
              '#808000',
              '#ffd8b1',
              '#000075',
              '#808080',
            ],
            data: pairs.map(el => el[1]),
          },
        ],
      });
    },
  },
};
</script>
