import './bootstrap';
import route from 'ziggy-js';
import { Ziggy } from './ziggy';

// Make route() function globally available
window.route = (name, params = {}, absolute = true) => {
    return route(name, params, absolute, Ziggy);
};

// Optional: Add global Vue/React integration examples
// For Vue.js:
// Vue.prototype.$route = window.route;

// For React (if using):
// export const useRoute = () => window.route;