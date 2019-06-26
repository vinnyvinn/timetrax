
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
//
require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));
// Vue.component('attendance-index', require('./components/attendance/index.vue'));
Vue.component('role-index', require('./components/role/index.vue'));
Vue.component('overtime-index', require('./components/overtime/index.vue'));

// const app = new Vue({
//     el: 'body',
//     data: {
//         attendances: {},
//         overtime: []
//     },
    // computed: {
    //     totalOvertime() {
    //         var amount = [];
    //         for (var key in this.overtime) {
    //             var index = Object.keys(this.overtime).indexOf(key);
    //             amount[index] = 0;
    //             for(var i = 0; i < this.overtime[key].length; i++) {
    //                 amount[index] += this.overtime[key][i].total_earned;
    //             }
    //         }
    //
    //         return amount;
    //     }
//     }
// });

window.vm = app;
require('./custom');
