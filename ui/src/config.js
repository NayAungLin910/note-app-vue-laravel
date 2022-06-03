export const api_url = "http://localhost:8000/api";
export const image_url = "http://localhost:8000/";

import axios from "axios";

export const cusaxios = axios.create({
    baseURL: api_url,
})

const auth = localStorage.getItem('auth');

if(!auth){
    localStorage.setItem('auth', null);
}else if(auth == ''){
    localStorage.setItem('auth', null);
}

if(auth && auth !== 'null'){
    const token = JSON.parse(auth).token;
    cusaxios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}