import axios from 'axios';
import {store} from '../../store/token';

export default axios.create({
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': store.state.accessToken
  }
});
