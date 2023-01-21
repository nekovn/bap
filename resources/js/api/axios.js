import axios from "axios";
const axiosInstance = axios.create({
    baseURL: process.env.MIX_API_URL,
    headers: {
        'accept': 'application/json',
    }
});
export default axiosInstance;
