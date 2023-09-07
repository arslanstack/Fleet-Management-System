
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const userService = {
    getAll: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/users?dateTime=${new Date().toISOString()}`, requestOptions).then(handleResponse);
    },
    getSingle: function (id) {
        const requestOptions = {
            method: 'GET',
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/users/${id}?dateTime=${new Date().toISOString()}`, requestOptions).then(handleResponse);
    },
    setStatus: function (id, status) {
        const requestOptions = {
            // method: 'POST',
            headers: authHeader(),
        };
        return Axios.post(`${_config.baseUrl}/api/admin/users/changeStatus/${id}`, { status: status, dateTime: new Date().toISOString() }, requestOptions).then(handleResponse);
        // return fetch(`${_config.baseUrl}/api/admin/users/changeStatus/${id}`, requestOptions).then(handleResponse);
    },
    setVerifiedStatus: function (id, verified) {
        const requestOptions = {
            // method: 'POST',
            headers: authHeader(),
        };
        return Axios.post(`${_config.baseUrl}/api/admin/users/changeStatus/${id}`, { verified: verified, dateTime: new Date().toISOString() }, requestOptions).then(handleResponse);
        // return fetch(`${_config.baseUrl}/api/admin/users/changeStatus/${id}`, requestOptions).then(handleResponse);
    },
    exportExcel: function (users) {
        const requestOptions = {
            // method: 'POST',
            headers: authHeader(),
        };
        return Axios.post(`${_config.baseUrl}/api/admin/users/export/excel`, { users }, requestOptions).then(handleResponse);
        // return fetch(`${_config.baseUrl}/api/admin/users/changeStatus/${id}`, requestOptions).then(handleResponse);
    }
};




function handleResponse(response) {
    return response.data;

    // return response.text().then(text => {
    //     const data = text && JSON.parse(text);
    //     console.log(data);

    //     if (!response.ok) {
    //         if (response.status === 401) {
    //             // auto logout if 401 response returned from api
    //             userService.logout();
    //             window.location.reload(true);
    //         }

    //         const error = (data && data.message) || response.statusText;
    //         return Promise.reject(error);
    //     }
    //     return data;

    // });
}