
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const apiService = {
    type: function (route) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/${route}/b/type`, requestOptions).then(handleResponse);
    },
    getAll: function (route) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/${route}`, requestOptions).then(handleResponse);
    },
    filter: function (route, data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.post(`${_config.baseUrl}/api/admin/${route}/filter`, data, requestOptions).then(handleResponse);
    },
    getSingle: function (route, id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/${route}/${id}`, requestOptions).then(handleResponse);
    },
    add: function (route, data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.post(`${_config.baseUrl}/api/admin/${route}`, data, requestOptions).then(handleResponse);
    },
    update: function (route, data, id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.put(`${_config.baseUrl}/api/admin/${route}/${id}`, data, requestOptions).then(handleResponse);
    },
    delete: function (route, id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.delete(`${_config.baseUrl}/api/admin/${route}/${id}`, requestOptions).then(handleResponse);
    }
};




function handleResponse(response) {
    return response.data;
}