import axios from 'axios';

const baseURL = process.env.BACKEND_API_URL;

const bckend = axios.create({
    baseURL : baseURL,
    headers: {
        "Access-Control-Allow-Origin" : "*"
    },
    withCredentials: true
});

bckend.defaults.withCredentials = true;

export {bckend as default, baseURL}