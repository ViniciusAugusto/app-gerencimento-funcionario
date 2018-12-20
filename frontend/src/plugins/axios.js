import axios from 'axios'

export default ({ Vue }) => {
  axios.defaults.headers.common = {
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Credentials': 'true'
  }
  Vue.prototype.$axios = axios
}
