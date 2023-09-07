
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const settingsService = {
    Get: function () {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.get(`${_config.baseUrl}/api/admin/settings`, requestOptions).then(handleResponse);
    },
    Update: function (data) {
        const requestOptions = {
            headers: authHeader()
        };
        return Axios.put(`${_config.baseUrl}/api/admin/settings/${data._id}`,data, requestOptions).then(handleResponse);
    },
};




function handleResponse(response) {
    return response.data;
}