
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const userCustomNotificationService = {
    add: function (data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.post(`${_config.baseUrl}/api/admin/user-custom-notifications`, data, requestOptions).then(handleResponse);
    },
    getAll: function () {
        const requestOptions = { headers: authHeader() };
        return Axios.get(`${_config.baseUrl}/api/admin/user-custom-notifications`, requestOptions).then(handleResponse);
    },
    getSingle: function (id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/user-custom-notifications/${id}`, requestOptions).then(handleResponse);
    },
    delete: function (id) {
        const requestOptions = {
            headers: authHeader()
        };
        debugger;
        return Axios.delete(`${_config.baseUrl}/api/admin/user-custom-notifications/${id}`, requestOptions).then(handleResponse);
    }
};

function handleResponse(response) {
    return response.data;
}