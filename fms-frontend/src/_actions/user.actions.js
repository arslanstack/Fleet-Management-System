import { userConstants } from '../_constants/user.constants';
import { alertActions } from '.';
import { history } from '../_helpers';
import { userService } from '../_services/user.service';

export const userActions = {
    getAll: () => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            userService.getAll()
                .then(
                    users => { dispatch(success(users)); resolve(users); },
                    error => { dispatch(failure(error)); reject(error); }
                );


            function request() { return { type: userConstants.GETALL_REQUEST } }
            function success(users) { return { type: userConstants.GETALL_SUCCESS, users } }
            function failure(error) { return { type: userConstants.GETALL_FAILURE, error } }
        }),
    getSingle: (id) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            userService.getSingle(id)
                .then(
                    user => { dispatch(success(user)); resolve(user); },
                    error => { dispatch(failure(error)); reject(error); }
                );


            function request() { return { type: userConstants.GETSINGLE_REQUEST } }
            function success(user) { return { type: userConstants.GETSINGLE_SUCCESS, user } }
            function failure(error) { return { type: userConstants.GETSINGLE_FAILURE, error } }
        }),


    setStatus: (id, status) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch({ type: userConstants.SET_STATUS_REQUEST });
            userService.setStatus(id, status)
                .then(
                    res => { dispatch({ type: userConstants.SET_STATUS_SUCCESS, status }); resolve(res); },
                    error => { dispatch({ type: userConstants.SET_STATUS_FAILURE, error }); reject(error); }
                );
        }),

    setVerificationStatus: (id, verified) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch({ type: userConstants.SET_STATUS_REQUEST });
            userService.setVerifiedStatus(id, verified)
                .then(
                    res => { dispatch({ type: userConstants.SET_STATUS_SUCCESS, verified }); resolve(res); },
                    error => { dispatch({ type: userConstants.SET_STATUS_FAILURE, error }); reject(error); }
                );
        }),

};