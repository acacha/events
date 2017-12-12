// Register components
Vue.component('events-example', require('./components/EventsExampleComponent.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('events', require('./components/EventsComponent.vue'));
Vue.component('widget', require('./components/WidgetComponent.vue'));
Vue.component('message', require('./components/MessageComponent.vue'));

import { config } from './config/events'

window.acacha_events = {}
window.acacha_events.config = config