import Api from '../Api'

export default ({ Vue }) => {
  // we add it to Vue prototype
  Vue.prototype.$Api = Api
}
