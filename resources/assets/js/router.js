import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import ExampleComponent from './components/ExampleComponent'

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: '/',
        },
        {
            path: '/hello',
            name: 'hello',
            component: ExampleComponent,
        }
    ]
})
