
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const adminNotificationService = {
    getAll: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/notifications`, requestOptions).then(handleResponse);
    },
    unSeenlist: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/notifications/filter/unseen`, requestOptions).then(handleResponse);
    },
    getSingle: function (id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/notifications/${id}`, requestOptions).then(handleResponse);
    },
    add: function (data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.post(`${_config.baseUrl}/api/admin/notifications`, data, requestOptions).then(handleResponse);
    },
    allseen: function (data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.post(`${_config.baseUrl}/api/admin/notifications/set-allseen`, data, requestOptions).then(handleResponse);
    },
    update: function (data, id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.put(`${_config.baseUrl}/api/admin/notifications/${id}`, data, requestOptions).then(handleResponse);
    },
    delete: function (id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.delete(`${_config.baseUrl}/api/admin/notifications/${id}`, requestOptions).then(handleResponse);
    }
};




function handleResponse(response) {
    return response.data;
}