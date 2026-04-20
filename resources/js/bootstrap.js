import axios from "axios";

window.axios = axios;

window.axios.deafults.headers.common['X-Requested-With'] = 'XMLTHttpRequest';
