
import { authHeader } from '../_helpers';
import _config from '../_config';
import Axios from 'axios';
export const userPackagesService = {
    getAll: function (id) {
        const requestOptions = { headers: authHeader() };
        return Axios.get(`${_config.baseUrl}/api/admin/user-packages/${id}`, requestOptions).then(handleResponse);
    }
};

function handleResponse(response) {
    return response.data;
}