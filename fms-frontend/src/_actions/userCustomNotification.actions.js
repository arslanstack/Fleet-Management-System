import { userCustomNotificationConstants } from '../_constants/userCustomNotification.constants';
import { userCustomNotificationService } from '../_services/userCustomNotification.service';

export const userCustomNotificationActions = {
    getAll: (id) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            userCustomNotificationService.getAll()
                .then(
                    userCustomNotifications => { dispatch(success(userCustomNotifications)); resolve(userCustomNotifications) },
                    error => { dispatch(failure(error)); reject(error) }
                );


            function request() { return { type: userCustomNotificationConstants.GETALL_REQUEST } }
            function success(userCustomNotifications) { return { type: userCustomNotificationConstants.GETALL_SUCCESS, userCustomNotifications } }
            function failure(error) { return { type: userCustomNotificationConstants.GETALL_FAILURE, error } }
        }),
    getSingle: (id) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            userCustomNotificationService.getSingle(id)
                .then(
                    userCustomNotificationObj => { dispatch(success(userCustomNotificationObj)); resolve(userCustomNotificationObj); },
                    error => { dispatch(failure(error)); reject(error); }
                );


            function request() { return { type: userCustomNotificationConstants.GETSINGLE_REQUEST } }
            function success(userCustomNotificationObj) { return { type: userCustomNotificationConstants.GETSINGLE_SUCCESS, userCustomNotificationObj } }
            function failure(error) { return { type: userCustomNotificationConstants.GETSINGLE_FAILURE, error } }
        }),
    add: (formData) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            userCustomNotificationService.add(formData)
                .then(
                    res => { dispatch(success(res)); resolve(res); },
                    error => { dispatch(failure(error)); reject(error); }
                );

            function request() { return { type: userCustomNotificationConstants.ADD_REQUEST } }
            function success(userCustomNotificationObj) { return { type: userCustomNotificationConstants.ADD_SUCCESS, userCustomNotificationObj } }
            function failure(error) { return { type: userCustomNotificationConstants.ADD_FAILURE, error } }
        }),
    update: (formData, id) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            dispatch({ type: userCustomNotificationConstants.UPDATE_REQUEST });
            userCustomNotificationService.update(formData, id)
                .then(
                    res => { dispatch(success(res)); resolve(res); },
                    error => { dispatch(failure(error)); reject(error); }
                );

            function request() { return { type: userCustomNotificationConstants.UPDATE_REQUEST } }
            function success(userCustomNotificationObj) { return { type: userCustomNotificationConstants.UPDATE_SUCCESS, userCustomNotificationObj } }
            function failure(error) { return { type: userCustomNotificationConstants.UPDATE_FAILURE, error } }
        }),

    delete: (id) => (dispatch) =>
        new Promise((resolve, reject) => {
            dispatch(request());
            dispatch({ type: userCustomNotificationConstants.DELETE_REQUEST });
            userCustomNotificationService.delete(id)
                .then(
                    res => { dispatch(success(res)); resolve(res); },
                    error => { dispatch(failure(error)); reject(error); }
                );

            function request() { return { type: userCustomNotificationConstants.DELETE_REQUEST } }
            function success(userCustomNotificationObj) { return { type: userCustomNotificationConstants.DELETE_SUCCESS, userCustomNotificationObj } }
            function failure(error) { return { type: userCustomNotificationConstants.DELETE_FAILURE, error } }
        }),
};