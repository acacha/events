// Register components
Vue.component('events-example', require('./components/EventsExampleComponent.vue'));
Vue.component('users', require('./components/Users.vue'));

import { config } from './config/events'

window.acacha_events = {}
window.acacha_events.config = config