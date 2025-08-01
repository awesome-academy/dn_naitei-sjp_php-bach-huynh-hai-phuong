import axios from 'axios';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'

window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.store('theme', {
    isDark: false,

    toggle() {
        this.isDark = !this.isDark;
    },
});
Alpine.store('sidebar', {
    isOpen: true,

    toggle() {
        this.isOpen = !this.isOpen;
    },
});
Alpine.start();
