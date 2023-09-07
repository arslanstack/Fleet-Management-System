
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';

// import JWTHelper from '../_helpers/jwt-helper';
export const adminService = {
    login: function (email, password) {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        };

        return fetch(`${_config.baseUrl}/api/auth/admin/login`, requestOptions)
            .then(handleResponse)
            .then(res => {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                localStorage.setItem('token', JSON.stringify(res.token));
                return res.token;
            });
    },

    getCurrentAdmin: function () {

        // let token = JWTHelper.getToken();
        // if (token && !JWTHelper.isTokenExpired(token)) {
        //     return new Promise((resolve, reject) => {
        //         let admin = JWTHelper.decodeToken(token);
        //         if (admin) resolve(admin)
        //         else {
        const requestOptions = {
            method: 'GET',
            headers: authHeader()
        };

        return fetch(`${_config.baseUrl}/api/auth/admin/`, requestOptions)
            .then(handleResponse);
        //         }
        //     })


        // } else {
        //     return Promise.reject("Un Authenticated");
        // }


    },

    logout: function () {
        // remove user from local storage to log user out
        localStorage.removeItem('token');
    },

    getAll: function () {
        const requestOptions = {
            method: 'GET',
            headers: authHeader()
        };

        return fetch(`${_config.baseUrl}/api/admin/users`, requestOptions).then(handleResponse);
    },

    update: function (data, id) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.put(`${_config.baseUrl}/api/admins/${id}`, data, requestOptions).then(handleResponse1);
    },
 

};

function handleResponse1(response) {
    return response.data;
}


function handleResponse(response) {
    return response.text().then(text => {
        const data = text && JSON.parse(text);
        if (!response.ok) {
            if (response.status === 401) {
                // auto logout if 401 response returned from api
                adminService.logout();
                window.location.reload(true);
            }

            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }
        return data;

    });
}