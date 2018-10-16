<script>
import moment from 'moment';
import store from '../../store';

export default {
  beforeRouteEnter(to, from, next) {
    next({
      name: 'profile',
      params: {
        year: moment().get('year'),
        month: moment().get('month') + 1,
        userId: store.state.user.user_id,
      },
    });
  },
};
</script>
