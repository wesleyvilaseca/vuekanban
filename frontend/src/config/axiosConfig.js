import Axios from "axios";

const apiUrl = "http://127.0.0.1:8001/api/v1/";
const TOKEN_NAME = 'sanctun';

export const Http = Axios.create({
    baseURL: apiUrl
})

export const HttpAuth = Axios.create({
    baseURL: apiUrl,
})

HttpAuth.interceptors.request.use(
    async (config) => {
        config.headers.authorization = `Bearer ${await localStorage.getItem(TOKEN_NAME)}`
        config.headers.accept = 'application/json'
        return config;
    }
)

HttpAuth.interceptors.request.use(response => {
    return response
}, error => {
    if (error.response) {
        //401 is not authorized
        if (error.response.status === 401) {
            localStorage.getItem(TOKEN_NAME);
            window.location.replace('/')
        }
    }
})

HttpAuth.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401 || error.response.status === 500) {
            window.location.href = '/';
        }
    });