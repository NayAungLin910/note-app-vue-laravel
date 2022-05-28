export const api_url = "http://localhost:8000/api";
import axios from "axios";

export const cusaxios = axios.create({
    baseURL: api_url,
})

const auth = localStorage.getItem('auth');
if(auth !== 'null'){
    const token = JSON.parse(auth).token;
    cusaxios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}