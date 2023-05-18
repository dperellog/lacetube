import axios from 'axios';

const baseURL = process.env.BACKEND_API_URL
//const baseURL = 'http://api.lacetube.cat:8000';

const bckend = axios.create({
    baseURL : baseURL,
    headers: {
        "Access-Control-Allow-Origin" : "*"
    },
    withCredentials: true
});

bckend.defaults.withCredentials = true;

export {bckend as default, baseURL}